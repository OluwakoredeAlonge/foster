@extends('layouts.admin')

@section('title', 'My Account')

@section('content')
<div class="flex-1 p-4 sm:p-6 max-w-2xl mx-auto space-y-6">

    <div class="mb-2">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 tracking-tight">My Account</h2>
        <p class="mt-1 text-sm text-gray-600">Update your name and email, or change your password.</p>
    </div>

    <div class="bg-white p-5 sm:p-6 rounded-2xl shadow-sm border border-gray-200">
        @include('profile.partials.update-profile-information-form')
    </div>

    <div class="bg-white p-5 sm:p-6 rounded-2xl shadow-sm border border-gray-200">
        @include('profile.partials.update-password-form')
    </div>
</div>
@endsection
