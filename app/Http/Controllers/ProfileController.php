<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\CompanyProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Display the company profile page.
     */
    public function index(): View
    {
        $profile = CompanyProfile::firstOrCreate([], [
            'company_name' => env('COMPANY_NAME', 'FingerSpot Integration'),
            'company_email' => env('COMPANY_EMAIL', 'admin@fingerspot.com'),
            'company_phone' => env('COMPANY_PHONE', '081234567890'),
            'company_address' => env('COMPANY_ADDRESS', 'Alamat perusahaan...'),
        ]);

        $settings = [
            'company_name' => $profile->company_name,
            'company_email' => $profile->company_email,
            'company_phone' => $profile->company_phone,
            'company_address' => $profile->company_address,
        ];

        return view('admin.profile', compact('settings'));
    }

    /**
     * Update the company profile information.
     */
    public function updateCompany(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'company_name' => 'nullable|string|max:255',
            'company_email' => 'nullable|email|max:255',
            'company_phone' => 'nullable|string|max:20',
            'company_address' => 'nullable|string',
        ]);

        $profile = CompanyProfile::first();
        if ($profile) {
            $profile->update($validated);
        } else {
            CompanyProfile::create($validated);
        }

        return redirect()->back()->with('message', '✅ Profil perusahaan berhasil diperbarui!');
    }
}
