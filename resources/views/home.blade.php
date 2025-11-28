<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Acadlist</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white">
    <div class="w-full transition-opacity opacity-100 duration-750 border-b shadow-sm bg-white">
        <header class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div class="w-32 h-auto">
                    <img src="{{ asset('assets/img/Sem_título-removebg-preview 2.svg') }}" alt="Logo">
                </div>

                @if (Route::has('login'))
                    <nav class="flex items-center gap-4">
                        @auth
                            <a href="{{ url('/dashboard') }}"
                                class="inline-block px-5 py-2 text-gray-900 border border-gray-300 hover:border-gray-400 rounded-lg text-sm font-medium transition-all">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                                class="inline-block px-6 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-800 hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300">
                                Entrar
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="inline-block px-6 py-2 bg-white text-gray-800 rounded-lg text-sm font-medium hover:bg-gray-300 hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300">
                                    Criar conta
                                </a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </div>
        </header>
    </div>
    <section class="relative w-full overflow-hidden bg-white">
        <div class="absolute right-0 top-0 bottom-0 w-1/2 z-0">
            <img src="{{ asset('assets/img/22881108_6693896 1.svg') }}" alt="Background"
                class="h-full w-full object-contain opacity-100">
        </div>

        <div class="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-32">
            <div class="text-center lg:text-left lg:w-1/2">
                <h1 class="text-5xl lg:text-7xl font-bold text-gray-800 mb-6 leading-tight">
                    Bem-vindo a <br>
                    <span class="bg-gradient-to-r from-blue-600 to-blue-400 bg-clip-text text-transparent">
                        Acadlist
                    </span>
                </h1>
                <p class="text-xl text-gray-700 mb-10">
                    Uma solução completa e moderna para organizar sua escola. <br>
                    Comece sua jornada hoje mesmo.
                </p>
                <div
                    class="flex flex-col sm:flex-row items-center lg:items-start justify-center lg:justify-start gap-4">
                    <a href="{{ route('register') }}"
                        class="inline-block px-8 py-4 bg-blue-600 text-white hover:bg-blue-800 rounded-lg text-base font-semibold transition-all shadow-lg hover:shadow-xl">
                        Começar Agora
                    </a>
                </div>
            </div>
        </div>
    </section>


</body>

</html>
