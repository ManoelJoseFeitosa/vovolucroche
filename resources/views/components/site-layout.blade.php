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
            <div class="flex justify-between h-28 items-center">
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('images/logovovolu.jpeg') }}" alt="Vovó Lu Crochê" class="h-24 md:h-28 w-auto object-contain py-2">
                    </a>
                </div>

                <nav class="hidden md:flex space-x-8 items-center">
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-teal-500 px-3 py-2 font-medium text-lg transition">A História</a>
                    <a href="{{ route('shop') }}" class="text-gray-600 hover:text-teal-500 px-3 py-2 font-medium text-lg transition">Loja</a>
                    <a href="{{ route('contact') }}" class="text-gray-600 hover:text-teal-500 px-3 py-2 font-medium text-lg transition">Contato</a>
                </nav>

                <div class="flex items-center space-x-4 md:space-x-6">
                    
                    <a href="https://www.instagram.com/vovolucroche" target="_blank" class="text-gray-400 hover:text-pink-600 transition-colors duration-200 hidden sm:block">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>

                    <a href="{{ route('cart.index') }}" class="text-gray-400 hover:text-teal-500 relative group transition-colors duration-200">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <span class="absolute -top-1 -right-2 bg-teal-500 text-white text-[10px] font-bold rounded-full h-4 w-4 flex items-center justify-center border border-white">
                            {{ count((array) session('cart')) }}
                        </span>
                    </a>
                    
                    @if(Auth::check())
                        <div class="relative ml-2" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center gap-1 text-sm font-bold text-gray-700 hover:text-teal-600 focus:outline-none transition">
                                <span class="hidden sm:inline">Olá, {{ explode(' ', Auth::user()->name)[0] }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>

                            <div x-show="open" @click.away="open = false" style="display: none;"
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-xl py-1 z-50 border border-gray-100">
                                <a href="{{ route('customer.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-teal-50">📦 Meus Pedidos</a>
                                @if(Auth::user()->is_admin ?? false) 
                                    <a href="{{ route('admin.orders.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-teal-50">⚙️ Painel Admin</a>
                                @endif
                                <div class="border-t border-gray-100 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">Sair</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="hidden md:inline-block text-sm font-bold text-teal-600 hover:text-teal-800 border border-teal-600 hover:bg-teal-50 px-4 py-2 rounded-full transition duration-200">
                            Entrar
                        </a>
                        <a href="{{ route('login') }}" class="md:hidden text-gray-400 hover:text-teal-500">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                        </a>
                    @endif

                    <button id="mobile-menu-button" class="md:hidden text-gray-400 hover:text-teal-500 focus:outline-none ml-2">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                </div>
            </div>
        </div>

        <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-100 absolute w-full left-0 shadow-lg z-40">
            <div class="px-4 pt-2 pb-4 space-y-1">
                <a href="{{ route('home') }}" class="block px-3 py-3 text-base font-medium text-gray-600 hover:text-teal-500 hover:bg-gray-50 rounded-md">A História</a>
                <a href="{{ route('shop') }}" class="block px-3 py-3 text-base font-medium text-gray-600 hover:text-teal-500 hover:bg-gray-50 rounded-md">Loja</a>
                <a href="{{ route('contact') }}" class="block px-3 py-3 text-base font-medium text-gray-600 hover:text-teal-500 hover:bg-gray-50 rounded-md">Contato</a>
                
                @if(Auth::check())
                    <div class="border-t border-gray-100 my-2 pt-2">
                        <p class="px-3 text-xs font-bold text-gray-400 uppercase mb-2">Conta</p>
                        <a href="{{ route('customer.dashboard') }}" class="block px-3 py-3 text-base font-medium text-teal-600 hover:bg-teal-50 rounded-md">📦 Meus Pedidos</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-3 py-3 text-base font-medium text-red-600 hover:bg-red-50 rounded-md">Sair</button>
                        </form>
                    </div>
                @else
                    <div class="border-t border-gray-100 my-2 pt-2">
                         <a href="{{ route('login') }}" class="block px-3 py-3 text-base font-medium text-teal-600 hover:bg-teal-50 rounded-md flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                            Entrar / Cadastrar
                         </a>
                    </div>
                @endif
            </div>
        </div>
    </header>

    <main class="flex-grow w-full">
        {{ $slot }}
    </main>

    <footer class="bg-gray-800 text-gray-300 mt-auto w-full">
        <div class="max-w-7xl mx-auto px-6 py-12">
            <div class="text-center">
                <h3 class="text-lg font-bold text-teal-400 mb-2">Vovó Lu Crochê</h3>
                <p class="text-sm text-gray-500">
                    &copy; {{ date('Y') }} Todos os direitos reservados.
                </p>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('mobile-menu-button');
            const menu = document.getElementById('mobile-menu');
            if(btn && menu) {
                btn.addEventListener('click', function() {
                    menu.classList.toggle('hidden');
                });
            }
        });
    </script>
</body>
</html>
