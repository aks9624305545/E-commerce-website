<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;
use App\Services\UsersServices;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public $usersServices;
    public function __construct(UsersServices $usersServices)
    {
        $this->usersServices = $usersServices;
    }

    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function getUsers(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = $this->usersServices->UserVendorWise();
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="' . route('profile.edit', ['id' => $row->id]) . '" class="edit btn btn-primary btn-sm">Edit</a>';
                        $deleteBtn = '<button onclick="confirmDelete(' . $row->id . ')" class="btn btn-danger btn-sm mt-2">Delete</button>';
                        return $btn . $deleteBtn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            return view('dashboard');
        } catch (\Exception $e) {
            Log::error('Error fetching categories for DataTables: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong while fetching categories.');
        }
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

    public function deleteUsers(Request $request)
    {
        try {
            $deleted = $this->usersServices->deleteUsersById($request->id);
            if ($deleted) {
                return redirect()->back()->with('success', 'Products deleted successfully.');
            } else {
                return redirect()->back()->with('error', 'Failed to delete products.');
            }
        } catch (\Exception $e) {
            Log::error('Products deletion failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong! Please try again.');
        }
    }

    public function profileImage(Request $request){
        $updateProfile = $this->usersServices->updateProfileImageByUsersId($request);
        if ($updateProfile) {
            return redirect()->route('profile.edit')->with('success', 'Profile updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to update Profile.');
        }
    }
}
