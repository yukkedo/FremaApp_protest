<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest;
use App\Models\Profile;
use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
use App\Models\ChatMessage;
use App\Models\ChatRoom;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Item;
use App\Models\Purchase;
use App\Models\Review;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        $user = Auth::user();
        $tab = $request->query('tab', 'sell');

        $items = collect();
        $chatRooms = collect();
        $unreadCounts = [];
        $totalUnreadCount = 0;

        $purchasedTradingIds = Purchase::where('user_id', $user->id)
            ->where('status', 0)
            ->pluck('item_id');

        $sellingTradingIds = Purchase::whereHas('item', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
            ->where('status', 0)
            ->pluck('item_id');

        $allTradingIds = $purchasedTradingIds->merge($sellingTradingIds)->unique();

        $purchases = Purchase::whereIn('item_id', $allTradingIds)->get()->keyBy('item_id');

        $chatRoomIds = [];
        $lastMessageMap = [];
        $itemChatRoomMap = [];

        foreach ($purchases as $purchase) {
            $chatRoom = ChatRoom::where('purchase_id', $purchase->id)->first();
            if ($chatRoom) {
                $itemChatRoomMap[$purchase->item_id] = $chatRoom->id;
                $lastMessageMap[$purchase->item_id] = $chatRoom->last_message_at;
                $chatRoomIds[] = $chatRoom->id;
            }
        }

        if (!empty($chatRoomIds)) {
            $unreadCounts = DB::table('chat_messages')
                ->select('chat_room_id', DB::raw('COUNT(*) as unread_count'))
                ->whereIn('chat_room_id', $chatRoomIds)
                ->where('user_id', '!=', $user->id)
                ->whereNull('read_at')
                ->groupBy('chat_room_id')
                ->pluck('unread_count', 'chat_room_id');

            $totalUnreadCount = $unreadCounts->sum();
        }

        if ($tab === 'sell') {
            $items = Item::where('user_id', $user->id)->get();
        } elseif ($tab === 'buy') {
            $purchasedCompletedIds = Purchase::where('user_id', $user->id)
                ->where('status', 1)
                ->pluck('item_id');
            $items = Item::whereIn('id', $purchasedCompletedIds)->get();
        } elseif ($tab === 'trading') {
            $items = Item::whereIn('id', $allTradingIds)
                ->get()
                ->sortByDesc(function ($item) use ($lastMessageMap) {
                    return $lastMessageMap[$item->id] ?? null;
                })
                ->values();
        } else {
            $items = collect();
        }

        $averageRating = Review::where('reviewed_id', $user->id)->avg('rating');
        if ($averageRating) {
            $averageRating = round($averageRating);
        }
        
        return view('mypage', compact(
            'user', 
            'tab', 'items', 
            'unreadCounts', 
            'itemChatRoomMap', 
            'totalUnreadCount',
            'averageRating'
        ));
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
