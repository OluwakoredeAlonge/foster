<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseOrder extends Model
{
    protected $fillable = [
        'course_id',
        'user_id',
        'amount',
        'status',
        'reference',
        'access_code',
        'paid_claimed_at',
        'instructions_acknowledged_at',
        'confirmed_at',
        'access_expires_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_claimed_at' => 'datetime',
        'instructions_acknowledged_at' => 'datetime',
        'confirmed_at' => 'datetime',
        'access_expires_at' => 'datetime',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function markPaidClaimed(): void
    {
        $this->update([
            'status' => 'awaiting_confirmation',
            'paid_claimed_at' => now(),
            'instructions_acknowledged_at' => now(),
        ]);
    }

    public function confirm(string $accessCode): void
    {
        $months = $this->course->access_duration_months;

        $this->update([
            'status' => 'confirmed',
            'access_code' => $accessCode,
            'confirmed_at' => now(),
            'access_expires_at' => $months ? now()->addMonths($months) : null,
        ]);
    }

    /**
     * Whether this order currently unlocks course content — confirmed, and
     * (for a course with a limited access duration) not yet past its
     * access_expires_at. The order's status stays "confirmed" even after
     * it expires; this is what actually gates access.
     */
    public function hasActiveAccess(): bool
    {
        if ($this->status !== 'confirmed') {
            return false;
        }

        return ! $this->access_expires_at || $this->access_expires_at->isFuture();
    }

    public function isExpired(): bool
    {
        return $this->status === 'confirmed' && ! $this->hasActiveAccess();
    }

    public function reject(): void
    {
        $this->update(['status' => 'rejected']);
    }

    /**
     * Pull back access after it was already confirmed — for a mistaken
     * confirmation, a chargeback, or fraud discovered after the fact.
     * Content access is driven entirely by status === 'confirmed', so this
     * alone is enough to re-lock the course; the code and confirmation
     * record are kept for the audit trail rather than wiped.
     */
    public function revoke(): void
    {
        $this->update(['status' => 'revoked']);
    }

    /**
     * Restore access after a revoke — the original access code and
     * confirmation record were kept, so this just flips status back.
     */
    public function reinstate(): void
    {
        $this->update(['status' => 'confirmed']);
    }
}
