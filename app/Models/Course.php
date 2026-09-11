<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'type',
        'details',
        'price',
        'original_price',
        'course_image_path',
        'course_image_fit',
        'course_category_id',
        'has_certificate',
        'access_duration_months',
        'requires_registration',
        'is_published',
        'rating_avg',
        'ratings_count',
        'created_by',
        'is_cohort',
        'cohort_starts_at',
        'waitlist_url',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'original_price' => 'decimal:2',
        'is_published' => 'boolean',
        'has_certificate' => 'boolean',
        'access_duration_months' => 'integer',
        'requires_registration' => 'boolean',
        'rating_avg' => 'decimal:2',
        'ratings_count' => 'integer',
        'is_cohort' => 'boolean',
        'cohort_starts_at' => 'date',
    ];

    /** The longest limited-access duration an admin can set; null means lifetime. */
    public const MAX_ACCESS_DURATION_MONTHS = 6;

    protected static function booted()
    {
        static::creating(function (Course $course) {
            if (! $course->slug) {
                $course->slug = static::generateUniqueSlug($course->title);
            }
        });
    }

    public static function generateUniqueSlug(string $title): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $i = 1;

        while (static::where('slug', $slug)->exists()) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function category()
    {
        return $this->belongsTo(CourseCategory::class, 'course_category_id');
    }

    public function weeks()
    {
        return $this->hasMany(CourseWeek::class)->orderBy('sort_order');
    }

    public function materials()
    {
        return $this->hasMany(CourseMaterial::class)->orderBy('sort_order');
    }

    public function orders()
    {
        return $this->hasMany(CourseOrder::class);
    }

    public function orderFor(?User $user): ?CourseOrder
    {
        if (! $user) {
            return null;
        }

        return $this->orders()
            ->where('user_id', $user->id)
            ->where('status', '!=', 'rejected')
            ->latest()
            ->first();
    }

    public function hasConfirmedOrderFor(?User $user): bool
    {
        return $this->orderFor($user)?->hasActiveAccess() ?? false;
    }

    public function registrations()
    {
        return $this->hasMany(CourseRegistration::class);
    }

    public function registrationFor(?User $user): ?CourseRegistration
    {
        if (! $user) {
            return null;
        }

        return $this->registrations()->where('user_id', $user->id)->first();
    }

    public function needsRegistrationFrom(?User $user): bool
    {
        return $this->requires_registration && ! $this->registrationFor($user);
    }

    public function reviews()
    {
        return $this->hasMany(CourseReview::class)->latest();
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getDiscountPercentageAttribute(): int
    {
        if ($this->original_price && $this->original_price > $this->price) {
            return (int) round((($this->original_price - $this->price) / $this->original_price) * 100);
        }

        return 0;
    }

    /**
     * Shapes a local course into the same array format
     * PartnerCoursesClient::toPublicArray() produces for a pulled course,
     * so partials/course-card.blade.php can render either without caring
     * which one it got. Unlike a pulled course, this one has a real page
     * on this site — purchase_url points there instead of off-site, and
     * is_local lets the card know not to open it in a new tab.
     *
     * @return array<string, mixed>
     */
    public function toPublicArray(): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'title' => $this->title,
            'type' => $this->type,
            'price' => (float) $this->price,
            'original_price' => $this->original_price !== null ? (float) $this->original_price : null,
            'discount_percentage' => $this->discount_percentage,
            'image_url' => $this->course_image_path,
            'has_certificate' => $this->has_certificate,
            'requires_registration' => $this->requires_registration,
            'access_duration_months' => $this->access_duration_months,
            'is_lifetime_access' => is_null($this->access_duration_months),
            'rating_avg' => (float) $this->rating_avg,
            'ratings_count' => $this->ratings_count,
            'category' => $this->category ? [
                'id' => $this->category->id,
                'name' => $this->category->name,
                'slug' => $this->category->slug,
            ] : null,
            'is_cohort' => $this->is_cohort,
            'purchase_url' => route('courses.show', $this),
            'is_local' => true,
        ];
    }

    public function recalculateRating(): void
    {
        $this->update([
            'rating_avg' => $this->reviews()->avg('rating') ?: 0,
            'ratings_count' => $this->reviews()->count(),
        ]);
    }
}
