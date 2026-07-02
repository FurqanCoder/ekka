<?php

namespace App\Services;

use Google\Auth\Credentials\ServiceAccountCredentials;
use Illuminate\Support\Facades\Http;

class FirebaseService
{
    public function sendNotification($token, $title, $body, $data = [])
    {
        $projectId = env('FIREBASE_PROJECT_ID');
        $serviceAccount = storage_path('app/firebase/credentials.json');

        $scopes = ['https://www.googleapis.com/auth/firebase.messaging'];

        $credentials = new ServiceAccountCredentials($scopes, $serviceAccount);

        $authToken = $credentials->fetchAuthToken();
        $accessToken = $authToken['access_token'];

        $url = "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send";

        $payload = [
            "message" => [
                "token" => $token,
                "notification" => [
                    "title" => $title,
                    "body" => $body,
                ],
                "data" => $data
            ]
        ];

        $response = Http::withToken($accessToken)
            ->post($url, $payload);

        return $response->json();
    }
}
