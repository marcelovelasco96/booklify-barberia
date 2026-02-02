<?php

namespace App\Http\Controllers;

use App\Models\BlockedSlot;
use App\Models\Service;
use Illuminate\Http\Request;

class BlockedSlotController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('name')->get(['id', 'name']);

        $blockedSlots = BlockedSlot::with('service')
            ->orderBy('blocked_date', 'asc')
            ->orderBy('blocked_time', 'asc')
            ->paginate(20)
            ->withQueryString();

        return view('blocked-slots.index', compact('services', 'blockedSlots'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'service_id'    => ['required', 'exists:services,id'],
            'blocked_date'  => ['required', 'date'],
            'blocked_time'  => ['nullable', 'date_format:H:i'],
            'reason'        => ['nullable', 'string', 'max:255'],
        ]);

        BlockedSlot::create($data);

        return back()->with('success', 'Bloqueo registrado.');
    }

    public function destroy(BlockedSlot $blockedSlot)
    {
        $blockedSlot->delete();

        return back()->with('success', 'Bloqueo eliminado.');
    }
}
