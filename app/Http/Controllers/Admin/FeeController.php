<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentFee;
use App\Models\FeePayment;
use App\Models\FeeStructure;
use App\Models\Student;

class FeeController extends Controller
{
    public function index()
    {
        $schoolId = auth()->user()->school_id ?? 1;

        $totalCollected = FeePayment::where('school_id', $schoolId)->sum('amount');
        $totalExpected = StudentFee::where('school_id', $schoolId)->sum('amount');
        $totalPending = max(0, $totalExpected - $totalCollected);

        $recentPayments = FeePayment::with('student')->where('school_id', $schoolId)->latest()->paginate(15);
        $students = Student::where('school_id', $schoolId)->get();
        $feeStructures = FeeStructure::where('school_id', $schoolId)->get();

        return view('admin.fees.index', compact('totalCollected', 'totalExpected', 'totalPending', 'recentPayments', 'students', 'feeStructures'));
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
}
