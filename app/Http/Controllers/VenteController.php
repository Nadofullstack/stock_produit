<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vente;
use App\Models\Produit;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class VenteController extends Controller
{
public function index(Request $request)
{
    $ventes = Vente::all();
    $produits = Produit::all();

    // Récupère la quantité entrée ou 1 par défaut
    $quantite = $request->input('quantite', 1);

    $prix_unitaire = 0;
    $total = 0;

    // Si un produit est sélectionné
    if ($request->filled('produit_id')) {

        $produit = Produit::find($request->produit_id);

        if ($produit) {
            $prix_unitaire = $produit->price;
            $total = $prix_unitaire * $quantite;
        }
    }

    return view('ventes.index', compact(
        'ventes', 
        'produits', 
        'quantite', 
        'prix_unitaire', 
        'total'
    ));
}


    /**
     * Enregistre une vente et décrémente le stock du produit.
     *
     * - Valide les données reçues.
     * - Verrouille la ligne produit en base (lockForUpdate) pour éviter les races conditions.
     * - Vérifie que la quantité demandée est disponible en stock.
     * - Crée l'enregistrement de la vente et décrémente le stock dans une transaction.
     * - En cas d'erreur de validation (ex: stock insuffisant), renvoie les erreurs au formulaire.
     */
    public function store(Request $request){
        $request->validate([
            'produit_id' => 'required|exists:produits,id',
            'quantite' => 'required|integer|min:1',
            'prix_unitaire' => 'required|numeric|min:0',
        ]);

       
        try {
            DB::transaction(function() use ($request) {
                $produit = Produit::where('id', $request->produit_id)->lockForUpdate()->first();

                if (! $produit) {
                    throw ValidationException::withMessages(['produit_id' => 'Produit introuvable.']);
                }

                if ($produit->stock_quantity < $request->quantite) {
                    throw ValidationException::withMessages(['quantite' => 'Stock insuffisant. Stock actuel: ' . $produit->stock_quantity]);
                }

                $total = $request->quantite * $request->prix_unitaire;

                Vente::create([
                    'produit_id' => $request->produit_id,
                    'produit_nom' => $produit->nom,
                    'quantite' => $request->quantite,
                    'prix_unitaire' => $request->prix_unitaire,
                    'total' => $total,
                ]);

                // Décrémente le stock
                $produit->stock_quantity = max(0, $produit->stock_quantity - $request->quantite);
                $produit->save();
            });
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }

        return redirect()->route('ventes.index')->with('success', 'Vente enregistrée avec succès.');
    }
}