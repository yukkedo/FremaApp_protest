<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Condition;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Like;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class  ItemController extends Controller
{
    public function index()
    {
        $items = Item::all();
        return view('item', compact('items'));
    }

    // 商品詳細ページの取得
    public function getDetail($item_id)
    {
        $item = Item::with('categories', 'condition')->findOrFail($item_id);
        $user = auth()->user();
        $guestToken = Cookie::get('guest_token');

        // いいね数の取得
        $likeCount =  Like::where('item_id', $item->id)->count();

        // いいね済かどうか
        $isLiked = false;
        if ($user) {
            $isLiked = Like::where('item_id', $item->id)
                ->where('user_id', $user->id)
                ->exists();
        } elseif($guestToken) {
            $isLiked = Like::where('item_id', $item->id)
                ->where('guest_token', $guestToken)
                ->exists();
        }
        // ビューに商品情報といいね状態を渡す
        return view('detail', compact('item', 'likeCount', 'isLiked'));
    }

    // いいね追加・削除機能
    public function like(Request $request)
    {
        $item_id = $request->input('item_id');
        $item = Item::find($item_id);
        $user = auth()->user();

        if($user) {
            // ログイン済ユーザーの処理　既存のいいねを確認
            $isLiked = Like::where('item_id', $item->id)
                ->where('user_id', $user->id)
                ->exists();
            
            if($isLiked) {
                // いいねの解除
                Like::where('item_id', $item->id)
                    ->where('user_id', $user->id)
                    ->delete();
            } else {
                // いいねの追加
                Like::create([
                    'item_id' => $item->id,
                    'user_id' => $user->id,
                ]);
            }
        } else {
            // 未認証ユーザーの処理
            $guestToken = Cookie::get('guest_token');

            if (!$guestToken) {
            $guestToken = Str::uuid()->toString();
            Cookie::queue('guest_token', $guestToken, 60 * 24 * 30); // 30日間有効
            }

            $isLiked = Like::where('item_id', $item->id)
                ->where('guest_token', $guestToken)
                ->exists();

            if ($isLiked) {
                // いいねの解除
                Like::where('item_id', $item->id)
                    ->where('guest_token', $guestToken)
                    ->delete();
            } else {
                // いいねの追加
                Like::create([
                    'item_id' => $item->id,
                    'guest_token' => $guestToken,
                ]);
            }
        }
        return back();
    }
    
    public function getSell()
    {
        $categories = Category::all();
        $conditions = Condition::all();
        return view('sell', compact('categories', 'conditions'));
    }

    public function getPurchase($itemId)
    {
        $item = Item::findOrFail($itemId);
        $user = Auth::user();
        $profile = $user->profile;
        
        return view('purchase', compact('item', 'profile'));
    }

    public function getChangeAddress()
    {
        return view('change_address');
    }
}
