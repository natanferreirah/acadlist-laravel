<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <main>
            {{ $slot }}
        </main>
    </div>

    <!-- IMask -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/imask/7.1.3/imask.min.js"></script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Máscaras -->
    <script>
        document.addEventListener('alpine:init', () => {
            console.log('✅ Alpine inicializado!');
            console.log('✅ IMask carregado:', typeof IMask);

            // CPF - COM LOGS DETALHADOS
            Alpine.directive('mask-cpf', (el, {
                expression
            }, {
                evaluate
            }) => {
                console.log('🎭 Diretiva mask-cpf chamada!');
                console.log('📍 Elemento:', el);
                console.log('📍 Tag:', el.tagName);
                console.log('📍 Tipo:', el.type);

                // Remove atributos que podem causar conflito
                el.removeAttribute('maxlength');

                // Aplica a máscara
                const maskInstance = IMask(el, {
                    mask: '000.000.000-00',
                    lazy: false // Não espera o usuário começar a digitar
                });

                console.log('✅ Máscara CPF aplicada!', maskInstance);
            });

            // Telefone - COM LOGS DETALHADOS
            Alpine.directive('mask-phone', (el) => {
                console.log('🎭 Diretiva mask-phone chamada!');

                const maskInstance = IMask(el, {
                    mask: [{
                            mask: '(00) 0000-0000'
                        },
                        {
                            mask: '(00) 00000-0000'
                        }
                    ],
                    lazy: false
                });

                console.log('✅ Máscara Telefone aplicada!', maskInstance);
            });

            // CEP
            Alpine.directive('mask-cep', (el) => {
                IMask(el, {
                    mask: '00000-000',
                    lazy: false
                });
            });

            // CNPJ
            Alpine.directive('mask-cnpj', (el) => {
                IMask(el, {
                    mask: '00.000.000/0000-00',
                    lazy: false
                });
            });
        });
    </script>
</body>

</html>
