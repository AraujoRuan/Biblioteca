<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Livro - BookMaster</title>
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
                    <a href="{{ route('catalog') }}" class="text-gray-700 hover:text-blue-600 font-medium">Catálogo</a>
                    <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-blue-600 font-medium">Dashboard</a>
                    <a href="{{ route('books.create') }}" class="text-gray-700 hover:text-blue-600 font-medium">Adicionar Livro</a>
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
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-gray-900">
                        <i class="fas fa-edit mr-2 text-blue-600"></i>
                        Editar Livro: {{ $book->title }}
                    </h2>
                    <a href="{{ route('catalog') }}" class="text-gray-600 hover:text-gray-900">
                        <i class="fas fa-arrow-left mr-1"></i> Voltar ao Catálogo
                    </a>
                </div>
            </div>

            <form method="POST" action="{{ route('books.update', $book->id) }}" class="p-6" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                        <strong class="font-bold">Erro!</strong>
                        <ul class="list-disc list-inside mt-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Preview da imagem atual -->
                @if($book->cover_image)
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Imagem Atual</label>
                    <div class="flex items-center space-x-4">
                        <img src="{{ asset('storage/' . $book->cover_image) }}" 
                             alt="{{ $book->title }}" 
                             class="h-32 w-24 object-cover rounded border">
                        <div class="text-sm text-gray-600">
                            <p>Imagem atual do livro</p>
                            <p class="text-xs">Para alterar, selecione uma nova imagem abaixo</p>
                        </div>
                    </div>
                </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Título -->
                    <div class="md:col-span-2">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Título do Livro *
                        </label>
                        <input type="text" id="title" name="title" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                               placeholder="Digite o título do livro"
                               value="{{ old('title', $book->title) }}">
                    </div>

                    <!-- Autor -->
                    <div>
                        <label for="author" class="block text-sm font-medium text-gray-700 mb-2">
                            Autor *
                        </label>
                        <input type="text" id="author" name="author" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                               placeholder="Nome do autor"
                               value="{{ old('author', $book->author) }}">
                    </div>

                    <!-- Editora -->
                    <div>
                        <label for="publisher" class="block text-sm font-medium text-gray-700 mb-2">
                            Editora *
                        </label>
                        <input type="text" id="publisher" name="publisher" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                               placeholder="Nome da editora"
                               value="{{ old('publisher', $book->publisher) }}">
                    </div>

                    <!-- ISBN -->
                    <div>
                        <label for="isbn" class="block text-sm font-medium text-gray-700 mb-2">
                            ISBN *
                        </label>
                        <input type="text" id="isbn" name="isbn" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                               placeholder="Ex: 978-85-123-4567-8"
                               value="{{ old('isbn', $book->isbn) }}">
                    </div>

                    <!-- Ano de Publicação -->
                    <div>
                        <label for="publication_year" class="block text-sm font-medium text-gray-700 mb-2">
                            Ano de Publicação *
                        </label>
                        <input type="number" id="publication_year" name="publication_year" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                               placeholder="2023"
                               min="1900"
                               max="{{ date('Y') }}"
                               value="{{ old('publication_year', $book->publication_year) }}">
                    </div>

                    <!-- Categoria -->
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                            Categoria *
                        </label>
                        <select id="category" name="category" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                            <option value="">Selecione uma categoria</option>
                            <option value="Ficção" {{ old('category', $book->category) == 'Ficção' ? 'selected' : '' }}>Ficção</option>
                            <option value="Romance" {{ old('category', $book->category) == 'Romance' ? 'selected' : '' }}>Romance</option>
                            <option value="Aventura" {{ old('category', $book->category) == 'Aventura' ? 'selected' : '' }}>Aventura</option>
                            <option value="Tecnologia" {{ old('category', $book->category) == 'Tecnologia' ? 'selected' : '' }}>Tecnologia</option>
                            <option value="Biografia" {{ old('category', $book->category) == 'Biografia' ? 'selected' : '' }}>Biografia</option>
                            <option value="História" {{ old('category', $book->category) == 'História' ? 'selected' : '' }}>História</option>
                            <option value="Ciência" {{ old('category', $book->category) == 'Ciência' ? 'selected' : '' }}>Ciência</option>
                            <option value="Fantasia" {{ old('category', $book->category) == 'Fantasia' ? 'selected' : '' }}>Fantasia</option>
                            <option value="Infantil" {{ old('category', $book->category) == 'Infantil' ? 'selected' : '' }}>Infantil</option>
                            <option value="Autoajuda" {{ old('category', $book->category) == 'Autoajuda' ? 'selected' : '' }}>Autoajuda</option>
                        </select>
                    </div>

                    <!-- Total de Cópias -->
                    <div>
                        <label for="total_copies" class="block text-sm font-medium text-gray-700 mb-2">
                            Total de Cópias *
                        </label>
                        <input type="number" id="total_copies" name="total_copies" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                               placeholder="Quantidade total"
                               min="1"
                               value="{{ old('total_copies', $book->total_copies) }}">
                        <p class="mt-1 text-sm text-gray-500">
                            Cópias disponíveis: <strong>{{ $book->available_copies }}</strong>
                        </p>
                    </div>

                    <!-- Localização -->
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                            Localização
                        </label>
                        <input type="text" id="location" name="location"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                               placeholder="Ex: Estante A, Prateleira 3"
                               value="{{ old('location', $book->location) }}">
                    </div>

                    <!-- Nova Imagem da Capa -->
                    <div class="md:col-span-2">
                        <label for="cover_image" class="block text-sm font-medium text-gray-700 mb-2">
                            Nova Imagem da Capa
                        </label>
                        <input type="file" id="cover_image" name="cover_image"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                               accept="image/*">
                        <p class="mt-1 text-sm text-gray-500">Deixe em branco para manter a imagem atual. Formatos: JPG, PNG, GIF. Tamanho máximo: 2MB</p>
                    </div>

                    <!-- Descrição -->
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Descrição
                        </label>
                        <textarea id="description" name="description" rows="4"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                  placeholder="Descrição breve do livro...">{{ old('description', $book->description) }}</textarea>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('catalog') }}" 
                       class="px-6 py-3 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition duration-200 flex items-center">
                        <i class="fas fa-times mr-2"></i> Cancelar
                    </a>
                    <button type="submit"
                            class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200 flex items-center">
                        <i class="fas fa-save mr-2"></i> Atualizar Livro
                    </button>
                </div>
            </form>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p>&copy; 2023 BookMaster - Sistema de Gestão de Bibliotecas. Todos os direitos reservados.</p>
        </div>
    </footer>

    <script>
        // Validação do ano de publicação
        document.getElementById('publication_year').addEventListener('input', function(e) {
            const year = parseInt(e.target.value);
            const currentYear = new Date().getFullYear();
            
            if (year < 1900) {
                e.target.setCustomValidity('O ano deve ser maior ou igual a 1900');
            } else if (year > currentYear) {
                e.target.setCustomValidity('O ano não pode ser maior que o ano atual');
            } else {
                e.target.setCustomValidity('');
            }
        });

        // Preview da nova imagem
        document.getElementById('cover_image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Aqui você pode adicionar um preview da nova imagem
                    console.log('Nova imagem selecionada:', file.name);
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>