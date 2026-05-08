<?php

namespace App\Http\Controllers;

use App\Models\UserDetail;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserDetailsController extends Controller
{

    public function index()
    {
        $user = User::with('detail')
            ->where('id', Auth::id())
            ->first();

        return response()->json([
            'status' => 'success',
            'user' => $user
        ]);
    }
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'phone' => 'nullable|string|max:20',
            'location' => 'nullable|string|max:255',
            'privacy' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10000',
        ]);

        // Handle image upload
        $imagePath = null;

        if ($request->hasFile('image')) {

            $imagePath = $request->file('image')
                ->store('profiles', 'public');
        }

        // Create or update user detail
        $userDetail = UserDetail::updateOrCreate(

        // Find by user_id
            [
                'user_id' => $user->id
            ],

            // Update values
            [
                'phone' => $validated['phone'] ?? null,

                'location' => $validated['location'] ?? null,

                'privacy' => $validated['privacy'] ?? 0,

                // only update image if uploaded
                'image' => $imagePath
                    ? $imagePath
                    : optional($user->detail)->image,
            ]
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Profile updated successfully',
            'user' => $user->load('detail')
        ]);
    }
}
