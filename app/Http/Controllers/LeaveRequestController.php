<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use App\Models\Employeee;
use App\Models\Department;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class LeaveRequestController extends Controller
{
    public function index()
    {
        $data = LeaveRequest::with(['employee', 'department', 'leaveType'])
                              ->orderByDesc('id')
                              ->get();
        return view('leaveRequest.index', compact('data'));
    }

    public function create()
    {
        $departments = Department::all();
        $leaveTypes  = LeaveType::all();
        return view('leaveRequest.create', compact('departments', 'leaveTypes'));
    }

    /**
     * Busca um funcionário pelo ID para preencher o formulário.
     */
    public function searchEmployee(Request $request)
    {
        $request->validate([
            'employeeId' => 'required|integer',
        ]);

        $employee = Employeee::find($request->employeeId);

        if (!$employee) {
            return redirect()->back()
                ->withErrors(['employeeId' => 'Funcionário não encontrado!'])
                ->withInput();
        }

        $currentDepartment = $employee->department;
        $departments = Department::all();
        $leaveTypes  = LeaveType::all();

        return view('leaveRequest.create', [
            'departments'       => $departments,
            'leaveTypes'        => $leaveTypes,
            'employee'          => $employee,
            'currentDepartment' => $currentDepartment,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'employeeId'   => 'required|integer|exists:employeees,id',
            'departmentId' => 'required|integer|exists:departments,id',
            'leaveTypeId'  => 'required|integer|exists:leave_types,id',
            'reason'       => 'nullable|string',
        ]);

        LeaveRequest::create([
            'employeeId'   => $request->employeeId,
            'departmentId' => $request->departmentId,
            'leaveTypeId'  => $request->leaveTypeId,
            'reason'       => $request->reason,
        ]);

        return redirect()->route('leaveRequest.index')
                         ->with('msg', 'Pedido de licença registrado com sucesso!');
    }

    public function pdfAll()
    {
       
        $allLeaveRequests = LeaveRequest::with(['employee', 'department', 'leaveType'])->get();

   
        $pdf = PDF::loadView('leaveRequest.leaveRequest_pdf', compact('allLeaveRequests'))
                ->setPaper('a3', 'landscape');

        return $pdf->stream('RelatorioPedidosLicenca.pdf');
    }


    public function destroy($id)
    {
        LeaveRequest::destroy($id);
        return redirect()->route('leaveRequest.index');
    }
}
