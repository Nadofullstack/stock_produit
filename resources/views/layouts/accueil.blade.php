<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
    <script src="{{ asset('3.4.17') }}"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Tailwind Play CDN for quick styling -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 min-h-screen">
    <nav class="bg-white  border-b">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4" >
                 <div class="flex items-center space-x-4">
                    <h1 class="text-xl font-bold text-gray-800">Gestion de Caisse</h1>
                </div>
            <div>
                @guest
                    <a href="/"></a>
                @endguest
            </div>

            @auth
               <div class="flex items-center space-x-4">
                 <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                  @if(auth()->user()->role === 'admin') bg-red-100 text-red-800
                @elseif(auth()->user()->role === 'manager') bg-purple-100 text-purple-800
                 @else bg-blue-100 text-blue-800
                @endif">
                    {{ ucfirst(auth()->user()->role) }}
                </span>

                @can('see-admin-menu')
                    <a href="{{ route('admin.users') }}">Liste des utilisateurs</a>
                    <a href="{{ route('achats.index') }}">Gérer les achats</a>
                    <a href="{{ route('produits.index') }}">Ajouter un produit</a>
                @endcan

                @can('see-manager-menu')
                    <a href="{{ route('achats.index') }}">Gérer les achats</a>
                    <a href="{{ route('ventes.index') }}">Gérer les ventes</a>
                @endcan

                @can('see-caisse-menu')
                    <a href="{{ route('ventes.index') }}">Voir / effectuer des ventes</a>
                @endcan

               </div>
            @endauth


            <!-- Déconnexion -->
            @auth
                <form action="{{ route('logout') }}" method="GET" class="inline">
                    @csrf
                    <button type="submit"
                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center">

                        Déconnexion
                    </button>
                </form>
            @endauth


          

        </div>
        </div>
    </nav>

      <main class="max-w-7xl mx-auto py-8 px-4">
                @yield('content')
            </main>

    @stack('scripts')
</body>

</html>