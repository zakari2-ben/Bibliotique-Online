<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliothèque en ligne - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans antialiased">

    <!-- Header -->
    <header class="bg-white border-b border-gray-200 shadow-sm">
        <nav class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <a href="index.html" class="text-gray-800 font-bold text-xl">Bibliothèque</a>
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-10 flex items-baseline space-x-4">
                            <a href="{{ route('index') }}" class="text-gray-600 hover:bg-gray-100 px-3 py-2 rounded-md text-sm font-medium">Accueil</a>
                            <a href="{{ route('books')}}" class="text-gray-600 hover:bg-gray-100 px-3 py-2 rounded-md text-sm font-medium">Recherche</a>
                            <a href="{{ route('about')}}" class="text-gray-600 hover:bg-gray-100 px-3 py-2 rounded-md text-sm font-medium">A propos</a>
                            <a href="{{ route('contact')}}" class="text-gray-600 hover:bg-gray-100 px-3 py-2 rounded-md text-sm font-medium">Contact</a>
                        </div>
                    </div>
                </div>
                <div class="hidden md:block">
                    <div class="ml-4 flex items-center md:ml-6">
                        <a href="#" class="text-gray-600 hover:bg-gray-100 font-medium rounded-md text-sm px-3 py-2">S'inscrire</a>
                        <a href="#" class="ml-3 text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-md text-sm px-3 py-2">Se connecter</a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-12">
        <div class="container mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h4 class="text-lg font-semibold text-gray-800">About Us</h4>
                    <p class="mt-2 text-gray-500">A simple library template for modern web applications.</p>
                </div>
                <div>
                    <h4 class="text-lg font-semibold text-gray-800">Important Link</h4>
                    <ul class="mt-2 space-y-2">
                        <li><a href="#" class="text-gray-500 hover:text-gray-900">Recherche</a></li>
                        <li><a href="#" class="text-gray-500 hover:text-gray-900">A propos</a></li>
                        <li><a href="#" class="text-gray-500 hover:text-gray-900">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold text-gray-800">Contact Info</h4>
                    <ul class="mt-2 space-y-2 text-gray-500">
                        <li>Email: info@example.com</li>
                        <li>Phone: +1 234 567 890</li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold text-gray-800">Newsletter</h4>
                    <form class="mt-4 flex">
                        <input type="email" placeholder="Email Address" class="w-full px-3 py-2 rounded-l-md bg-gray-100 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <button type="submit" class="px-4 py-2 rounded-r-md bg-blue-600 hover:bg-blue-700 text-white font-semibold">Go</button>
                    </form>
                </div>
            </div>
            <div class="mt-8 border-t border-gray-200 pt-8 text-center">
                <p class="text-gray-500 text-sm">Copyright &copy; 2025. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>
</html>
