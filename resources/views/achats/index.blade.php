@extends('layouts.accueil')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-semibold">Gestion des achats</h1>
        <p class="text-sm text-gray-600">Page de gestion des achats. Le manager et l'admin peuvent accéder ici.</p>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        @if(session('success'))
            <div class="mb-4 text-sm text-green-700 bg-green-100 p-3 rounded">{{ session('success') }}</div>
        @endif

        <form action="{{ route('achats.store') }}" method="POST" id="achatForm" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="produit_id" class="block text-sm font-medium text-gray-700">Produit</label>
                    <select name="produit_id" id="produit_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        <option value="">Sélectionnez un produit</option>
                        @foreach($produits as $produit)
                            <option value="{{ $produit->id }}" data-price="{{ $produit->price }}" data-stock="{{ $produit->stock_quantity }}">{{ $produit->nom }} (Stock: {{ $produit->stock_quantity }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="quantite" class="block text-sm font-medium text-gray-700">Quantité</label>
                    <input type="number" name="quantite" id="quantite" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" min="1" required>
                </div>
            </div>
                @push('scripts')
                <script>
                    (function(){
                        const select = document.getElementById('produit_id');
                        const prixInput = document.getElementById('prix_unitaire');
                        const stockInput = document.getElementById('stock_actuel');
                        const quantiteInput = document.getElementById('quantite');
                        const totalInput = document.getElementById('total');
                        const totalHidden = document.getElementById('total_hidden');

                        function updateFromSelection(){
                            const opt = select.options[select.selectedIndex];
                            const price = parseFloat(opt?.dataset.price ?? 0) || 0;
                            const stock = opt?.dataset.stock ?? '';
                            if(document.getElementById('prix_unitaire_display')) document.getElementById('prix_unitaire_display').value = price;
                            if(prixInput) prixInput.value = price;
                            stockInput.value = stock;
                            computeTotal();
                        }
                         
                        function computeTotal(){
                            const price = parseFloat(prixInput.value) || 0;
                            const qty = parseFloat(quantiteInput.value) || 0;
                            const total = price * qty;
                            if(totalInput) totalInput.value = total ? total.toFixed(2) : '';
                            if(totalHidden) totalHidden.value = total ? total : '';
                        }

                        if(select) select.addEventListener('change', updateFromSelection);
                        if(quantiteInput) quantiteInput.addEventListener('input', computeTotal);
                        if(prixInput) prixInput.addEventListener('input', computeTotal);

                        // initialize if already selected
                        document.addEventListener('DOMContentLoaded', function(){
                            if(select && select.value) updateFromSelection();
                        });
                    })();
                </script>
                @endpush

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Prix unitaire (FCFA)</label>
                    <input type="text" id="prix_unitaire_display" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-50" readonly>
                    <input type="hidden" id="prix_unitaire" name="prix_unitaire">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Quantité en stock</label>
                    <input type="text" id="stock_actuel" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-50" readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Total (FCFA)</label>
                    <input type="text" id="total" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-50" readonly>
                    <input type="hidden" name="total" id="total_hidden">
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                    <i class="fas fa-save"></i> Enregistrer l'achat
                </button>
            </div>
        </form>

        <hr class="my-6">

        <h4 class="text-lg font-medium mb-4">Historique des achats</h4>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Date</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Produit</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Quantité</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Prix unitaire</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Total</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($achats as $achat)
                        <tr>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $achat->created_at->format('d/m/Y') }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $achat->produit_nom ?? ($achat->produit->nom ?? 'Produit supprimé') }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $achat->quantite }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ number_format($achat->prix_unitaire, 0, ',', ' ') }} FCFA</td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ number_format($achat->total, 0, ',', ' ') }} FCFA</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-sm text-gray-500">Aucun achat enregistré</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
