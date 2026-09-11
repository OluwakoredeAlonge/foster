<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\TeamMember;

class HomeController extends Controller
{
    public function index()
    {
        $services = Service::visible()->ordered()->get();
        $teamMembers = TeamMember::visible()->ordered()->get();

        return view('welcome', compact('services', 'teamMembers'));
    }
}
