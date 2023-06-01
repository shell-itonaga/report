<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <div class="w-20 h-20 fill-current text-gray-500">
                    <img class="mb-4" src="{{ asset('img/logo_mark.png') }}" alt="" width="72" height="57">
                </div>
            </a>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <!-- ログインID -->
            <div>
                <x-label for="id" :value="__('ログインID')" />
                <x-input id="id" class="block mt-1 w-full" type="text" name="id" :value="old('id')" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>
            <input type="checkbox" id="password-check">
            <label for="password-check" class="col-form-label-sm">パスワード表示</label>
            <script>
                const pwd1 = document.getElementById('password');
                const pwdCheck1 = document.getElementById('password-check');
                pwdCheck1.addEventListener('change', function() {
                    if(pwdCheck1.checked) {
                        pwd1.setAttribute('type', 'text');
                    } else {
                        pwd1.setAttribute('type', 'password');
                    }
                }, false);
            </script>


            <!-- user_status -->
            <input type="hidden" id="user_status" value="1" name="user_status"/>
            <!-- is_delete_flg -->
            <input type="hidden" id="is_delete_flg" value="0" name="is_delete_flg"/>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
                <p class="text-sm text-red-600"><i class="fas fa-exclamation-circle"></i>共用PCの場合はONにしないでください</p>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button class="ml-3">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
