<?php

namespace App\Http\Controllers;

use App\Models\FcmToken;
use Illuminate\Http\Request;
use App\Services\FirebaseService;

class NotificationController extends Controller
{
    public function saveToken(Request $request)
{
    FcmToken::updateOrCreate(
        ['token' => $request->token],
        ['user_id' => auth()->id()]
    );

    return response()->json(['status' => 'success']);
}

public function testNotification()
{
    $tokens = FcmToken::pluck('token')->toArray();

    $firebase = new FirebaseService();

    $responses = [];

    foreach ($tokens as $token) {
        $responses[] = $firebase->sendNotification(
            $token,
            "Welcome to Our App!",
            "We are excited to have you onboard.",
            [
                "type" => "welcome",
                "message" => "Thanks for joining us"
            ]
        );
    }

    return $responses;
}


}
