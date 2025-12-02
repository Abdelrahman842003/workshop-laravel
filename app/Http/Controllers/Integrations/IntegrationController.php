<?php

namespace App\Http\Controllers\Integrations;

use App\Http\Controllers\Controller;

use App\Http\Requests\Integrations\StoreIntegrationRequest;
use App\Http\Requests\Integrations\UpdateIntegrationRequest;
use App\Models\Integration;
use App\Models\IntegrationLog;

class IntegrationController extends Controller
{
    public function index()
    {
        $integrations = Integration::latest()->get();
        return view('integrations.index', compact('integrations'));
    }

    public function create()
    {
        return view('integrations.create');
    }

    public function store(StoreIntegrationRequest $request)
    {
        Integration::create($request->validated());

        return redirect()->route('integrations.index')->with('success', 'Integration created successfully.');
    }

    public function edit(Integration $integration)
    {
        $integration->load('fieldMappings');
        return view('integrations.edit', compact('integration'));
    }

    public function update(UpdateIntegrationRequest $request, Integration $integration)
    {
        $validated = $request->validated();

        $integration->update([
            'name' => $validated['name'],
            'credentials' => $validated['credentials'] ?? $integration->credentials, // Keep old if not provided
            'settings' => $validated['settings'] ?? $integration->settings,
        ]);

        // Sync Mappings
        $integration->fieldMappings()->delete();
        if (!empty($validated['mappings'])) {
            $integration->fieldMappings()->createMany($validated['mappings']);
        }

        return redirect()->route('integrations.index')->with('success', 'Integration updated successfully.');
    }

    public function logs(Integration $integration)
    {
        $logs = $integration->logs()->latest('occurred_at')->paginate(20);
        return view('integrations.logs', compact('integration', 'logs'));
    }
}
