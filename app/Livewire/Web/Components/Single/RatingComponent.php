<?php

namespace App\Livewire\Web\Components\Single;

use App\Models\FcmToken;
use Livewire\Component;
use App\Models\Product;
use App\Models\ProductReview;
use App\Services\FirebaseService;
use Illuminate\Support\Facades\Auth;

class RatingComponent extends Component
{
    public $product;
    public $rating = 0;
    public $review;

    public function mount($id)
    {
        $this->product = Product::with('reviews.user')->findOrFail($id);
    }

    public function setRating($value)
    {
        $this->rating = $value;
    }

    public function saveReview()
    {
        if (!Auth::check()) {
            session()->flash('error', 'Please login to write a review.');
            return;
        }

        $this->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|max:2000',
        ]);

        ProductReview::updateOrCreate(
            [
                'product_id' => $this->product->id,
                'user_id'    => Auth::id(),
            ],
            [
                'rating' => $this->rating,
                'review' => $this->review,
                'approved' => true
            ]
        );

        $this->reset('rating', 'review');
        $this->product = $this->product->fresh(); // reload reviews


        session()->flash('success', 'Review submitted successfully!');
        $this->sendReviewNoti();
    }
public function sendReviewNoti()
{
    $userId = Auth::id();

    // Get FCM token
    $fcm = FcmToken::where('user_id', $userId)->first();

    if (!$fcm || !$fcm->token) {
        return [
            "status" => "error",
            "message" => "No FCM token found for user."
        ];
    }

    $token = $fcm->token;

    // Send notification
    $firebase = new FirebaseService();

    $response = $firebase->sendNotification(
        $token,
        "Thank you for your review!",
        "Your review helps others and improves our products.",
        [
            "type" => "product_review",
            "message" => "Thank you for submitting your review.",
            "user_id" => $userId
        ]
    );

    return [
        "status" => "success",
        "response" => $response
    ];
}

    public function render()
    {
        return view('livewire.web.components.single.rating-component');
    }
}
