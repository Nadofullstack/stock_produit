@extends('layouts.accueil')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-semibold">Gestion des ventes</h1>
        <p class="text-sm text-gray-600">Page de gestion des ventes. Le manager et le caissier peuvent accéder ici.</p>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        @if(session('success'))
            <div class="mb-4 text-sm text-green-700 bg-green-100 p-3 rounded">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="mb-4 text-sm text-red-700 bg-red-100 p-3 rounded">{{ session('error') }}</div>
        @endif

        <form action="{{ route('ventes.store') }}" method="POST" id="venteForm" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="produit_id" class="block text-sm font-medium text-gray-700">Produit</label>
                    <select name="produit_id" id="produit_id" class="mt-1 block w-full rounded-md border border-green-500 outline-none shadow-sm" required>
                        <option value="">Sélectionnez un produit</option>
                        @foreach($produits as $produit)
                            <option value="{{ $produit->id }}" data-price="{{ $produit->price }}" data-stock="{{ $produit->stock_quantity }}">{{ $produit->nom }} (Stock: {{ $produit->stock_quantity }})</option>
                        @endforeach
                    </select>
                    <!-- Affiche le stock actuel du produit sélectionné -->
                    <p id="stock_info" class="text-sm text-gray-500 mt-1">Sélectionnez un produit pour voir le stock disponible.</p>
                </div>

                <div>
                    <label for="quantite" class="block text-sm font-medium text-gray-700">Quantité</label>
                    <input type="number" name="quantite" id="quantite" class="mt-1 block w-full rounded-md border border-green-500 outline-none shadow-sm" min="1" required>
                    <!-- Message d'erreur côté client si la quantité dépasse le stock -->
                    <p id="quantite_error" class="text-sm text-red-600 mt-1"></p>
                    @error('quantite')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Prix unitaire (FCFA)</label>
                    <input type="text" id="prix_unitaire_display" class="mt-1 block w-full rounded-md border border-green-500 outline-none shadow-sm bg-gray-50" readonly>
                    <input type="hidden" id="prix_unitaire" name="prix_unitaire">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Total (FCFA)</label>
                    <input type="text" name="total" id="total_hidden" class="mt-1 block w-full rounded-md border border-green-500 outline-none shadow-sm bg-gray-50" readonly>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    Enregistrer la vente
                </button>
            </div>
        </form>

        <hr class="my-6">

        <h4 class="text-lg font-medium mb-4">Historique des ventes</h4>
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
                    @forelse($ventes as $vente)
                        <tr>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $vente->created_at->format('d/m/Y') }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $vente->produit_nom ?? ($vente->produit->nom ?? 'Produit supprimé') }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $vente->quantite }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ number_format($vente->prix_unitaire, 0, ',', ' ') }} FCFA</td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ number_format($vente->total, 0, ',', ' ') }} FCFA</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-sm text-gray-500">Aucune vente enregistrée</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@push('scripts')
<script>
    (function(){
        // Récupération des éléments du formulaire
        const select = document.getElementById('produit_id');
        const prixInput = document.getElementById('prix_unitaire');
        const prixDisplay = document.getElementById('prix_unitaire_display');
        const quantiteInput = document.getElementById('quantite');
        const totalHidden = document.getElementById('total_hidden');
        const stockInfo = document.getElementById('stock_info');
        const quantiteError = document.getElementById('quantite_error');

        /**
         * Met à jour l'affichage quand un produit est sélectionné.
         * - Affiche le prix unitaire
         * - Affiche le stock disponible
         * - Définit l'attribut `max` de l'input quantité pour limiter la saisie
         */
        function updateFromSelection(){
            const opt = select.options[select.selectedIndex];
            const price = parseFloat(opt?.dataset.price ?? 0) || 0;
            const stock = parseInt(opt?.dataset.stock ?? 0) || 0;

            // Affiche le prix (visuel) et met à jour le champ caché envoyé au serveur
            if(prixDisplay) prixDisplay.value = price;
            if(prixInput) prixInput.value = price;

            // Affiche le stock disponible
            if(stockInfo) stockInfo.textContent = 'Stock disponible : ' + stock;

            // Si stock = 0, prévenir l'utilisateur
            if(stock == 0) {
                if(quantiteError){
                    quantiteError.style.display = 'block';
                    quantiteError.textContent = 'Ce produit est en rupture de stock.';
                    
                }
                quantiteInput.max = 0;
                quantiteInput.value = '';
            } else {
                if(quantiteError){
                    quantiteError.style.display = 'none';
                    quantiteError.textContent = '';
                }
                // Limite de l'input quantité au stock disponible
                quantiteInput.max = stock;
            }

            computeTotal();
        }

        // Calcule le total et met à jour le champ total
        function computeTotal(){
            const price = parseFloat(prixInput.value) || 0;
            const qty = parseFloat(quantiteInput.value) || 0;
            const total = price * qty;
            if(totalHidden) totalHidden.value = total ? total : '';

            // Vérification côté client : quantité ne dépasse pas le stock (si défini)
            const max = parseInt(quantiteInput.max || 0) || 0;
            if(max > 0 && qty > max){
                if(quantiteError){
                    quantiteError.style.display = 'block';
                    quantiteError.textContent = 'Quantité insuffisante en stock. Stock actuel : ' + max;
                }
            } else {
                if(quantiteError){
                    quantiteError.style.display = 'none';
                    quantiteError.textContent = '';
                }
            }
        }

        // Empêche l'envoi du formulaire si la quantité demandée dépasse le stock
        const form = document.getElementById('venteForm');
        if(form){
            form.addEventListener('submit', function(e){
                const max = parseInt(quantiteInput.max || 0) || 0;
                const qty = parseInt(quantiteInput.value || 0) || 0;
                if(max > 0 && qty > max){
                    e.preventDefault();
                    if(quantiteError){
                        quantiteError.style.display = 'block';
                        quantiteError.textContent = 'Impossible d\'enregistrer : la quantité demandée dépasse le stock disponible (' + max + ').';
                    }
                    return false;
                }
            });
        }

        // Listeners
        if(select) select.addEventListener('change', updateFromSelection);
        if(quantiteInput) quantiteInput.addEventListener('input', computeTotal);
        if(prixInput) prixInput.addEventListener('input', computeTotal);

        // Initialisation au chargement de la page (si une valeur est déjà sélectionnée)
        document.addEventListener('DOMContentLoaded', function(){
            if(select && select.value) updateFromSelection();
        });
    })();
</script>
@endpush
@endsection
