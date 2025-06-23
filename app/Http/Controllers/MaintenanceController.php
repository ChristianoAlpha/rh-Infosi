<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Maintenance;
use App\Models\Vehicle;

class MaintenanceController extends Controller
{
    public function index()
    {
        $records = Maintenance::with('vehicle')->orderByDesc('maintenanceDate')->get();
        return view('maintenance.index', compact('records'));
    }

    public function create()
    {
        $vehicles = Vehicle::where('status','!=','Unavailable')->get();
        return view('maintenance.create', compact('vehicles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'vehicleId'       => 'required|exists:vehicles,id',
            'type'            => 'required|in:Preventive,Corrective',
            'maintenanceDate' => 'required|date|before_or_equal:today',
            'cost'            => 'required|numeric',
            'description'     => 'nullable|string',
        ]);

        $record = Maintenance::create($data);

        Vehicle::find($data['vehicleId'])
               ->update(['lastMaintenanceDate' => $data['maintenanceDate']]);

        return redirect()->route('maintenance.index')
                         ->with('msg','Maintenance record added.');
    }

    public function show(Maintenance $maintenance)
    {
        $maintenance->load('vehicle');
        return view('maintenance.show', compact('maintenance'));
    }

    public function edit(Maintenance $maintenance)
    {
        $vehicles = Vehicle::all();
        return view('maintenance.edit', compact('maintenance','vehicles'));
    }

    public function update(Request $request, Maintenance $maintenance)
    {
        $data = $request->validate([
            'vehicleId'       => 'required|exists:vehicles,id',
            'type'            => 'required|in:Preventive,Corrective',
            'maintenanceDate' => 'required|date|before_or_equal:today',
            'cost'            => 'required|numeric',
            'description'     => 'nullable|string',
        ]);

        $maintenance->update($data);

        Vehicle::find($data['vehicleId'])
               ->update(['lastMaintenanceDate' => $data['maintenanceDate']]);

        return redirect()->route('maintenance.edit',$maintenance)
                         ->with('msg','Maintenance updated.');
    }

    public function destroy(Maintenance $maintenance)
    {
        $maintenance->delete();
        return redirect()->route('maintenance.index')
                         ->with('msg','Maintenance record deleted.');
    }
}
