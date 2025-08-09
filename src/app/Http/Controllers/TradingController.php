<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\ChatRoom;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TradingController extends Controller
{
    public function showChat($item_id)
    {
        $user = Auth::user();

        $item = Item::with(['user', 'purchase.user', 'purchase.chatRoom.messages.user'
        ])
            ->findOrFail($item_id);

        $purchase = $item->purchase;

        $chatRoom = $purchase->chatRoom;
        $messages = collect();
        if ($chatRoom) {
            $messages = $chatRoom->messages()
                ->with('user')
                ->orderBy('created_at', 'asc')
                ->get();

            $messages->transform(function ($message) use ($user) {
                $message->is_right = ($message->user_id === $user->id);
                return $message;
            });
        }

        $isSeller = ($user->id === $item->user_id);
        $isBuyer = !$isSeller;

        $sellerId = $item->user_id;
        $buyerId = $purchase->user_id;

        if ($isSeller) {
            // 出品者側
            $leftUser = $buyerId;
            $rightUser = $sellerId;
            $otherParty = $purchase->user;
        } else {
            // 購入者側
            $leftUser = $sellerId;
            $rightUser = $buyerId;
            $otherParty = $item->user;
        }

        // サイドバー用の取引リスト(出品者のみ)
        $sidebarTrades = collect();
        if ($isSeller) {
            $sidebarTrades = Item::where('user_id', $user->id)
                ->whereHas('purchase', function ($q) use ($purchase) {
                    $q->where('status', 0)
                    ->where('id', '<>', $purchase->id);
                })
                ->with('purchase.user')
                ->get();
        }

        return view('trading_chat', compact(
            'item',
            'purchase',
            'chatRoom',
            'messages',
            'isSeller',
            'isBuyer',
            'leftUser',
            'rightUser',
            'otherParty',
            'sidebarTrades'
        ));
    }

    public function sendMessage(Request $request, $chatRoomId) 
    {
        $chatRoom = ChatRoom::findOrFail($chatRoomId);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('chat_images', 'public');
        }

        ChatMessage::create([
            'chat_room_id' => $chatRoom->id,
            'user_id' => Auth::id(),
            'message' => $request->input('message'),
            'image' => $imagePath,
        ]);

        return redirect()->back();
    }
}
