<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        Log::info('User instance type: ' . get_class($user)); // Debug statement
        $totalBooksBorrowed = $user->borrowedBooks()->count();
        $currentlyBorrowed = $user->borrowedBooks()->whereNull('returned_at')->count();
        $overdueBooks = $user->borrowedBooks()->whereNull('returned_at')->where('due_date', '<', now())->count();
        $finesDue = $overdueBooks * 0.50; // Example: $0.50 per overdue book

        return view('profile', compact('totalBooksBorrowed', 'currentlyBorrowed', 'overdueBooks', 'finesDue'));
    }
    
    public function show()
    {
        $user = Auth::user();
        $totalBooksBorrowed = $user->borrowedBooks()->count();
        $currentlyBorrowed = $user->borrowedBooks()->whereNull('returned_at')->count();
        $overdueBooks = $user->borrowedBooks()->whereNull('returned_at')->where('due_date', '<', now())->count();
        $finesDue = $overdueBooks * 0.50; // Example: $0.50 per overdue book

        return view('profile', compact('totalBooksBorrowed', 'currentlyBorrowed', 'overdueBooks', 'finesDue'));
    }

    public function edit()
    {
        return view('profile.edit');
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        Log::info('User instance type: ' . get_class($user)); // Debug statement

        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                'contact_no' => 'nullable|string|max:20',
                'address' => 'nullable|string|max:500',
                'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
            ]);

            $data = $request->only(['name', 'email', 'contact_no', 'address']);
            if (!$user instanceof \App\Models\User) {
                Log::error('User is not an instance of User model.');
                return redirect()->back()->withErrors(['user' => 'User not found.']);
            }
            $data['profile_picture'] = $request->file('profile_picture') ? $request->file('profile_picture')->store('images', 'public') : null;

            if ($request->hasFile('profile_picture')) {
                // Delete old picture if it exists and isn't the default or null
                if (isset($user->profile_picture) && $user->profile_picture && $user->profile_picture !== 'images-1-10.png') {
                    Storage::delete('public/images/' . $user->profile_picture);
                }
            }

            $user->update($data);
            Log::info('Profile picture updated: ' . $data['profile_picture']);
            return redirect()->route('user.profile')->with('success', 'Profile updated successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation errors: ' . json_encode($e->errors()));
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }
}
