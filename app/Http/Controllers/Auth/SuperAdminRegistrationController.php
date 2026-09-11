<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

/**
 * One-time superadmin account setup. Fosterheirs only ever needs a single
 * admin account (Dr. Soje's), so once that account exists this link is
 * permanently dead — anyone who clicks it again, including the person who
 * just used it, is bounced to the login page instead of a form that would
 * let a second admin be created.
 */
class SuperAdminRegistrationController extends Controller
{
    public function create(): View|RedirectResponse
    {
        if ($this->setupAlreadyDone()) {
            return $this->redirectAlreadyDone();
        }

        return view('auth.superadmin-register');
    }

    /**
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        if ($this->setupAlreadyDone()) {
            return $this->redirectAlreadyDone();
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Re-checked inside the lock: two requests racing through the
        // earlier check above could otherwise both pass it and both
        // create an admin.
        $user = DB::transaction(function () use ($request) {
            if ($this->setupAlreadyDone()) {
                throw ValidationException::withMessages([
                    'email' => 'Setup has already been completed by someone else.',
                ]);
            }

            return User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'admin',
            ]);
        });

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Welcome to Fosterheirs. Your admin account is set up — this setup link is now permanently disabled.');
    }

    private function setupAlreadyDone(): bool
    {
        return User::where('role', 'admin')->exists();
    }

    private function redirectAlreadyDone(): RedirectResponse
    {
        return redirect()->route('login')
            ->with('status', 'Superadmin setup has already been completed. Please log in.');
    }
}
