<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, $purchaseId)
    {
        $purchase = Purchase::find($purchaseId);
        $userId = Auth::id();

        if ($userId === $purchase->user_id) {
            $reviewerId = $userId;
            $reviewedId = $purchase->item->user_id;
        } elseif ($userId === $purchase->item->user_id) {
            $reviewerId = $userId;
            $reviewedId = $purchase->user_id;
        }

        Review::create([
            'purchase_id' => $purchase->id,
            'reviewer_id' => $reviewerId,
            'reviewed_id' => $reviewedId,
            'rating' => $request->rating,
        ]);

        $reviewCount = Review::where('purchase_id', $purchase->id)->count();
        if ($reviewCount >= 2) {
            $purchase->update(['status' => 1]);
        }

        return redirect('/');
    }
}
