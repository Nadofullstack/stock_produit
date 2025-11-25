<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Achat;
use App\Models\Produit;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AchatController extends Controller
{
    public function index(){
        $achats = Achat::all();
        $produits = Produit::all();
        return view('achats.index', compact('achats', 'produits'));
    }

    /**
     * Enregistre un achat et augmente le stock du produit.
     *
     * - Valide les données reçues.
     * - Verrouille la ligne produit en base (lockForUpdate) pour éviter les races conditions.
     * - Crée l'enregistrement d'achat et incrémente le stock dans une transaction.
     * - En cas d'erreur (produit introuvable), renvoie les erreurs au formulaire.
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

                $total = $request->quantite * $request->prix_unitaire;

                Achat::create([
                    'produit_id' => $request->produit_id,
                    'produit_nom' => $produit->nom,
                    'quantite' => $request->quantite,
                    'prix_unitaire' => $request->prix_unitaire,
                    'total' => $total,
                ]);
              

                // Incrémente le stock
                $produit->stock_quantity = max(0, $produit->stock_quantity + $request->quantite);
                $produit->save();
            });
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }

        return redirect()->route('achats.index')->with('success', 'Achat enregistré avec succès.');
    }
}
