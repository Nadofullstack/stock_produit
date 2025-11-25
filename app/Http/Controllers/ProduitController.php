<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;

class ProduitController extends Controller
{
        /** Display a listing of products. */
    public function index()
    {
        $produits = Produit::orderBy('nom')->get();
        return view('produits.index', compact('produits'));
    }

    /** Show the form for creating a new product. */
    public function create()
    {
        return view('produits.create');
    }

    //function pour stocker un nouveau produit
    public function store(Request $request)
    {
        $data = $request->validate([
            'nom' => 'required|string|max:255',
            'price' => 'required|numeric|min:1',
            'stock_quantity' => 'required|integer|min:0',
        ]);

        Produit::create($data);

        return redirect()->route('produits.index')->with('success', 'Produit ajouté avec succès.');
    }
}
