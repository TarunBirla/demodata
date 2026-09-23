<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentFee;
use App\Models\FeePayment;
use App\Models\FeeStructure;
use App\Models\Student;

use App\Models\SchoolClass;
use App\Models\AcademicYear;

class FeeController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $schoolId = $user->school_id ?? 1;

        $paymentsQuery = FeePayment::with(['student', 'school']);
        $expectedQuery = StudentFee::query();

        if ($user->role_name !== 'super_admin') {
            $paymentsQuery->where('school_id', $schoolId);
            $expectedQuery->where('school_id', $schoolId);
        }

        if ($user->role_name === 'student') {
            $student = $user->student;
            $studentIds = $student ? [$student->id] : [];
            $paymentsQuery->whereIn('student_id', $studentIds);
            $expectedQuery->whereIn('student_id', $studentIds);
        } elseif ($user->role_name === 'parent') {
            $parentProfile = $user->parentProfile;
            $studentIds = $parentProfile ? $parentProfile->students()->pluck('students.id')->toArray() : [];
            $paymentsQuery->whereIn('student_id', $studentIds);
            $expectedQuery->whereIn('student_id', $studentIds);
        }

        $totalCollected = (clone $paymentsQuery)->sum('amount');
        $totalExpected = (clone $expectedQuery)->sum('amount');
        $totalPending = max(0, $totalExpected - $totalCollected);

        $recentPayments = $paymentsQuery->latest()->paginate(15);
        $students = $user->role_name === 'super_admin' ? Student::all() : Student::where('school_id', $schoolId)->get();
        $classes = $user->role_name === 'super_admin' ? SchoolClass::all() : SchoolClass::where('school_id', $schoolId)->get();
        $feeStructuresQuery = FeeStructure::with(['schoolClass', 'school']);
        if ($user->role_name !== 'super_admin') {
            $feeStructuresQuery->where('school_id', $schoolId);
        }
        $feeStructures = $feeStructuresQuery->get();

        return view('admin.fees.index', compact('totalCollected', 'totalExpected', 'totalPending', 'recentPayments', 'students', 'classes', 'feeStructures'));
    }

    public function collect(Request $request)
    {
        $schoolId = auth()->user()->school_id ?? 1;

        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'amount' => 'required|numeric|min:1',
            'payment_mode' => 'required|string',
        ]);

        $studentFee = StudentFee::where('school_id', $schoolId)->where('student_id', $validated['student_id'])->first();

        if (!$studentFee) {
            $studentFee = StudentFee::create([
                'school_id' => $schoolId,
                'academic_year_id' => 1,
                'student_id' => $validated['student_id'],
                'fee_structure_id' => 1,
                'amount' => 15000.00,
                'paid_amount' => 0.00,
                'status' => 'unpaid',
                'due_date' => date('Y-m-d'),
            ]);
        }

        $receiptNo = 'REC-2026-' . rand(10000, 99999);

        FeePayment::create([
            'school_id' => $schoolId,
            'student_fee_id' => $studentFee->id,
            'student_id' => $validated['student_id'],
            'receipt_number' => $receiptNo,
            'amount' => $validated['amount'],
            'payment_date' => date('Y-m-d'),
            'payment_mode' => $validated['payment_mode'],
            'created_by' => auth()->id(),
        ]);

        $newPaid = $studentFee->paid_amount + $validated['amount'];
        $status = ($newPaid >= $studentFee->amount) ? 'paid' : 'partial';

        $studentFee->update([
            'paid_amount' => $newPaid,
            'status' => $status,
        ]);

        return back()->with('success', 'Fee payment of ₹' . number_format($validated['amount'], 2) . ' collected successfully. Receipt: ' . $receiptNo);
    }

    public function storeStructure(Request $request)
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $acadYear = AcademicYear::where('school_id', $schoolId)->first();

        $validated = $request->validate([
            'class_id' => 'required|exists:school_classes,id',
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'frequency' => 'required|string',
            'due_date' => 'nullable|date',
        ]);

        FeeStructure::create(array_merge($validated, [
            'school_id' => $schoolId,
            'academic_year_id' => $acadYear->id ?? 1,
        ]));

        return back()->with('success', 'Fee structure created successfully!');
    }

    public function updateStructure(Request $request, $id)
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $structure = FeeStructure::where('school_id', $schoolId)->findOrFail($id);

        $validated = $request->validate([
            'class_id' => 'required|exists:school_classes,id',
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'frequency' => 'required|string',
            'due_date' => 'nullable|date',
        ]);

        $structure->update($validated);

        return back()->with('success', 'Fee structure updated successfully!');
    }

    public function destroyStructure($id)
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $structure = FeeStructure::where('school_id', $schoolId)->findOrFail($id);
        $structure->delete();

        return back()->with('success', 'Fee structure deleted successfully.');
    }

    public function destroyPayment($id)
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $payment = FeePayment::where('school_id', $schoolId)->findOrFail($id);
        $payment->delete();

        return back()->with('success', 'Fee receipt deleted successfully.');
    }
}
