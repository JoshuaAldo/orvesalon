<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Your App Name</title>
    @vite('resources/css/app.css')
    <!-- Include Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="{{ asset('Image/Logo New.png') }}" type="image/png">
</head>

<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md border border-gray-100">
            <!-- Logo -->
            <div class="flex justify-center mb-6">
                <div class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center">
                    <i class="fas fa-lock text-blue-600 text-2xl"></i>
                </div>
            </div>

            <h1 class="text-2xl font-bold text-center mb-2 text-gray-800">Admin Portal</h1>
            <p class="text-gray-500 text-center mb-8">Please sign in to continue</p>

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-700">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                </div>
            @endif

            @if (session('status'))
                <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 text-green-700">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        <span>{{ session('status') }}</span>
                    </div>
                </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input type="email" id="email" name="email"
                            class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="your@email.com" value="{{ old('email') }}" required autocomplete="email"
                            autofocus>
                    </div>
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input type="password" id="password" name="password"
                            class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="••••••••" required autocomplete="current-password">
                    </div>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <div>
                        <a href="{{ route('password.request') }}"
                            class="text-sm text-blue-600 hover:text-blue-800">Forgot password?</a>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
                    Sign In
                </button>
            </form>

            <!-- Footer -->
            <div class="mt-6 text-center text-sm text-gray-500">
                <p>© {{ date('Y') }} ORVÉ Salon. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>

</html>
