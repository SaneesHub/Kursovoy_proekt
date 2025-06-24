<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\ServiceActivation;
use App\Models\Service;
use App\Models\Invoice;
use App\Models\User;
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
    public function index()
    {
        $user = Auth::user();
        $userId = Auth::user()->id_user;
        $services = ServiceActivation::where('id_user', $userId)
            ->with('service') // ensure relation is defined
            ->get();
        $users = [];
        if ($user->id_role == 1) {
            $users = User::where('id_role', '!=', 1)->get(); // кроме других админов
        }

        return view('dashboard', compact('services', 'users'));
    }
    public function services()
    {
        $services = ServiceActivation::with('service')
            ->where('id_user', Auth::id())
            ->get();

        return view('profile.services', compact('services'));
    }
    public function invoices()
    {
        $invoices = Invoice::with('service')
            ->where('id_user', Auth::user()->id_user)
            ->get();

        return view('profile.invoices', compact('invoices'));
    }
}
