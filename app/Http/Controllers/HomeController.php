<?php

namespace App\Http\Controllers;

use App\Exceptions\PartnerCoursesApiException;
use App\Models\BlogPost;
use App\Models\Book;
use App\Models\Course;
use App\Models\LandingPageSetting;
use App\Models\Service;
use App\Models\TeamMember;
use App\Models\Testimonial;
use App\Services\PartnerCoursesClient;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /** How many courses the homepage teases before "Load More". */
    private const FEATURED_COURSE_COUNT = 4;

    /** How many blog posts the homepage teases before "Read All Articles". */
    private const FEATURED_BLOG_POST_COUNT = 6;

    public function index(PartnerCoursesClient $partnerCourses)
    {
        $landingPage = LandingPageSetting::current();
        $services = Service::visible()->ordered()->get();
        $teamMembers = TeamMember::visible()->ordered()->get();
        $books = Book::visible()->ordered()->get();
        $blogPosts = BlogPost::published()->latest('published_at')->take(self::FEATURED_BLOG_POST_COUNT)->get();
        $testimonials = Testimonial::visible()->ordered()->get();

        // Local, imported courses lead — they have a real page and
        // checkout on this site. Still-external ("pulled") courses fill
        // any remaining slots and link out to the partner's own page,
        // since this app doesn't proxy their checkout.
        $localCourses = Course::where('is_published', true)
            ->with('category')
            ->latest()
            ->get()
            ->map->toPublicArray()
            ->all();

        $externalCourses = [];
        try {
            $externalCourses = $partnerCourses->visiblePublicList(1)['items'];
        } catch (PartnerCoursesApiException $e) {
            Log::error('Homepage could not load featured courses.', ['error' => $e->getMessage()]);
        }

        $featuredCourses = array_slice([...$localCourses, ...$externalCourses], 0, self::FEATURED_COURSE_COUNT);

        return view('welcome', compact(
            'landingPage', 'services', 'teamMembers', 'books', 'blogPosts', 'testimonials', 'featuredCourses'
        ));
    }
}
