<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class MessageController extends Controller
{
    public function index()
    {
        return view('messages.create');
    }

    public function store(Request $request)
    {
        $message = $request->input('message');
        
        // Create payload with message and viewed status
        $payload = json_encode([
            'message' => $message
        ]);
        
        // Encrypt the payload
        $encrypted = base64_encode(Crypt::encryptString($payload));
        
        $uniqueToken = Str::random(32); // Generate a random token
        $url = URL::signedRoute('messages.show', ['token' => $uniqueToken, 'payload' => $encrypted]);

        return response()->json(['url' => $url]);
    }

    public function show(Request $request, $payload, $hash)
    {
        try {
            // Decrypt and decode payload
            $data = json_decode(Crypt::decryptString(base64_decode($payload)), true);
            
            // Show the message
            $message = $data['message'];
            
            return view('messages.show', [
                'message' => $message
            ]);
            
        } catch (\Exception $e) {
            return view('messages.expired');
        }
    }
}