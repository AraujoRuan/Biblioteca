<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookMaster - Sistema de Gestão de Bibliotecas</title>
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
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 font-medium">Entrar</a>
                    <a href="{{ route('register') }}" class="text-gray-700 hover:text-blue-600 font-medium">Cadastrar</a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-600 to-purple-700 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl md:text-6xl font-bold mb-6">Sistema de Gestão de Bibliotecas</h2>
            <p class="text-xl mb-8 max-w-3xl mx-auto">
                Gerencie seu acervo, empréstimos e usuários de forma eficiente com nossa plataforma completa.
            </p>
            <div class="space-x-4">
                <a href="{{ route('register') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300">
                    Começar Agora
                </a>
                <a href="{{ route('catalog') }}" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition duration-300">
                    Ver Catálogo
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h3 class="text-3xl font-bold text-gray-900 mb-4">Funcionalidades Principais</h3>
                <p class="text-lg text-gray-600">Tudo que você precisa para gerenciar sua biblioteca</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-book text-2xl text-blue-600"></i>
                    </div>
                    <h4 class="text-xl font-semibold mb-2">Gestão de Acervo</h4>
                    <p class="text-gray-600">Cadastre e organize todos os livros do seu acervo de forma simples.</p>
                </div>
                
                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-exchange-alt text-2xl text-green-600"></i>
                    </div>
                    <h4 class="text-xl font-semibold mb-2">Controle de Empréstimos</h4>
                    <p class="text-gray-600">Gerencie empréstimos, devoluções e acompanhe prazos automaticamente.</p>
                </div>
                
                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-users text-2xl text-purple-600"></i>
                    </div>
                    <h4 class="text-xl font-semibold mb-2">Área do Usuário</h4>
                    <p class="text-gray-600">Permita que usuários reservem livros e acompanhem seus empréstimos.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p>&copy; 2023 BookMaster - Sistema de Gestão de Bibliotecas. Todos os direitos reservados.</p>
        </div>
    </footer>
</body>
</html>