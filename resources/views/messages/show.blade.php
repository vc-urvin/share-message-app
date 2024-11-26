<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Message</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-xl shadow-lg p-6 space-y-6">
            <div class="text-center">
                <h1 class="text-2xl font-bold text-gray-800">Secure Message</h1>
                <p class="text-sm text-gray-500 mt-1">This message will self-destruct</p>
            </div>
            
            <div class="space-y-4">
                <div class="rounded-lg border border-gray-200">
                    <div class="p-3 bg-gray-50 border-b border-gray-200">
                        <h3 class="text-sm font-medium text-gray-700">Message Contents:</h3>
                    </div>
                    <div class="p-4">
                        <p class="text-gray-700 whitespace-pre-wrap">{{ $message }}</p>
                    </div>
                </div>
                
                <div class="text-center space-y-3">
                    <p class="text-sm text-red-500">
                        ⚠️ This message has been destroyed and cannot be accessed again
                    </p>
                    
                    <a href="{{ route('messages.create') }}" 
                       class="inline-block text-blue-600 hover:text-blue-700 text-sm">
                        Create your own secure message
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>