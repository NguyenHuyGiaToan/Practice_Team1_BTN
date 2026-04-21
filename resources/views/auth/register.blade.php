<x-guest-layout>

    <!-- LOGO -->
    <div class="text-center mb-4">
        <img src="{{ asset('images/logo.png') }}" width="100" class="mx-auto">
        <h3 class="mt-2">ĐĂNG KÝ</h3>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- NAME -->
        <div>
            <x-input-label for="name" :value="'Họ tên'" />
            <x-text-input id="name" class="block mt-1 w-full"
                type="text" name="name" :value="old('name')" required autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- EMAIL -->
        <div class="mt-4">
            <x-input-label for="email" :value="'Email'" />
            <x-text-input id="email" class="block mt-1 w-full"
                type="email" name="email" :value="old('email')" required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- PASSWORD -->
        <div class="mt-4">
            <x-input-label for="password" :value="'Mật khẩu'" />
            <x-text-input id="password" class="block mt-1 w-full"
                type="password" name="password" required />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- CONFIRM -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="'Nhập lại mật khẩu'" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                type="password" name="password_confirmation" required />
        </div>

        <!-- BUTTON -->
        <div class="flex items-center justify-end mt-4">
            <a class="text-sm underline" href="{{ route('login') }}">
                Đã có tài khoản?
            </a>

            <x-primary-button class="ms-4">
                Đăng ký
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>