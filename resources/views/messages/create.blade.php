<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure One-Time Message</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">
    <div id="app" class="w-full max-w-md">
        <div class="bg-white rounded-xl shadow-lg p-6 space-y-6">
            <div class="text-center">
                <h1 class="text-2xl font-bold text-gray-800">Secure Message</h1>
                <p class="text-sm text-gray-500 mt-1">Create a self-destructing message</p>
            </div>
            
            <!-- Message Form -->
            <div v-if="!generatedUrl" class="space-y-4">
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Your Secret Message</label>
                    <textarea 
                        v-model="message" 
                        class="w-full p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                        placeholder="Type your message here..."
                        rows="4"
                    ></textarea>
                    <p class="text-xs text-gray-500">
                        ⚠️ Message will self-destruct after first view
                    </p>
                </div>

                <button 
                    @click="generateLink" 
                    class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition duration-200 flex items-center justify-center space-x-2 disabled:opacity-50"
                    :disabled="!message || loading"
                >
                    <svg v-if="loading" class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span v-if="!loading">Generate Secure Link</span>
                    <span v-else>Generating...</span>
                </button>
            </div>

            <!-- Generated URL -->
            <div v-if="generatedUrl" class="space-y-4">
                <div class="rounded-lg border border-gray-200">
                    <div class="p-3 bg-gray-50 border-b border-gray-200">
                        <h3 class="text-sm font-medium text-gray-700">Your secure link is ready</h3>
                    </div>
                    <div class="p-3">
                        <p class="text-sm text-gray-600 break-all font-mono">@{{ generatedUrl }}</p>
                    </div>
                </div>

                <div class="space-y-3">
                    <button 
                        @click="copyToClipboard" 
                        :class="[
                            'w-full text-white py-3 px-4 rounded-lg transition duration-200',
                            copied ? 'bg-gray-600 hover:bg-gray-700' : 'bg-green-600 hover:bg-green-700'
                        ]"
                    >
                        @{{ copied ? 'Copied!' : 'Copy to Clipboard' }}
                    </button>
                    
                    <button 
                        @click="reset" 
                        class="w-full bg-gray-100 text-gray-700 py-3 px-4 rounded-lg hover:bg-gray-200 transition duration-200"
                    >
                        Create New Message
                    </button>
                </div>

                <div class="text-xs text-gray-500 text-center space-y-1">
                    <p>⚠️ This link will only work once</p>
                    <p>After viewing, the message will be destroyed forever</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        const { createApp } = Vue
        
        createApp({
            data() {
                return {
                    message: '',
                    generatedUrl: null,
                    loading: false,
                    copied: false
                }
            },
            methods: {
                async generateLink() {
                    if (!this.message) return;
                    
                    this.loading = true;
                    try {
                        const response = await axios.post('/messages', {
                            message: this.message
                        });
                        this.generatedUrl = response.data.url;
                    } catch (error) {
                        alert('Error generating link. Please try again.');
                    } finally {
                        this.loading = false;
                    }
                },
                async copyToClipboard() {
                    try {
                        await navigator.clipboard.writeText(this.generatedUrl);
                        this.copied = true;
                        setTimeout(() => {
                            this.copied = false;
                        }, 2000); // Reset after 2 seconds
                    } catch (err) {
                        alert('Failed to copy link. Please copy it manually.');
                    }
                },
                reset() {
                    this.message = '';
                    this.generatedUrl = null;
                    this.copied = false;
                }
            }
        }).mount('#app')
    </script>
</body>
</html>