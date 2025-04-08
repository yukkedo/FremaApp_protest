<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest;
use App\Models\Profile;
use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    public function show()
    {
        $user = AUth::user();
        return view('mypage', compact('user'));
    }

    public function profile()
    {
        $fromRegister = Session::pull('user_name');
        $user = Auth::user();

        if($fromRegister)
        {
            $userName = $user->name;
            return view('edit_mypage', compact('userName'));
        } else {
            $profile = $user->profile ?? new Profile();
            return view('edit_mypage', compact('user', 'profile'));
        }
    }

    public function edit(AddressRequest $request)
    {
        $validated = $request->validated();
        $user = Auth::user();

        $profile = $user->profile ?? new Profile();  // プロフィールが存在しなければ新規作成
        $profile->user_id = $user->id;
        $profile->postcode = $validated['postcode'];
        $profile->address = $validated['address'];
        $profile->building = $validated['building'];
        $profile->save();

        Session::put('profile_completed_' . $user->id, true);
        
        return redirect('/');
    }

    
}
