<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg shadow-lg p-8 mb-8 text-white">
                <h3 class="text-2xl font-bold mb-2">Bem-vindo, {{ Auth::user()->name }}! 👋</h3>
                <p class="text-blue-100">Aqui está um resumo da sua escola hoje.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

                <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Total de Alunos</p>
                            <h4 class="text-3xl font-bold text-gray-800 mt-2">{{ $totalStudents ?? 0 }}</h4>
                        </div>
                        <div class="bg-blue-100 p-4 rounded-full">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-green-600 text-sm mt-4 flex items-center">
                        <span class="mr-1">↑</span> Ativos este ano
                    </p>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Total de Professores</p>
                            <h4 class="text-3xl font-bold text-gray-800 mt-2">{{ $totalTeachers ?? 0 }}</h4>
                        </div>
                        <div class="bg-green-100 p-4 rounded-full">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm mt-4">Corpo docente</p>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Total de Turmas</p>
                            <h4 class="text-3xl font-bold text-gray-800 mt-2">{{ $totalClasses ?? 0 }}</h4>
                        </div>
                        <div class="bg-purple-100 p-4 rounded-full">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm mt-4">Turmas ativas</p>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Total de Matérias</p>
                            <h4 class="text-3xl font-bold text-gray-800 mt-2">{{ $totalSubjects ?? 0 }}</h4>
                        </div>
                        <div class="bg-orange-100 p-4 rounded-full">
                            <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm mt-4">Cadastradas</p>
                </div>

            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Ações Rápidas</h3>
                    <div class="space-y-3">
                        <a href="{{ route('students.create') }}"
                            class="flex items-center justify-between p-4 bg-gray-50 hover:bg-gray-100 rounded-lg transition">
                            <div class="flex items-center gap-3">
                                <div class="bg-blue-100 p-2 rounded">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </div>
                                <span class="font-medium text-gray-700">Cadastrar Aluno</span>
                            </div>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </a>

                        <a href="{{ route('teachers.create') }}"
                            class="flex items-center justify-between p-4 bg-gray-50 hover:bg-gray-100 rounded-lg transition">
                            <div class="flex items-center gap-3">
                                <div class="bg-green-100 p-2 rounded">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </div>
                                <span class="font-medium text-gray-700">Cadastrar Professor</span>
                            </div>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>

                        <a href="{{ route('school-classes.create') }}"
                            class="flex items-center justify-between p-4 bg-gray-50 hover:bg-gray-100 rounded-lg transition">
                            <div class="flex items-center gap-3">
                                <div class="bg-purple-100 p-2 rounded">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </div>
                                <span class="font-medium text-gray-700">Criar Turma</span>
                            </div>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>

                        <a href="{{ route('grades.index') }}"
                            class="flex items-center justify-between p-4 bg-gray-50 hover:bg-gray-100 rounded-lg transition">
                            <div class="flex items-center gap-3">
                                <div class="bg-orange-100 p-2 rounded">
                                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                        </path>
                                    </svg>
                                </div>
                                <span class="font-medium text-gray-700">Ver Notas</span>
                            </div>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Informações do Sistema</h3>
                    <div class="space-y-4">
                        <div class="flex items-start gap-3 p-4 bg-blue-50 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600 mt-0.5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <h4 class="font-semibold text-gray-800">Escola: {{ Auth::user()->name }}</h4>
                                <p class="text-sm text-gray-600 mt-1">Sistema de gestão escolar completo</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 p-4 bg-green-50 rounded-lg">
                            <svg class="w-6 h-6 text-green-600 mt-0.5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <h4 class="font-semibold text-gray-800">Sistema Ativo</h4>
                                <p class="text-sm text-gray-600 mt-1">Todos os módulos funcionando normalmente</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 p-4 bg-purple-50 rounded-lg">
                            <svg class="w-6 h-6 text-purple-600 mt-0.5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <h4 class="font-semibold text-gray-800">Último Acesso</h4>
                                <p class="text-sm text-gray-600 mt-1">{{ now()->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
