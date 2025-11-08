<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;

class ClientAccountController extends Controller
{
    /**
     * Display the authenticated client's account statement
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        // Verificar que el usuario tenga un perfil de cliente asociado
        if (!$user->client) {
            abort(403, 'No tienes acceso a esta sección');
        }

        $clientId = $user->client->id;

        return view('client.account-statement-page', compact('clientId'));
    }

    /**
     * Display a specific client's account statement (for admins/asesores)
     */
    public function show(Client $client)
    {
        $this->authorize('account.view');

        $clientId = $client->id;

        return view('client.account-statement-page', compact('clientId'));
    }
}
