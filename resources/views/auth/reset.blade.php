<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | {{ config('app.name') }}</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="{{ asset('Image/Logo New.png') }}" type="image/png">
    <style>
        .password-card {
            transition: all 0.3s ease;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .input-group:focus-within {
            transform: translateY(-1px);
        }

        .btn-reset:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body class="bg-gradient-to-br from-blue-50 to-gray-100 min-h-screen flex items-center p-4">
    <div class="w-full max-w-md mx-auto">
        <div class="password-card bg-white p-8 rounded-xl shadow-sm border border-gray-100">
            <!-- Header Section -->
            <div class="text-center mb-8">
                <div class="mx-auto w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-key text-blue-600 text-2xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-800">Reset Your Password</h2>
                <p class="text-gray-500 mt-2">Create a new secure password</p>
            </div>

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg flex items-start">
                    <i class="fas fa-exclamation-circle mt-1 mr-3 flex-shrink-0"></i>
                    <div>
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Reset Form -->
            <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <!-- Email Field -->
                <div class="input-group transition-all duration-200">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input type="email" id="email" name="email"
                            class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-300 transition-all duration-200"
                            value="{{ old('email') }}" required placeholder="Email">
                    </div>
                </div>

                <!-- New Password Field -->
                <div class="input-group transition-all duration-200">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input type="password" id="password" name="password"
                            class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-300 transition-all duration-200"
                            placeholder="Minimum 8 characters" required autocomplete="new-password">
                    </div>
                </div>

                <!-- Confirm Password Field -->
                <div class="input-group transition-all duration-200">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm
                        Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-300 transition-all duration-200"
                            placeholder="Re-type your password" required autocomplete="new-password">
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="btn-reset w-full py-3 px-4 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-all duration-200 flex items-center justify-center">
                    <i class="fas fa-sync-alt mr-2"></i>
                    Reset Password
                </button>
            </form>

            <!-- Back to Login Link -->
            <div class="mt-6 text-center">
                <a href="{{ route('login') }}"
                    class="text-sm text-blue-600 hover:text-blue-800 flex items-center justify-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to login
                </a>
            </div>
        </div>
    </div>
</body>

</html>
