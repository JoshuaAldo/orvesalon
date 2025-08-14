<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | {{ config('app.name') }}</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .password-card {
            transition: all 0.3s ease;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .password-card:hover {
            box-shadow: 0 15px 30px -5px rgba(0, 0, 0, 0.15);
        }

        .btn-reset:hover {
            transform: translateY(-2px);
        }
    </style>
    <link rel="icon" href="{{ asset('Image/Logo New.png') }}" type="image/png">
</head>

<body class="bg-gradient-to-br from-blue-50 to-gray-100 min-h-screen flex items-center">
    <div class="max-w-md w-full mx-auto p-4">
        <div class="password-card bg-white p-8 rounded-xl shadow-sm border border-gray-100">
            <!-- Header Section -->
            <div class="text-center mb-8">
                <div class="mx-auto w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-key text-blue-600 text-2xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-800">Reset Password</h2>
                <p class="text-gray-500 mt-2">Masukkan email untuk menerima link reset password</p>
            </div>

            <!-- Status Messages -->
            @if (session('status'))
                <div
                    class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-lg flex items-start">
                    <i class="fas fa-check-circle mt-1 mr-3 flex-shrink-0"></i>
                    <div>{{ session('status') }}</div>
                </div>
            @endif

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
            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                @csrf

                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Alamat Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input type="email" id="email" name="email"
                            class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-300 transition-all duration-200"
                            placeholder="email@example.com" value="{{ old('email') }}" required autofocus>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="btn-reset w-full py-3 px-4 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-all duration-200 flex items-center justify-center">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Kirim Link Reset Password
                </button>
            </form>

            <!-- Back to Login -->
            <div class="mt-6 text-center">
                <a href="{{ route('login') }}"
                    class="text-sm text-blue-600 hover:text-blue-800 flex items-center justify-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke halaman login
                </a>
            </div>
        </div>
    </div>
</body>

</html>
