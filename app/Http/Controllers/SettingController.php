<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SettingController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Setting::class);

        $settings = Setting::with('entreprise')->latest()->paginate();

        return view('settings.index', compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Setting::class);

        return view('settings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Setting::class);

        $validated = $request->validate([
            'entreprise_id' => 'required|exists:entreprises,id',
            'tva' => 'required|numeric|min:0|max:100',
            'caution_standard' => 'required|numeric|min:0',
            'tarif_km_supplementaire' => 'required|numeric|min:0',
            'email_notification' => 'required|email',
            'logo_facture' => 'nullable|string',
            'devise' => 'required|string|max:10',
        ]);

        $setting = Setting::create($validated);

        return response()->json($setting, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Setting $setting)
    {
        $this->authorize('view', $setting);

        $setting->load('entreprise');

        return view('settings.show', compact('setting'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setting $setting)
    {
        $this->authorize('update', $setting);

        return view('settings.edit', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Setting $setting)
    {
        $this->authorize('update', $setting);

        $validated = $request->validate([
            'entreprise_id' => 'sometimes|required|exists:entreprises,id',
            'tva' => 'sometimes|required|numeric|min:0|max:100',
            'caution_standard' => 'sometimes|required|numeric|min:0',
            'tarif_km_supplementaire' => 'sometimes|required|numeric|min:0',
            'email_notification' => 'sometimes|required|email',
            'logo_facture' => 'nullable|string',
            'devise' => 'sometimes|required|string|max:10',
        ]);

        $setting->update($validated);

        return response()->json($setting);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $setting)
    {
        $this->authorize('delete', $setting);

        $setting->delete();

        return response()->json(null, 204);
    }
}
