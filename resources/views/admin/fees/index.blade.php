@extends('layouts.app')

@section('title', 'Fee Collection & Management')

@section('content')

<x-breadcrumb :items="['Fees' => route('admin.fees.index')]" />

<x-page-header title="Fee Collection & Accounting" subtitle="Collect tuition fees, issue instant digital receipts, track pending dues, and financial summaries.">
    <x-slot:actions>
        <x-button variant="success" icon="bi-cash" data-bs-toggle="modal" data-bs-target="#collectFeeModal">Collect Payment</x-button>
    </x-slot:actions>
</x-page-header>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <x-stat-card title="Total Fee Collected" value="₹ {{ number_format($totalCollected, 2) }}" icon="bi-cash-coin" bg="bg-success" />
    </div>
    <div class="col-md-4">
        <x-stat-card title="Total Expected Revenue" value="₹ {{ number_format($totalExpected, 2) }}" icon="bi-wallet2" bg="bg-primary" />
    </div>
    <div class="col-md-4">
        <x-stat-card title="Pending Dues" value="₹ {{ number_format($totalPending, 2) }}" icon="bi-exclamation-octagon" bg="bg-danger" />
    </div>
</div>

<x-card title="Recent Fee Receipts & Transactions" headerIcon="bi-receipt">
    <x-table :headers="['Receipt #', 'Student Name', 'Amount Paid', 'Date', 'Mode', 'Actions']">
        @forelse($recentPayments as $p)
            <tr>
                <td class="fw-semibold text-primary">{{ $p->receipt_number }}</td>
                <td class="fw-bold text-dark">{{ $p->student->full_name ?? 'Student' }}</td>
                <td class="fw-bold text-success">₹ {{ number_format($p->amount, 2) }}</td>
                <td class="small text-muted">{{ $p->payment_date->format('M d, Y') }}</td>
                <td><x-badge variant="info">{{ strtoupper($p->payment_mode) }}</x-badge></td>
                <td>
                    <button class="btn btn-sm btn-outline-secondary" onclick="alert('Receipt Print Window Opening...')"><i class="bi bi-printer"></i> Print</button>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="text-center text-muted py-3">No payments collected yet.</td></tr>
        @endforelse
    </x-table>
</x-card>

<!-- COLLECT FEE MODAL -->
<x-modal id="collectFeeModal" title="Collect Fee Payment">
    <form action="{{ route('admin.fees.collect') }}" method="POST">
        @csrf
        <x-select name="student_id" label="Select Student" :options="$students->pluck('full_name', 'id')->toArray()" required />
        <x-input name="amount" label="Amount to Collect (₹)" type="number" step="0.01" value="15000.00" required />
        <x-select name="payment_mode" label="Payment Method" :options="['cash' => 'Cash', 'online' => 'Online Bank / UPI', 'cheque' => 'Cheque / Draft']" required />
        
        <div class="text-end mt-3">
            <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
            <x-button type="submit" variant="success" icon="bi-check-lg">Confirm & Generate Receipt</x-button>
        </div>
    </form>
</x-modal>

@endsection
