<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest;
use App\Models\Profile;
use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Item;
use App\Models\Purchase;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        $user = Auth::user();
        $tab = $request->query('tab', 'sell');

        $items = [];
        if ($tab === 'sell') {
            $items = Item::where('user_id', $user->id)->get();
        } elseif ($tab === 'buy') {
            $purchasedId = Purchase::where('user_id', $user->id)->pluck('item_id');
            $items = Item::whereIn('id', $purchasedId)->get();
        }
        return view('mypage', compact('user', 'tab', 'items'));
    }

    public function profile()
    {
        $fromRegister = Session::pull('user_name');
        $user = Auth::user();

        if ($fromRegister) {
            $userName = $user->name;
            return view('edit_mypage', compact('userName'));
        } else {
            $profile = $user->profile ?? new Profile();
            return view('edit_mypage', compact('user', 'profile'));
        }
    }

    public function imageEdit(ProfileRequest $request)
    {
        $path = $request->file('image')->store('public/user_img');
        $filename = basename($path);
        $publicPath = 'user_img/' . $filename;
        session(['profile.image_path'  => $publicPath]);
        
        return back();
    }

    public function edit(AddressRequest $request)
    {
        $profile = auth()->user()->profile ?? new Profile();
        $profile->user_id = auth()->id();
        $profile->postcode = $request->postcode;
        $profile->address = $request->address;
        $profile->building = $request->building;

        if (session('profile.image_path')) {
            $profile->image = str_replace('storage/', '', session('profile.image_path'));
            session()->forget('profile.image_path');
        }

        $profile->save();

        return redirect('/');
    }

    public function getChangeAddress(Request $request, $itemId)
    {
        $profile = Profile::where('user_id', Auth::id())->first();
        $item = Item::find($itemId);

        return view('change_address', [
            'profile' => $profile,
            'item' => $item
        ]);
    }

    public function addressUpdate(Request $request, $itemId)
    {
        $profile = Profile::where('user_id', Auth::id())->first();

        if ($profile) {
            $profile->update([
                'postcode' => $request->postcode,
                'address' => $request->address,
                'building' => $request->building,
            ]);
        }
        return redirect('/purchase/' . $itemId);
    }
}
