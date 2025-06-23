<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\Driver;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::with('drivers')->orderByDesc('id')->get();
        return view('vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        $drivers = Driver::where('status','Active')->get();
        return view('vehicles.create', compact('drivers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'plate'           => 'required|string|unique:vehicles,plate',
            'model'           => 'required|string',
            'brand'           => 'required|string',
            'yearManufacture' => 'required|integer',
            'color'           => 'required|string',
            'loadCapacity'    => 'required|numeric',
            'status'          => 'required|in:Available,UnderMaintenance,Unavailable',
            'notes'           => 'nullable|string',
            'driverId'        => 'nullable|exists:drivers,id',
            'startDate'       => 'nullable|date',
        ]);

        $vehicle = Vehicle::create($data);

        if (!empty($data['driverId']) && !empty($data['startDate'])) {
            $vehicle->drivers()->attach($data['driverId'], [
                'startDate' => $data['startDate']
            ]);
        }

        return redirect()->route('vehicles.index')
                         ->with('msg','Vehicle registered successfully.');
    }

    public function show(Vehicle $vehicle)
    {
        $vehicle->load('drivers','maintenance');
        return view('vehicles.show', compact('vehicle'));
    }

    public function edit(Vehicle $vehicle)
    {
        $drivers = Driver::where('status','Active')->get();
        return view('vehicles.edit', compact('vehicle','drivers'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $data = $request->validate([
            'plate'           => "required|string|unique:vehicles,plate,{$vehicle->id}",
            'model'           => 'required|string',
            'brand'           => 'required|string',
            'yearManufacture' => 'required|integer',
            'color'           => 'required|string',
            'loadCapacity'    => 'required|numeric',
            'status'          => 'required|in:Available,UnderMaintenance,Unavailable',
            'notes'           => 'nullable|string',
            'driverId'        => 'nullable|exists:drivers,id',
            'startDate'       => 'nullable|date',
            'endDate'         => 'nullable|date|after_or_equal:startDate',
        ]);

        $vehicle->update($data);

        if (!empty($data['driverId'])) {
            $vehicle->drivers()
                    ->wherePivotNull('endDate')
                    ->updateExistingPivot(
                        $vehicle->drivers->pluck('id')->toArray(),
                        ['endDate' => now()->toDateString()]
                    );

            $vehicle->drivers()->attach($data['driverId'], [
                'startDate' => $data['startDate'] ?? now()->toDateString()
            ]);
        }

        return redirect()->route('vehicles.edit',$vehicle)
                         ->with('msg','Vehicle updated.');
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        return redirect()->route('vehicles.index')
                         ->with('msg','Vehicle deleted.');
    }

    public function pdfAll()
    {
        $vehicles = Vehicle::with('drivers')->orderBy('plate')->get();
        $pdf = PDF::loadView('vehicles.pdf', compact('vehicles'))
                  ->setPaper('a4','landscape');
        return $pdf->stream('Vehicles_Report.pdf');
    }
}
