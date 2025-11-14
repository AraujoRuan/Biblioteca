<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Esqueci minha senha - BookMaster</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>
                <div class="flex justify-center">
                    <i class="fas fa-book-open text-4xl text-blue-600"></i>
                </div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    Redefinir senha
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    Digite seu email para receber o link de redefinição
                </p>
            </div>

            @if (session('status'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('status') }}
                    @if (session('dev_reset_link'))
                        <div class="mt-2">
                            <a href="{{ session('dev_reset_link') }}" class="underline text-blue-600 hover:text-blue-800">
                                Clique aqui para redefinir sua senha
                            </a>
                        </div>
                    @endif
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="mt-8 space-y-6" method="POST" action="{{ route('password.email') }}">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input id="email" name="email" type="email" autocomplete="email" required 
                           class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                           placeholder="seu@email.com" value="{{ old('email') }}">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-500 text-sm">
                        ← Voltar para o login
                    </a>
                </div>

                <div>
                    <button type="submit" 
                            class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <i class="fas fa-paper-plane text-gray-300 group-hover:text-gray-400"></i>
                        </span>
                        Enviar link de redefinição
                    </button>
                </div>

                @env('local')
                <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded text-sm">
                    <strong>Modo Desenvolvimento:</strong> O sistema de email está em modo de desenvolvimento.
                </div>
                @endenv
            </form>
        </div>
    </div>
</body>
</html>