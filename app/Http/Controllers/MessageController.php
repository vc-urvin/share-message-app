<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
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
            'message' => $message,
            'viewed' => false
        ]);
        
        // Encrypt the payload
        $encrypted = base64_encode(Crypt::encryptString($payload));
        
        // Generate verification hash
        $hash = hash_hmac('sha256', $encrypted, config('app.key'));
        
        // Generate URL
        $url = route('messages.show', [
            'payload' => $encrypted,
            'hash' => $hash
        ]);
        
        return response()->json(['url' => $url]);
    }

    public function show($payload, $hash)
    {
        // Verify hash
        if (!hash_equals(hash_hmac('sha256', $payload, config('app.key')), $hash)) {
            return view('messages.expired');
        }

        try {
            // Decrypt and decode payload
            $data = json_decode(Crypt::decryptString(base64_decode($payload)), true);
            
            // Check if already viewed
            if ($data['viewed'] === true) {
                return view('messages.expired');
            }
            
            // Mark as viewed and encrypt new payload
            $data['viewed'] = true;
            $newPayload = base64_encode(Crypt::encryptString(json_encode($data)));
            $newHash = hash_hmac('sha256', $newPayload, config('app.key'));
            
            return view('messages.show', [
                'message' => $data['message'],
                'newUrl' => route('messages.show', ['payload' => $newPayload, 'hash' => $newHash])
            ]);
            
        } catch (\Exception $e) {
            return view('messages.expired');
        }
    }
}