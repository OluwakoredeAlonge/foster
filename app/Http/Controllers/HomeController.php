<?php

namespace App\Http\Controllers;

use App\Exceptions\PartnerCoursesApiException;
use App\Models\Service;
use App\Models\TeamMember;
use App\Services\PartnerCoursesClient;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /** How many pulled courses the homepage teases before "Load More". */
    private const FEATURED_COURSE_COUNT = 4;

    public function index(PartnerCoursesClient $partnerCourses)
    {
        $services = Service::visible()->ordered()->get();
        $teamMembers = TeamMember::visible()->ordered()->get();

        $featuredCourses = [];
        try {
            $featuredCourses = array_slice(
                $partnerCourses->visiblePublicList(1)['items'],
                0,
                self::FEATURED_COURSE_COUNT
            );
        } catch (PartnerCoursesApiException $e) {
            Log::error('Homepage could not load featured courses.', ['error' => $e->getMessage()]);
        }

        return view('welcome', compact('services', 'teamMembers', 'featuredCourses'));
    }
}
