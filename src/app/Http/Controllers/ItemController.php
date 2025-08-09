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
use App\Models\ChatRoom;
use App\Models\Comment;
use App\Models\Profile;
use App\Models\Purchase;
use Illuminate\Support\Facades\DB;

class  ItemController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $tab = $request->query('tab', 'all');

        if($tab === 'mylist')
        {
            if(auth()->check()){
                $user = auth()->user();
                $likes = Like::where('user_id', $user->id)->get();
                $items = $likes->map(function ($like){
                    return $like->item;
                });
            } else {
                $items = collect();
            }
        } else {
            $query = Item::query()->with(['purchase']);

            if($search) {
                $query->where('name', 'LIKE', "%{$search}%");
            } 
            if(auth()->check()) {
                $user = auth()->user();
                $query->where('user_id', "!=", $user->id);
            }
            $items = $query->get();
        }
        return view('item', compact('items', 'search', 'tab'));
    }

    public function getDetail($item_id)
    {
        $item = Item::with(['categories', 'condition', 'comments.user'])->findOrFail($item_id);

        $user = auth()->user();
        $guestToken = Cookie::get('guest_token');

        $likeCount =  Like::where('item_id', $item->id)->count();

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

        $comments = $item->comments()->with('user.profile')->latest()->get();
        $commentCount = $comments->count();

        return view('detail', compact('item', 'likeCount', 'isLiked', 'comments', 'commentCount'));
    }

    public function like(Request $request, $item_id)
    {
        $item = Item::find($item_id);
        $user = auth()->user();

        if($user) {
            $isLiked = Like::where('item_id', $item->id)
                ->where('user_id', $user->id)
                ->exists();
            
            if($isLiked) {
                Like::where('item_id', $item->id)
                    ->where('user_id', $user->id)
                    ->delete();
            } else {
                Like::create([
                    'item_id' => $item->id,
                    'user_id' => $user->id,
                ]);
            }
        } else {
            $guestToken = Cookie::get('guest_token');

            if (!$guestToken) {
            $guestToken = Str::uuid()->toString();
            Cookie::queue('guest_token', $guestToken, 60 * 24 * 30); 
            }

            $isLiked = Like::where('item_id', $item->id)
                ->where('guest_token', $guestToken)
                ->exists();

            if ($isLiked) {
                Like::where('item_id', $item->id)
                    ->where('guest_token', $guestToken)
                    ->delete();
            } else {
                Like::create([
                    'item_id' => $item->id,
                    'guest_token' => $guestToken,
                ]);
            }
        }
        return back();
    }

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

        $tradingPurchased = Purchase::where('item_id', $itemId)
            ->where('status', 0)
            ->exists();

        if($tradingPurchased) {
            return redirect('/');
        }

        DB::transaction(function () use ($item){
            $purchase = Purchase::create([
                'user_id' => Auth::id(),
                'item_id' => $item->id,
                'status' => 0,
            ]);

            $chatRoom = ChatRoom::create([
                'purchase_id' => $purchase->id,
            ]);
        });

        return redirect('/');
    }

    public function storeImage(Request $request)
    {
        $path = $request->file('image')->store('public/item_img');
        $filename = basename($path);
        $publicPath = 'storage/item_img/' . $filename;

        session(['image.path' => $publicPath]);

        return back();
    }

    public function storeSell(Request $request)
    {
        $item = new Item();
        $item->user_id = auth()->id();
        $item->image = session('image.path');
        $item->condition_id = $request->condition_id;
        $item->name = $request->name;
        $item->brand = $request->brand;
        $item->description = $request->description;
        $item->price = $request->price;
        $item->is_purchased = 0;
        $item->save();

        $item->categories()->sync($request->categories);
        session()->forget('image.path');

        return redirect('/');
    }
}
