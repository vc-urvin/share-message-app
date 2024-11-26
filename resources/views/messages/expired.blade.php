<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message Expired</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-xl shadow-lg p-6 space-y-6">
            <div class="text-center">
                <h1 class="text-2xl font-bold text-gray-800">Message Expired</h1>
                <p class="text-sm text-gray-500 mt-1">This message is no longer available</p>
            </div>
            
            <div class="text-center space-y-4">
                <div class="py-4">
                    <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>

                <p class="text-gray-600">
                    This secure message has either been viewed or is invalid.
                </p>
                
                <div class="pt-2">
                    <a href="{{ route('messages.create') }}" 
                       class="inline-block text-blue-600 hover:text-blue-700">
                        Create a new secure message
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>