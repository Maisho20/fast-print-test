<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen">

    <nav class="bg-indigo-600 text-white px-6 py-4 shadow">
        <div class="flex justify-between items-center">
            <h1 class="font-bold text-lg">Fast Print Test</h1>
            <div class="space-x-4">
                <a href="{{ route('produk.index') }}" class="hover:underline">Produk</a>
                <a href="{{ route('produk.bisaDijual') }}" class="hover:underline">Bisa Dijual</a>
            </div>
        </div>
    </nav>

    <main class="p-6">
        @yield('content')
    </main>
</body>

</html>
