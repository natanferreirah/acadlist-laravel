<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Grid Container -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">

            <!-- UserName -->
            <div>
                <x-input-label for="username" :value="__('component.username')" />
                <x-text-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')"
                    autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('username')" class="mt-2" />
            </div>

            <!-- Name School -->
            <div>
                <x-input-label for="name" :value="__('component.name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                    autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address - Ocupa 2 colunas -->
            <div class="md:col-span-2">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password"
                    autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div>
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                    name="password_confirmation" autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

        </div>

        <!-- Footer fora do grid -->


        <a class="underline text-sm text-gray-600 hover:text-blue-600 focus:outline-none focus:ring-blue-600"
            href="{{ route('login') }}">
            {{ __('Already registered?') }}
        </a>

        <div class="flex items-center justify-end mt-6">
            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
