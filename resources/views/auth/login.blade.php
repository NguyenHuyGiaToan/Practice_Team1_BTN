<x-guest-layout>

    <!-- LOGO -->
    <div class="text-center mb-4">
        <img src="{{ asset('images/logo.png') }}" width="100" class="mx-auto">
        <h3 class="mt-2">ĐĂNG NHẬP</h3>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- EMAIL -->
        <div>
            <x-input-label for="email" :value="'Email'" />
            <x-text-input id="email" class="block mt-1 w-full"
                type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- PASSWORD -->
        <div class="mt-4">
            <x-input-label for="password" :value="'Mật khẩu'" />
            <x-text-input id="password" class="block mt-1 w-full"
                type="password" name="password" required />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- REMEMBER -->
        <div class="block mt-4">
            <label class="inline-flex items-center">
                <input type="checkbox" name="remember">
                <span class="ms-2 text-sm">Ghi nhớ đăng nhập</span>
            </label>
        </div>

        <!-- BUTTON -->
        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-3">
                Đăng nhập
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>