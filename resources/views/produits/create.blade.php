@extends('layouts.accueil')

@section('content')
<div class="max-w-xl mx-auto bg-white p-8 rounded-xl shadow-md mt-10">
    <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">
        Ajouter un Produit
    </h2>

    <form action="{{ route('produits.store') }}" method="POST">
        @csrf

        {{-- Nom du produit --}}
        <div class="mb-5">
            <label class="block text-gray-700 font-semibold mb-2">Nom du produit</label>
            <input 
                type="text" 
                name="nom" 
                class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                placeholder="Entrez le nom du produit"
                required
            >
            @error('nom')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Prix --}}
        <div class="mb-5">
            <label class="block text-gray-700 font-semibold mb-2">Prix</label>
            <input 
                type="number" 
                name="price" 
                step="1"
                class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                placeholder="Entrez le prix"
                required
            >
            @error('price')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Quantité en stock --}}
        <div class="mb-5">
            <label class="block text-gray-700 font-semibold mb-2">Quantité en stock</label>
            <input 
                type="number" 
                name="stock_quantity" 
                class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                placeholder="Entrez la quantité"
                required
            >
            @error('stock_quantity')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Bouton d'envoi --}}
        <div class="text-center">
            <button 
                type="submit" 
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition">
                Ajouter le produit
            </button>
        </div>
    </form>
</div>
@endsection
