<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', $library->name ?? 'BookMaster')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: {{ $library->primary_color ?? '#2c3e50' }};
            --secondary-color: {{ $library->secondary_color ?? '#3498db' }};
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <i class="fas fa-book-open text-2xl mr-3" style="color: var(--primary-color);"></i>
                    <h1 class="text-2xl font-bold" style="color: var(--primary-color);">
                        {{ $library->name ?? 'BookMaster' }}
                    </h1>
                </div>
                
                <nav class="hidden md:flex space-x-8">
                    <a href="{{ route('catalog') }}" class="text-gray-700 hover:text-blue-600 font-medium">Catálogo</a>
                    @auth
                        <a href="{{ route('loans.index') }}" class="text-gray-700 hover:text-blue-600 font-medium">Meus Empréstimos</a>
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-blue-600 font-medium">Dashboard</a>
                            <a href="{{ route('books.index') }}" class="text-gray-700 hover:text-blue-600 font-medium">Livros</a>
                        @endif
                    @endauth
                    <a href="#" class="text-gray-700 hover:text-blue-600 font-medium">Sobre</a>
                </nav>

                <div class="flex items-center space-x-4">
                    @auth
                        <div class="flex items-center space-x-4">
                            <span class="text-gray-700 hidden md:block">Olá, {{ auth()->user()->name }}</span>
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('super-admin.settings') }}" class="text-gray-700 hover:text-blue-600">
                                    <i class="fas fa-cog"></i>
                                </a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                                    Sair
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 font-medium">Entrar</a>
                        <a href="{{ route('register') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                            Cadastrar
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center">
                <p>&copy; 2023 {{ $library->name ?? 'BookMaster' }} - Sistema de Gestão de Bibliotecas. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>