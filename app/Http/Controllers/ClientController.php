<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {

        $validated = $request->validate([
            'fullName' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'package' => 'required|string|max:255',
            'payMethode' => 'required|string|max:255',
            'reservation' => '',
            'totalAmount' => 'required|max:255',
            'Note' => 'string|max:552',
        ]);

        Client::create($validated);

        return redirect(route('home'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id)
    {

         $client = Client::find( $id);

         if ($client) {
            // Client found, do something with it
            return response()->json($client);
        } else {
            // Client not found
            return response()->json(['error' => 'Client not found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client) : RedirectResponse
    {
        $validated = $request->validate([
            'fullName' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'package' => 'required|string|max:255',
            'payMethode' => 'required|string|max:255',
            'reservation' => 'string|max:255',
            'totalAmount' => 'required|numeric|max:255',
            'Note' => 'required|string|max:255',
        ]);
        $client->update($validated);

        return redirect(route('dashboard'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client) : RedirectResponse
    {
        $client->delete();

        return redirect(route('dashboard'));
    }
    /**
     * Filter Data day by day
     */
    public function dataFilter(Request $request)
    {
        try {
            $validated = $request->validate([
                'date' => 'required|date',
            ]);
             // Convert the date string to a Carbon instance
             $clients =  DB::table('clients')
             ->whereDate('created_at', $validated['date'])->get();
             return Inertia::render('Dashboard', [
                'clients' => $clients,
            ]);


        } catch (ValidationException $e) {
            // If validation fails, redirect back
            return back()->withErrors($e->validator)->withInput();
        }




    }

}
