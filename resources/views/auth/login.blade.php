<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4 text-green-400" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-400 mb-1">Email</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-envelope text-gray-500"></i>
                </div>
                <input id="email" class="block w-full pl-10 bg-[#0b0f19] border border-gray-700 rounded-lg text-gray-300 py-2.5 focus:ring-amber-500 focus:border-amber-500 outline-none transition-colors" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="admin@example.com" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex justify-between mb-1">
                <label for="password" class="block text-sm font-medium text-gray-400">Password</label>
                @if (Route::has('password.request'))
                    <a class="text-xs text-amber-500 hover:text-amber-400 transition-colors" href="{{ route('password.request') }}">
                        Lupa password?
                    </a>
                @endif
            </div>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-lock text-gray-500"></i>
                </div>
                <input id="password" class="block w-full pl-10 bg-[#0b0f19] border border-gray-700 rounded-lg text-gray-300 py-2.5 focus:ring-amber-500 focus:border-amber-500 outline-none transition-colors"
                                type="password"
                                name="password"
                                required autocomplete="current-password" placeholder="••••••••" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded bg-[#0b0f19] border-gray-700 text-amber-500 focus:ring-amber-500" name="remember">
                <span class="ms-2 text-sm text-gray-400 select-none">Ingat saya</span>
            </label>
        </div>

        <div class="pt-2">
            <button class="w-full flex justify-center items-center gap-2 bg-amber-500 hover:bg-amber-600 text-black font-bold py-3 px-4 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 focus:ring-offset-[#111827]">
                <i class="fas fa-sign-in-alt"></i>
                Masuk ke Dashboard
            </button>
        </div>
    </form>
</x-guest-layout>
