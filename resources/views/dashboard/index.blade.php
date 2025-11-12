<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - {{ $library->name ?? 'BookMaster' }}</title>
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
                    <a href="{{ route('dashboard') }}" class="text-blue-600 font-medium border-b-2 border-blue-600">Dashboard</a>
                    <a href="{{ route('catalog') }}" class="text-gray-700 hover:text-blue-600 font-medium">Catálogo</a>
                    <a href="{{ route('loans.index') }}" class="text-gray-700 hover:text-blue-600 font-medium">Meus Empréstimos</a>
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('books.index') }}" class="text-gray-700 hover:text-blue-600 font-medium">Administrar</a>
                        @endif
                    @endauth
                </nav>

                <div class="flex items-center space-x-4">
                    <span class="text-gray-700">Olá, {{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm">
                            Sair
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Dashboard</h2>
            <p class="text-gray-600 mt-2">Bem-vindo ao sistema de gestão da biblioteca</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                        <i class="fas fa-book text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Total de Livros</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total_books'] ?? '0' }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                        <i class="fas fa-users text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Usuários Ativos</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total_users'] ?? '0' }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                        <i class="fas fa-exchange-alt text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Empréstimos Ativos</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['active_loans'] ?? '0' }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-red-100 text-red-600 mr-4">
                        <i class="fas fa-exclamation-triangle text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Atrasos</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['overdue_loans'] ?? '0' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Info and Quick Actions -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- User Information -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Suas Informações</h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-600">Nome</p>
                        <p class="font-medium">{{ auth()->user()->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Email</p>
                        <p class="font-medium">{{ auth()->user()->email }}</p>
                    </div>
                    @if(auth()->user()->phone)
                    <div>
                        <p class="text-sm text-gray-600">Telefone</p>
                        <p class="font-medium">{{ auth()->user()->phone }}</p>
                    </div>
                    @endif
                    <div>
                        <p class="text-sm text-gray-600">Tipo de Usuário</p>
                        <p class="font-medium">
                            @if(auth()->user()->isSuperAdmin())
                                <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded text-xs">Super Admin</span>
                            @elseif(auth()->user()->isAdmin())
                                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">Administrador</span>
                            @elseif(auth()->user()->isLibrarian())
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">Bibliotecário</span>
                            @else
                                <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded text-xs">Usuário</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Ações Rápidas</h3>
                <div class="space-y-3">
                    <a href="{{ route('catalog') }}" class="w-full flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition duration-150">
                        <div class="flex items-center">
                            <i class="fas fa-search text-blue-600 mr-3"></i>
                            <span>Buscar Livros</span>
                        </div>
                        <i class="fas fa-chevron-right text-gray-400"></i>
                    </a>
                    
                    <a href="{{ route('loans.index') }}" class="w-full flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition duration-150">
                        <div class="flex items-center">
                            <i class="fas fa-exchange-alt text-green-600 mr-3"></i>
                            <span>Meus Empréstimos</span>
                        </div>
                        <i class="fas fa-chevron-right text-gray-400"></i>
                    </a>

                    @if(auth()->user()->isAdmin())
                    <a href="{{ route('books.index') }}" class="w-full flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition duration-150">
                        <div class="flex items-center">
                            <i class="fas fa-book text-purple-600 mr-3"></i>
                            <span>Gerenciar Livros</span>
                        </div>
                        <i class="fas fa-chevron-right text-gray-400"></i>
                    </a>

                    <a href="{{ route('super-admin.settings') }}" class="w-full flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition duration-150">
                        <div class="flex items-center">
                            <i class="fas fa-cog text-orange-600 mr-3"></i>
                            <span>Configurações</span>
                        </div>
                        <i class="fas fa-chevron-right text-gray-400"></i>
                    </a>
                    @endif
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Atividade Recente</h3>
                <div class="space-y-4">
                    @if(isset($recentLoans) && $recentLoans->count() > 0)
                        @foreach($recentLoans as $loan)
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <i class="fas fa-book text-gray-400 mt-1"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium">{{ $loan->book->title }}</p>
                                <p class="text-xs text-gray-500">Empréstimo em {{ $loan->loan_date->format('d/m/Y') }}</p>
                                <span class="inline-block mt-1 px-2 py-1 text-xs rounded 
                                    {{ $loan->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $loan->status === 'active' ? 'Ativo' : 'Devolvido' }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <p class="text-gray-500 text-sm">Nenhuma atividade recente.</p>
                        <a href="{{ route('catalog') }}" class="inline-block mt-2 text-blue-600 hover:text-blue-500 text-sm">
                            <i class="fas fa-book mr-1"></i> Explorar catálogo
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Admin Section -->
        @if(auth()->user()->isAdmin())
        <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Recent Loans Table -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Empréstimos Recentes</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuário</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Livro</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Devolução</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @if(isset($recentLoans) && $recentLoans->count() > 0)
                                @foreach($recentLoans as $loan)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $loan->user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $loan->book->title }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $loan->due_date->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $loan->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $loan->status === 'active' ? 'Ativo' : 'Atrasado' }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                        Nenhum empréstimo recente.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Popular Books -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Livros Populares</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Livro</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Autor</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Empréstimos</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @if(isset($popularBooks) && $popularBooks->count() > 0)
                                @foreach($popularBooks as $book)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $book->title }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $book->author }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $book->loan_count ?? '0' }}</td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">
                                        Nenhum dado disponível.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p>&copy; 2023 {{ $library->name ?? 'BookMaster' }} - Sistema de Gestão de Bibliotecas. Todos os direitos reservados.</p>
        </div>
    </footer>
</body>
</html>