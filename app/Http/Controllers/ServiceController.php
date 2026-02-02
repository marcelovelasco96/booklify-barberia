<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('created_at', 'desc')->get();
        return view('services.index', compact('services'));
    }

    public function create()
    {
        return view('services.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'duration_minutes' => 'required|integer|min:5',
            'price' => 'nullable|numeric|min:0',
            'is_active' => 'sometimes|boolean',
        ]);

        Service::create($validated);

        return redirect()->route('services.index')
            ->with('success', 'Servicio creado correctamente.');
    }

    public function edit(Service $service)
    {
        return view('services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'duration_minutes' => 'required|integer|min:5',
            'price' => 'nullable|numeric|min:0',
            'is_active' => 'sometimes|boolean',
        ]);

        $service->update($validated);

        return redirect()->route('services.index')
            ->with('success', 'Servicio actualizado correctamente.');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('services.index')
            ->with('success', 'Servicio eliminado correctamente.');
    }
}