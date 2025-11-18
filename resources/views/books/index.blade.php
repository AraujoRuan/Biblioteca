<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo - BookMaster</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <i class="fas fa-book-open text-2xl mr-3 text-blue-600"></i>
                    <h1 class="text-2xl font-bold text-gray-900">BookMaster</h1>
                </div>
                
                <nav class="hidden md:flex space-x-8">
                    <a href="{{ route('catalog') }}" class="text-blue-600 font-medium border-b-2 border-blue-600">Catálogo</a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-blue-600 font-medium">Dashboard</a>
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('books.create') }}" class="text-gray-700 hover:text-blue-600 font-medium">Adicionar Livro</a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 font-medium">Entrar</a>
                        <a href="{{ route('register') }}" class="text-gray-700 hover:text-blue-600 font-medium">Cadastrar</a>
                    @endauth
                </nav>

                @auth
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700">Olá, {{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm">
                            Sair
                        </button>
                    </form>
                </div>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Catálogo de Livros</h2>
                <p class="text-gray-600">Explore nossa coleção de livros</p>
            </div>
            
            @auth
                @if(auth()->user()->isAdmin())
                <a href="{{ route('books.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg flex items-center transition duration-200">
                    <i class="fas fa-plus mr-2"></i> Adicionar Livro
                </a>
                @endif
            @endauth
        </div>

        <!-- Search and Filters -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="md:col-span-2">
                    <input type="text" 
                           placeholder="Buscar por título, autor, ISBN..." 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Todos os status</option>
                        <option value="available">Disponível</option>
                        <option value="unavailable">Indisponível</option>
                    </select>
                </div>
                <div>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Todas as categorias</option>
                        <option value="ficcao">Ficção</option>
                        <option value="romance">Romance</option>
                        <option value="tecnologia">Tecnologia</option>
                        <option value="biografia">Biografia</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Books Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($books as $book)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300">
                <div class="h-48 bg-gray-200 flex items-center justify-center relative">
                    @if($book->cover_image)
                        <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="h-full w-full object-cover">
                    @else
                        <i class="fas fa-book text-6xl text-gray-400"></i>
                    @endif
                    
                    <!-- Admin Actions Overlay -->
                    @auth
                        @if(auth()->user()->isAdmin())
                        <div class="absolute top-2 right-2 flex space-x-1">
                            <!-- Edit Button -->
                            <a href="{{ route('books.edit', $book->id) }}" 
                               class="bg-blue-600 text-white p-2 rounded-full hover:bg-blue-700 transition duration-200"
                               title="Editar livro">
                                <i class="fas fa-edit text-xs"></i>
                            </a>
                            
                            <!-- Delete Button -->
                            <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="bg-red-600 text-white p-2 rounded-full hover:bg-red-700 transition duration-200"
                                        onclick="return confirm('Tem certeza que deseja excluir este livro?')"
                                        title="Excluir livro">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </form>
                        </div>
                        @endif
                    @endauth
                </div>
                
                <div class="p-4">
                    <h3 class="font-semibold text-lg mb-2 line-clamp-2">{{ $book->title }}</h3>
                    <p class="text-gray-600 text-sm mb-2">{{ $book->author }}</p>
                    <p class="text-gray-500 text-xs mb-2">Editora: {{ $book->publisher }}</p>
                    <p class="text-gray-500 text-xs mb-2">Ano: {{ $book->publication_year }}</p>
                    <p class="text-gray-500 text-xs mb-3">ISBN: {{ $book->isbn }}</p>
                    
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-sm text-gray-600">
                            Cópias: <span class="font-semibold">{{ $book->available_copies }}/{{ $book->total_copies }}</span>
                        </span>
                        <span class="{{ $book->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} text-xs px-2 py-1 rounded">
                            {{ $book->is_available ? 'Disponível' : 'Indisponível' }}
                        </span>
                    </div>

                    <div class="flex space-x-2">
                        @auth
                            @if(auth()->user()->isAdmin())
                                <!-- Admin Actions -->
                                <a href="{{ route('books.edit', $book->id) }}" 
                                   class="flex-1 bg-blue-600 text-white text-center py-2 rounded text-sm hover:bg-blue-700 transition duration-200">
                                    <i class="fas fa-edit mr-1"></i> Editar
                                </a>
                                
                                <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="w-full bg-red-600 text-white py-2 rounded text-sm hover:bg-red-700 transition duration-200"
                                            onclick="return confirm('Tem certeza que deseja excluir este livro?')">
                                        <i class="fas fa-trash mr-1"></i> Excluir
                                    </button>
                                </form>
                            @else
                                <!-- User Actions -->
                                <button class="flex-1 bg-blue-600 text-white py-2 rounded text-sm hover:bg-blue-700 transition duration-200 {{ !$book->is_available ? 'opacity-50 cursor-not-allowed' : '' }}"
                                        {{ !$book->is_available ? 'disabled' : '' }}>
                                    <i class="fas fa-bookmark mr-1"></i> Reservar
                                </button>
                                
                                <a href="#" class="flex-1 bg-gray-600 text-white text-center py-2 rounded text-sm hover:bg-gray-700 transition duration-200">
                                    <i class="fas fa-eye mr-1"></i> Detalhes
                                </a>
                            @endif
                        @else
                            <!-- Public Actions -->
                            <a href="{{ route('login') }}" class="flex-1 bg-blue-600 text-white text-center py-2 rounded text-sm hover:bg-blue-700 transition duration-200">
                                <i class="fas fa-bookmark mr-1"></i> Reservar
                            </a>
                            
                            <a href="{{ route('login') }}" class="flex-1 bg-gray-600 text-white text-center py-2 rounded text-sm hover:bg-gray-700 transition duration-200">
                                <i class="fas fa-eye mr-1"></i> Detalhes
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($books->hasPages())
        <div class="mt-8">
            {{ $books->links() }}
        </div>
        @endif

        <!-- Empty State -->
        @if($books->count() == 0)
        <div class="text-center py-12">
            <i class="fas fa-book-open text-6xl text-gray-400 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Nenhum livro encontrado</h3>
            <p class="text-gray-600 mb-6">Não há livros cadastrados no catálogo.</p>
            @auth
                @if(auth()->user()->isAdmin())
                <a href="{{ route('books.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg inline-flex items-center">
                    <i class="fas fa-plus mr-2"></i> Adicionar Primeiro Livro
                </a>
                @endif
            @endauth
        </div>
        @endif
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p>&copy; 2023 BookMaster - Sistema de Gestão de Bibliotecas. Todos os direitos reservados.</p>
        </div>
    </footer>

    <script>
        // Confirmação para exclusão
        document.addEventListener('DOMContentLoaded', function() {
            const deleteForms = document.querySelectorAll('form[action*="books"]');
            
            deleteForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    if (!confirm('Tem certeza que deseja excluir este livro?')) {
                        e.preventDefault();
                    }
                });
            });

            // Filtros em tempo real
            const searchInput = document.querySelector('input[type="text"]');
            const statusFilter = document.querySelector('select:nth-of-type(1)');
            const categoryFilter = document.querySelector('select:nth-of-type(2)');
            
            function filterBooks() {
                const searchTerm = searchInput.value.toLowerCase();
                const statusValue = statusFilter.value;
                const categoryValue = categoryFilter.value;
                
                const books = document.querySelectorAll('.grid > div');
                
                books.forEach(book => {
                    const title = book.querySelector('h3').textContent.toLowerCase();
                    const author = book.querySelector('p.text-gray-600').textContent.toLowerCase();
                    const status = book.querySelector('span:last-child').textContent.toLowerCase();
                    
                    const matchesSearch = title.includes(searchTerm) || author.includes(searchTerm);
                    const matchesStatus = !statusValue || (statusValue === 'available' && status.includes('disponível')) || 
                                         (statusValue === 'unavailable' && status.includes('indisponível'));
                    
                    if (matchesSearch && matchesStatus) {
                        book.style.display = 'block';
                    } else {
                        book.style.display = 'none';
                    }
                });
            }
            
            searchInput.addEventListener('input', filterBooks);
            statusFilter.addEventListener('change', filterBooks);
            categoryFilter.addEventListener('change', filterBooks);
        });
    </script>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</body>
</html>