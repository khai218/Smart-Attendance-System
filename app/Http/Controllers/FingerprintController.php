<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FingerprintController extends Controller
{
    public function register(Request $request)
    {
        // You may add any validation here
        // Trigger the ESP32 to register a fingerprint
        $response = Http::post('http://192.168.1.1/register'); // Adjust to your ESP32's IP

        // Check if the request was successful and return a plain text response
        if ($response->successful()) {
            return "Fingerprint registration triggered successfully.";
        } else {
            return "Failed to trigger fingerprint registration.";
        }
    }

    public function verify(Request $request)
    {
        // You may add any validation here
        // Trigger the ESP32 to verify a fingerprint
        $response = Http::post('http://192.168.1.1/verify'); // Adjust to your ESP32's IP

        // Check if the request was successful and return a plain text response
        if ($response->successful()) {
            return "Fingerprint verification triggered successfully.";
        } else {
            return "Failed to trigger fingerprint verification.";
        }
    }
}
