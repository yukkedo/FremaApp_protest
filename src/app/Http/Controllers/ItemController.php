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
use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Profile;
use App\Models\Purchase;

class  ItemController extends Controller
{
    public function index(Request $request)
    {
        // 検索機能
        $search = $request->input('search');
        // $items = Item::where('name', 'LIKE', "%{$search}%")->get();
        // マイリスト
        $tab = $request->query('tab', 'all');
        if($tab === 'mylist' && auth()->check())
        {
            $user = auth()->user();
            $likes = Like::where('user_id', $user->id)->get();
            $items = $likes->map(function ($like){
                return $like->item;
            });
        } else {
            if($search) {
                $items = Item::where('name', 'LIKE', "%{$search}%")->get();
            } else {
                $items = Item::all();
            }
        }
        return view('item', compact('items', 'search', 'tab'));
    }

    // 商品詳細ページの取得
    public function getDetail($item_id)
    {
        $item = Item::with(['categories', 'condition', 'comments.user'])->findOrFail($item_id);

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

        // コメントの取得
        $comments = $item->comments()->with('user')->latest()->get();
        // コメント数の取得
        $commentCount = $comments->count();

        // ビューに商品情報といいね状態を渡す
        return view('detail', compact('item', 'likeCount', 'isLiked', 'comments', 'commentCount'));
    }

    // いいね追加・削除機能
    public function like(Request $request, $item_id)
    {
        // $item_id = $request->input('item_id');
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

    // コメント機能 
    public function comment(CommentRequest $request)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        Comment::create([
            'content' => $request->content,
            'user_id' => auth()->id(),
            'item_id' => $request->item_id,
        ]);

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
        
        $paymentMethod = request()->input('payment_method');
        $displayPayment = $paymentMethod ?? 'convenience';

        return view('purchase', compact('item', 'profile','paymentMethod', 'displayPayment'));
    }

    public function purchaseItem(Request $request, $itemId)
    {
        $item = Item::find($itemId);

        if($item && $item->is_purchased === 0){
            $item->is_purchased = 1;
            $item->save();

            Purchase::create([
                'user_id' => Auth::id(),
                'item_id' => $item->id,
            ]);

            return redirect('/');
        }
    }

}
