<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SmartPantry</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        .glass {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
        .input-icon {
            position: relative;
        }
        .input-icon i {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
        }
        .input-icon input {
            padding-right: 40px;
        }
    </style>
</head>
<body class="min-h-screen bg-cover bg-center bg-fixed flex items-center justify-center p-4" style="background-image: url('https://images.unsplash.com/photo-1610832958506-aa56368176cf?w=1920&h=1080&fit=crop&auto=format&auto=webp&q=80');">
    <div class="absolute inset-0 bg-gradient-to-br from-black/50 via-black/40 to-black/60"></div>
    <div class="glass max-w-md w-full rounded-2xl shadow-2xl p-8 transform hover:scale-105 transition-transform duration-300">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4 backdrop-blur-sm">
                <i class="fas fa-utensils text-2xl text-white"></i>
            </div>
            <h1 class="text-3xl font-bold text-white mb-2">SmartPantry</h1>
            <p class="text-white/80 text-sm">Smart Meal Planning</p>
        </div>

        <h2 class="text-2xl font-bold text-white mb-6 text-center">Welcome Back</h2>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-500/20 border border-red-400/50 rounded-lg backdrop-blur-sm">
                @foreach ($errors->all() as $error)
                    <p class="text-sm text-red-100">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf
            <div class="input-icon">
                <label class="block text-sm font-semibold text-white mb-2">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="w-full rounded-xl border-0 bg-white/10 text-white placeholder-white/60 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-white/50 backdrop-blur-sm" />
                <i class="fas fa-envelope"></i>
            </div>
            <div class="input-icon">
                <label class="block text-sm font-semibold text-white mb-2">Password</label>
                <input type="password" name="password" required
                       class="w-full rounded-xl border-0 bg-white/10 text-white placeholder-white/60 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-white/50 backdrop-blur-sm" />
                <i class="fas fa-lock"></i>
            </div>
            <button type="submit" class="w-full py-3 bg-white text-[#2E7D32] font-bold rounded-xl hover:bg-white/90 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="fas fa-sign-in-alt mr-2"></i>Sign In
            </button>
        </form>

        <div class="mt-8 text-center">
            <p class="text-white/80 text-sm">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-white font-bold hover:underline transition-all duration-300">Create one here</a>
            </p>
        </div>
    </div>
</body>
</html>
