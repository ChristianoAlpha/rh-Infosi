<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Maintenance;
use App\Models\Vehicle;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Storage;

class MaintenanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Maintenance::with('vehicle');
        if ($request->filled('startDate')) {
            $query->whereDate('maintenanceDate','>=',$request->startDate);
        }
        if ($request->filled('endDate')) {
            $query->whereDate('maintenanceDate','<=',$request->endDate);
        }
        $records = $query->orderByDesc('maintenanceDate')->get();
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
            'invoice_pre'     => 'nullable|file|mimes:pdf,jpg,png',
            'invoice_post'    => 'nullable|file|mimes:pdf,jpg,png',
        ]);

        if ($request->hasFile('invoice_pre')) {
            $data['invoice_pre'] = $request->file('invoice_pre')->store('invoices/pre');
        }
        if ($request->hasFile('invoice_post')) {
            $data['invoice_post'] = $request->file('invoice_post')->store('invoices/post');
        }

        $record = Maintenance::create($data);
        Vehicle::find($data['vehicleId'])
               ->update(['lastMaintenanceDate' => $data['maintenanceDate']]);

        return redirect()->route('maintenance.index')
                         ->with('msg','Registro de manutenção adicionado.');
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
            'invoice_pre'     => 'nullable|file|mimes:pdf,jpg,png',
            'invoice_post'    => 'nullable|file|mimes:pdf,jpg,png',
        ]);

        if ($request->hasFile('invoice_pre')) {
            // remove antigo se existir
            optional($maintenance->invoice_pre, fn($f) => Storage::delete($f));
            $data['invoice_pre'] = $request->file('invoice_pre')->store('invoices/pre');
        }
        if ($request->hasFile('invoice_post')) {
            optional($maintenance->invoice_post, fn($f) => Storage::delete($f));
            $data['invoice_post'] = $request->file('invoice_post')->store('invoices/post');
        }

        $maintenance->update($data);
        Vehicle::find($data['vehicleId'])
               ->update(['lastMaintenanceDate' => $data['maintenanceDate']]);

        return redirect()->route('maintenance.edit',$maintenance)
                         ->with('msg','Manutenção atualizada.');
    }

    public function exportFilteredPDF(Request $request)
        {
            $query = Maintenance::with('vehicle');
            if ($request->filled('startDate')) {
                $query->whereDate('maintenanceDate','>=',$request->startDate);
            }
            if ($request->filled('endDate')) {
                $query->whereDate('maintenanceDate','<=',$request->endDate);
            }
            $filtered = $query->orderByDesc('id')->get();

            $pdf = PDF::loadView('maintenance.maintenance_pdf', compact('filtered'))
                    ->setPaper('a4','portrait');

            return $pdf->download('Manutencoes_Filtradas.pdf');
        }

        public function pdfAll(Request $request)
        {
            $query = Maintenance::with('vehicle');
            if ($request->filled('startDate')) {
                $query->whereDate('maintenanceDate','>=',$request->startDate);
            }
            if ($request->filled('endDate')) {
                $query->whereDate('maintenanceDate','<=',$request->endDate);
            }
            $all = $query->orderByDesc('id')->get();

            $filename = 'Manutencoes' . (
                $request->filled('startDate')||$request->filled('endDate')
                ? '_Filtradas' : ''
            ) . '.pdf';

            $pdf = PDF::loadView('maintenance.maintenance_pdf', ['filtered'=>$all])
                    ->setPaper('a4','portrait');

            return $pdf->stream($filename);
        }


        public function showPdf(Maintenance $maintenance)
        {
            $maintenance->load('vehicle');
            $pdf = PDF::loadView('maintenance.maintenance_pdf_individual', compact('maintenance'))
                    ->setPaper('a4','portrait');
            return $pdf->stream("Manutencao_{$maintenance->id}.pdf");
        }

        
    public function destroy(Maintenance $maintenance)
    {
        // apaga arquivos junto
        optional($maintenance->invoice_pre, fn($f) => Storage::delete($f));
        optional($maintenance->invoice_post, fn($f) => Storage::delete($f));
        $maintenance->delete();
        return redirect()->route('maintenance.index')
                         ->with('msg','Registro de manutenção excluído.');
    }

    
}
