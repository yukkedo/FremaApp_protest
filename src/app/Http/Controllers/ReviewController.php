<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\TransactionCompletedMail;

class ReviewController extends Controller
{
    public function store(Request $request, $purchaseId)
    {
        $purchase = Purchase::find($purchaseId);
        $userId = Auth::id();

        if ($userId === $purchase->user_id) {
            $reviewerId = $userId;
            $reviewedId = $purchase->item->user_id;

            $isBuyerReview = true;
        } elseif ($userId === $purchase->item->user_id) {
            $reviewerId = $userId;
            $reviewedId = $purchase->user_id;

            $isBuyerReview = false;
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

        if ($isBuyerReview) {
            $seller = $purchase->item->user;

            Mail::to($seller->email)
                ->send(new TransactionCompletedMail($purchase));
        }

        return redirect('/');
    }
}
