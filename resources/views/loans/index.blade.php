<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Empréstimos - BookMaster</title>
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
                    <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-blue-600 font-medium">Dashboard</a>
                    <a href="{{ route('catalog') }}" class="text-gray-700 hover:text-blue-600 font-medium">Catálogo</a>
                    <a href="{{ route('loans.index') }}" class="text-blue-600 font-medium border-b-2 border-blue-600">Meus Empréstimos</a>
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
            <h2 class="text-3xl font-bold text-gray-900">Meus Empréstimos</h2>
            <p class="text-gray-600 mt-2">Acompanhe seus livros emprestados</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                        <i class="fas fa-exchange-alt text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Empréstimos Ativos</p>
                        <p class="text-2xl font-bold text-gray-900">
                            {{ $loans->where('status', 'active')->count() }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                        <i class="fas fa-check-circle text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Devolvidos</p>
                        <p class="text-2xl font-bold text-gray-900">
                            {{ $loans->where('status', 'returned')->count() }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-red-100 text-red-600 mr-4">
                        <i class="fas fa-exclamation-triangle text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Atrasados</p>
                        <p class="text-2xl font-bold text-gray-900">
                            {{ $loans->where('status', 'overdue')->count() }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Loans Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Histórico de Empréstimos</h3>
            </div>
            
            @if($loans->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Livro</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data do Empréstimo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data de Devolução</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($loans as $loan)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-gray-200 rounded flex items-center justify-center">
                                        @if($loan->book->cover_image)
                                            <img class="h-10 w-10 rounded object-cover" src="{{ asset('storage/' . $loan->book->cover_image) }}" alt="{{ $loan->book->title }}">
                                        @else
                                            <i class="fas fa-book text-gray-400"></i>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $loan->book->title }}</div>
                                        <div class="text-sm text-gray-500">{{ $loan->book->author }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $loan->loan_date->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $loan->due_date->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($loan->status === 'active')
                                    @if($loan->due_date->isPast())
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Atrasado
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Ativo
                                        </span>
                                    @endif
                                @elseif($loan->status === 'returned')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        Devolvido
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        {{ ucfirst($loan->status) }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                @if($loan->status === 'active')
                                    <form action="{{ route('loans.return', $loan) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm"
                                                onclick="return confirm('Tem certeza que deseja marcar este livro como devolvido?')">
                                            <i class="fas fa-check mr-1"></i>Devolver
                                        </button>
                                    </form>
                                @endif
                                
                                <a href="{{ route('catalog') }}" class="ml-2 bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm inline-block">
                                    <i class="fas fa-book mr-1"></i>Ver Livro
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($loans->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $loans->links() }}
            </div>
            @endif
            
            @else
            <div class="px-6 py-12 text-center">
                <i class="fas fa-book-open text-4xl text-gray-400 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Nenhum empréstimo encontrado</h3>
                <p class="text-gray-500 mb-4">Você ainda não fez nenhum empréstimo.</p>
                <a href="{{ route('catalog') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg inline-flex items-center">
                    <i class="fas fa-search mr-2"></i> Explorar Catálogo
                </a>
            </div>
            @endif
        </div>

        <!-- Quick Actions -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Informações Importantes</h3>
                <div class="space-y-3 text-sm text-gray-600">
                    <div class="flex items-start">
                        <i class="fas fa-info-circle text-blue-500 mt-1 mr-2"></i>
                        <span>O prazo de empréstimo é de {{ $library->loan_period ?? 14 }} dias</span>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-triangle text-yellow-500 mt-1 mr-2"></i>
                        <span>Multa por atraso: R$ {{ number_format($library->fine_amount_per_day ?? 2.00, 2, ',', '.') }} por dia</span>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-book text-green-500 mt-1 mr-2"></i>
                        <span>Limite de {{ $library->max_books_per_user ?? 5 }} livros por usuário</span>
                    </div>
                </div>
            </div>

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
                    
                    <a href="{{ route('dashboard') }}" class="w-full flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition duration-150">
                        <div class="flex items-center">
                            <i class="fas fa-tachometer-alt text-purple-600 mr-3"></i>
                            <span>Voltar ao Dashboard</span>
                        </div>
                        <i class="fas fa-chevron-right text-gray-400"></i>
                    </a>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p>&copy; 2023 {{ $library->name ?? 'BookMaster' }} - Sistema de Gestão de Bibliotecas. Todos os direitos reservados.</p>
        </div>
    </footer>

    <script>
        // Auto-submit para devolução com confirmação
        document.addEventListener('DOMContentLoaded', function() {
            const returnForms = document.querySelectorAll('form[action*="return"]');
            
            returnForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    if (!confirm('Tem certeza que deseja marcar este livro como devolvido?')) {
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
</body>
</html>