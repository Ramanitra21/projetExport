<?php

namespace App\Http\Controllers;

use App\Models\SellPound;
use Illuminate\Http\Request;

class SellPoundController extends Controller
{
    public function create(Request $request)
    {
        // Validation des données de la requête
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'nom_coli' => 'required|string|max:255',
            'pays_depart' => 'required|string|max:100',
            'ville_depart' => 'required|string|max:100',
            'aeroport_depart' => 'required|string|max:100',
            'date_depart' => 'required|date',
            'pays_destination' => 'required|string|max:100',
            'ville_destination' => 'required|string|max:100',
            'aeroport_destination' => 'required|string|max:100',
            'date_arrive' => 'required|date',
            'poid' => 'required|numeric',
            'numero_telephone' => 'required|string|max:20',
            'img_tiket_embarquement' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'img_passeport' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        // Gestion des fichiers téléchargés
        if ($request->hasFile('img_tiket_embarquement')) {
            $data['img_tiket_embarquement'] = $request->file('img_tiket_embarquement')->store('uploads/tickets', 'public');
        }

        if ($request->hasFile('img_passeport')) {
            $data['img_passeport'] = $request->file('img_passeport')->store('uploads/passports', 'public');
        }

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('uploads/photos', 'public');
        }

        // Créer l'enregistrement dans la base de données
        $sellPound = SellPound::create($data);

        // Retourner une réponse JSON
        return response()->json([
            'message' => 'Enregistrement créé avec succès.',
            'data' => $sellPound
        ], 201);
    }

    public function achat(Request $request)
    {
        // Validation des données de la requête
        $request->validate([
            'user_client_id' => 'required|integer',
            'sellpound_id' => 'required|integer|exists:sellpound,id',
            'poids' => 'required|numeric|min:0.01',
            'nom_colis' => 'required|string|max:255',
            'description_colis' => 'nullable|string',
            'type_colis' => 'required|string|max:100',
            'image_colis' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Récupérer le SellPound correspondant
        $sellPound = SellPound::find($request->sellpound_id);

        // Vérifier que le poids demandé est disponible
        if ($sellPound->poid < $request->poids) {
            return response()->json([
                'message' => 'Le poids demandé dépasse le poids disponible.'
            ], 400);
        }

        // Réduire le poids disponible du SellPound
        $sellPound->poid -= $request->poids;
        $sellPound->save();

        // Sauvegarder l'achat dans la base de données
        $achatData = [
            'user_client_id' => $request->user_client_id,
            'sellpound_id' => $request->sellpound_id,
            'poids' => $request->poids,
            'nom_colis' => $request->nom_colis,
            'description_colis' => $request->description_colis,
            'type_colis' => $request->type_colis,
            'image_colis' => $request->file('image_colis') ? $request->file('image_colis')->store('uploads/colis', 'public') : null,
        ];

        // Insérer dans la table `achat`
        $achat = \DB::table('achat')->insert($achatData);

        return response()->json([
            'message' => 'Achat effectué avec succès.',
            'data' => $achatData
        ], 201);
    }

    public function getAvailableSellPounds()
    {
        // Récupérer tous les SellPound avec un poids supérieur à 0
        $sellPounds = SellPound::where('poid', '>', 0)->get();

        // Retourner une réponse JSON
        return response()->json([
            'message' => 'Liste des SellPounds disponibles.',
            'data' => $sellPounds
        ], 200);
    }

}
