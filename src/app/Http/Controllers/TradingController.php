<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChatMessageRequest;
use App\Models\ChatMessage;
use App\Models\ChatRoom;
use App\Models\Item;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            DB::table('chat_messages')
                ->where('chat_room_id', $chatRoom->id)
                ->where('user_id', '!=', $user->id)
                ->whereNull('read_at')
                ->update(['read_at' => now()]);

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

        // 評価チェック追加
        // 購入者の評価有無
        $buyerReview = Review::where('purchase_id', $purchase->id)
            ->where('reviewer_id', $purchase->user_id)
            ->first();

        // 出品者の評価有無
        $sellerReview = Review::where('purchase_id', $purchase->id)
            ->where('reviewer_id', $item->user_id)
            ->first();

        $showReviewForm = request()->query('review') == '1';

        if ($isSeller && $buyerReview && !$sellerReview) {
            $showReviewForm = true;
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
            'sidebarTrades',
            'showReviewForm'
        ));
    }

    public function sendMessage(ChatMessageRequest $request, $chatRoomId) 
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

        $chatRoom->last_message_at = now();
        $chatRoom->save();

        return redirect()->back();
    }

    public function updateMessage(ChatMessageRequest $request, $chatRoomId, $messageId)
    {
        $chatMessage = ChatMessage::where('id', $messageId)
            ->where('chat_room_id', $chatRoomId)
            ->firstOrFail();

        if ($chatMessage->user_id !== Auth::id()) {
            abort('403');
        }

        $chatMessage->message = $request->message;
        $chatMessage->read_at = null;
        $chatMessage->save();

        return back();
    }

    public function deleteMessage($chatRoomId, $messageId)
    {
        $chatMessage = ChatMessage::where('id', $messageId)
            ->where('chat_room_id', $chatRoomId)
            ->firstOrFail();

        if ($chatMessage->user_id !== Auth::id()) {
            abort('403');
        }

        $chatMessage->delete();

        return back();
    }
}
