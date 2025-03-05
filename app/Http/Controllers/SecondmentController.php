<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Secondment;
use App\Models\Employeee;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class SecondmentController extends Controller
{
    public function index()
    {
        $data = Secondment::with('employee')->orderByDesc('id')->get();
        return view('secondment.index', compact('data'));
    }

    public function create()
    {
        return view('secondment.create');
    }

    /**
     * Busca um funcionário por ID ou nome.
     */
    public function searchEmployee(Request $request)
    {
        $request->validate([
            'employeeSearch' => 'required|string',
        ]);

        $term = $request->employeeSearch;
        $employee = Employeee::where('id', $term)
            ->orWhere('fullName', 'LIKE', "%$term%")
            ->first();

        if (!$employee) {
            return redirect()->back()
                ->withErrors(['employeeSearch' => 'Funcionário não encontrado!'])
                ->withInput();
        }

        return view('secondment.create', [
            'employee' => $employee,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'employeeId'       => 'required|integer|exists:employeees,id',
            'causeOfTransfer'  => 'nullable|string',
            'institution'      => 'required|string',
            'supportDocument'  => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx',
        ]);

        $data = $request->all();

        if ($request->hasFile('supportDocument')) {
            $file = $request->file('supportDocument');
            $filename = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('/uploads/secondments');
            $file->move($destinationPath, $filename);
            $data['supportDocument'] = $filename;
            $data['originalFileName'] = $file->getClientOriginalName();
        }

        Secondment::create([
            'employeeId'      => $data['employeeId'],
            'causeOfTransfer' => $data['causeOfTransfer'] ?? null,
            'institution'     => $data['institution'],
            'supportDocument' => $data['supportDocument'] ?? null,
            'originalFileName'=> $data['originalFileName'] ?? null,
        ]);

        return redirect()->route('secondment.index')
                         ->with('msg', 'Destacamento registrado com sucesso!');
    }

    public function show($id)
    {
        $data = Secondment::with('employee')->findOrFail($id);
        return view('secondment.show', compact('data'));
    }

    public function edit($id)
    {
        $data = Secondment::findOrFail($id);
        return view('secondment.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'causeOfTransfer'  => 'nullable|string',
            'institution'      => 'required|string',
            'supportDocument'  => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx',
        ]);

        $secondment = Secondment::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('supportDocument')) {
            $file = $request->file('supportDocument');
            $filename = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('/uploads/secondments');
            $file->move($destinationPath, $filename);
            $data['supportDocument'] = $filename;
            $data['originalFileName'] = $file->getClientOriginalName();
        } else {
            $data['supportDocument'] = $secondment->supportDocument;
            $data['originalFileName'] = $secondment->originalFileName;
        }

        $secondment->update([
            'causeOfTransfer' => $data['causeOfTransfer'] ?? null,
            'institution'     => $data['institution'],
            'supportDocument' => $data['supportDocument'],
            'originalFileName'=> $data['originalFileName'],
        ]);

        return redirect()->route('secondment.edit', $id)
                         ->with('msg', 'Destacamento atualizado com sucesso!');
    }

    public function destroy($id)
    {
        Secondment::destroy($id);
        return redirect()->route('secondment.index');
    }

    // Opcional: Gerar PDF de todos os destacamentos
    public function pdfAll()
    {
        $allSecondments = Secondment::with('employee')->get();
        $pdf = PDF::loadView('secondment.secondment_pdf', compact('allSecondments'))
                  ->setPaper('a3', 'portrait');
        return $pdf->stream('RelatorioDestacamentos.pdf');
    }
}
