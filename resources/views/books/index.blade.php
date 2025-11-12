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
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 font-medium">Entrar</a>
                    <a href="{{ route('register') }}" class="text-gray-700 hover:text-blue-600 font-medium">Cadastrar</a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Catálogo de Livros</h2>
            
            <!-- Search Bar -->
            <div class="flex gap-4 mb-6">
                <input type="text" placeholder="Buscar por título, autor ou ISBN..." 
                       class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                    <i class="fas fa-search"></i> Buscar
                </button>
            </div>
        </div>

        <!-- Books Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <!-- Sample Book Card -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="h-48 bg-gray-200 flex items-center justify-center">
                    <i class="fas fa-book text-6xl text-gray-400"></i>
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-lg mb-2">Dom Casmurro</h3>
                    <p class="text-gray-600 text-sm mb-2">Machado de Assis</p>
                    <p class="text-gray-500 text-xs">ISBN: 978-85-123-4567-8</p>
                    <div class="mt-3 flex justify-between items-center">
                        <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">Disponível</span>
                        <a href="{{ route('login') }}" class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">
                            Reservar
                        </a>
                    </div>
                </div>
            </div>

            <!-- Add more sample books as needed -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="h-48 bg-gray-200 flex items-center justify-center">
                    <i class="fas fa-book text-6xl text-gray-400"></i>
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-lg mb-2">O Cortiço</h3>
                    <p class="text-gray-600 text-sm mb-2">Aluísio Azevedo</p>
                    <p class="text-gray-500 text-xs">ISBN: 978-85-123-4567-9</p>
                    <div class="mt-3 flex justify-between items-center">
                        <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">Disponível</span>
                        <a href="{{ route('login') }}" class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">
                            Reservar
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="h-48 bg-gray-200 flex items-center justify-center">
                    <i class="fas fa-book text-6xl text-gray-400"></i>
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-lg mb-2">O Pequeno Príncipe</h3>
                    <p class="text-gray-600 text-sm mb-2">Antoine de Saint-Exupéry</p>
                    <p class="text-gray-500 text-xs">ISBN: 978-85-123-4567-0</p>
                    <div class="mt-3 flex justify-between items-center">
                        <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded">Indisponível</span>
                        <button class="bg-gray-400 text-white px-3 py-1 rounded text-sm cursor-not-allowed" disabled>
                            Reservar
                        </button>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="h-48 bg-gray-200 flex items-center justify-center">
                    <i class="fas fa-book text-6xl text-gray-400"></i>
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-lg mb-2">1984</h3>
                    <p class="text-gray-600 text-sm mb-2">George Orwell</p>
                    <p class="text-gray-500 text-xs">ISBN: 978-85-123-4567-1</p>
                    <div class="mt-3 flex justify-between items-center">
                        <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">Disponível</span>
                        <a href="{{ route('login') }}" class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">
                            Reservar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p>&copy; 2023 BookMaster - Sistema de Gestão de Bibliotecas. Todos os direitos reservados.</p>
        </div>
    </footer>
</body>
</html>