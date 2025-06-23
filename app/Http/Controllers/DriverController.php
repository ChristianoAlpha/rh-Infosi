<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver;
use App\Models\Employeee;

class DriverController extends Controller
{
    public function index()
    {
        $drivers = Driver::with('employee')->orderByDesc('id')->get();
        return view('drivers.index', compact('drivers'));
    }

    public function create()
    {
        $employees = Employeee::where('employmentStatus','active')->get();
        return view('drivers.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'employeeId'      => 'nullable|exists:employeees,id',
            'fullName'        => 'required_without:employeeId|string|max:100',
            'bi'              => 'required_without:employeeId|alpha_num|size:16|unique:drivers,bi',
            'licenseNumber'   => 'required|string|max:50|unique:drivers,licenseNumber',
            'licenseCategory' => 'required|string|max:50',
            'licenseExpiry'   => 'required|date|after:today',
            'status'          => 'required|in:Active,Inactive',
        ], [
            'bi.size'       => 'O bilhete de identidade deve ter exatamente 16 caracteres.',
            'bi.alpha_num'  => 'O bilhete de identidade deve conter apenas letras e números.',
            'licenseNumber.max' => 'O número da carta de condução não pode exceder 50 caracteres.',
            'licenseCategory.max' => 'A categoria da carta não pode exceder 50 caracteres.',
            'licenseExpiry.after' => 'A data de validade da carta deve ser posterior a hoje.',
        ]);

        Driver::create($data);

        return redirect()->route('drivers.index')
                         ->with('msg','Motorista cadastrado com sucesso.');
    }

    public function show(Driver $driver)
    {
        $driver->load('employee','vehicles');
        return view('drivers.show', compact('driver'));
    }

    public function edit(Driver $driver)
    {
        $employees = Employeee::where('employmentStatus','active')->get();
        return view('drivers.edit', compact('driver','employees'));
    }

    public function update(Request $request, Driver $driver)
    {
        $data = $request->validate([
            'employeeId'      => 'nullable|exists:employeees,id',
            'fullName'        => 'required_without:employeeId|string|max:100',
            'bi'              => "required_without:employeeId|alpha_num|size:16|unique:drivers,bi,{$driver->id}",
            'licenseNumber'   => "required|string|max:50|unique:drivers,licenseNumber,{$driver->id}",
            'licenseCategory' => 'required|string|max:50',
            'licenseExpiry'   => 'required|date|after:today',
            'status'          => 'required|in:Active,Inactive',
        ], [
            'bi.size'       => 'O bilhete de identidade deve ter exatamente 16 caracteres.',
            'bi.alpha_num'  => 'O bilhete de identidade deve conter apenas letras e números.',
            'licenseNumber.max' => 'O número da carta de condução não pode exceder 50 caracteres.',
            'licenseCategory.max' => 'A categoria da carta não pode exceder 50 caracteres.',
            'licenseExpiry.after' => 'A data de validade da carta deve ser posterior a hoje.',
        ]);

        $driver->update($data);

        return redirect()->route('drivers.edit',$driver)
                         ->with('msg','Dados do motorista atualizados com sucesso.');
    }

    public function destroy(Driver $driver)
    {
        $driver->delete();
        return redirect()->route('drivers.index')
                         ->with('msg','Motorista excluído com sucesso.');
    }
}
