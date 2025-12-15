<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vovó Lu Crochê - Arte Feita à Mão</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-800 flex flex-col min-h-screen">

    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                
                <div class="flex-shrink-0 flex items-center gap-2">
                    <svg class="w-8 h-8 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <a href="{{ route('home') }}" class="font-bold text-2xl text-teal-600 tracking-tight">
                        Vovó Lu <span class="text-vovolu-rosa">Crochê</span>
                    </a>
                </div>

                <nav class="hidden md:flex space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-teal-500 px-3 py-2 font-medium transition">A História</a>
                    <a href="{{ route('shop') }}" class="text-gray-600 hover:text-teal-500 px-3 py-2 font-medium transition">Loja</a>
                    <a href="#" class="text-gray-600 hover:text-teal-500 px-3 py-2 font-medium transition">Contato</a>
                </nav>

                <div class="flex items-center space-x-4">
                    <a href="#" class="text-gray-500 hover:text-teal-500 relative">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <span class="absolute -top-1 -right-1 bg-vovolu-rosa text-white text-xs font-bold rounded-full h-4 w-4 flex items-center justify-center">0</span>
                    </a>
                    
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 underline">Painel</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-teal-500">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <main class="flex-grow">
        {{ $slot }}
    </main>

    <footer class="bg-gray-800 text-white py-10 mt-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h3 class="text-lg font-bold text-teal-400 mb-4">Vovó Lu Crochê</h3>
                <p class="text-gray-400 text-sm">Peças artesanais feitas com amor, ponto a ponto. Decorando sua casa e aquecendo corações.</p>
            </div>
            <div>
                <h3 class="text-lg font-bold text-teal-400 mb-4">Links Rápidos</h3>
                <ul class="text-sm text-gray-400 space-y-2">
                    <li><a href="{{ route('home') }}" class="hover:text-white">Início</a></li>
                    <li><a href="{{ route('shop') }}" class="hover:text-white">Loja</a></li>
                    <li><a href="#" class="hover:text-white">Política de Entrega</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-lg font-bold text-teal-400 mb-4">Contato</h3>
                <p class="text-sm text-gray-400">WhatsApp: (86) 99924-0325</p>
                <p class="text-sm text-gray-400">Teresina - PI</p>
            </div>
        </div>
        <div class="text-center text-gray-500 text-xs mt-10 border-t border-gray-700 pt-6">
            &copy; {{ date('Y') }} Vovó Lu Crochê. Todos os direitos reservados.
        </div>
    </footer>

</body>
</html>
