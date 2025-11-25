@extends('layouts.accueil')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold">Liste des produits</h1>
            <p class="text-sm text-gray-600">Tous les produits disponibles en stock.</p>
        </div>
        <div>
            <a href="{{ route('produits.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Ajouter un produit</a>
        </div>
    </div>

    @if(session('success'))
        <div class="text-sm text-green-700 bg-green-100 p-3 rounded">{{ session('success') }}</div>
    @endif

    <div class="bg-white shadow rounded-lg p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Nom</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Prix</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Stock</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($produits as $produit)
                        <tr>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $produit->nom }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ number_format($produit->price, 1, ',', ' ') }} FCFA</td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $produit->stock_quantity }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-6 text-center text-sm text-gray-500">Aucun produit trouvé</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
