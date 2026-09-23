@extends('layouts.app')

@section('title', 'Fee Collection & Management')

@section('content')

<x-breadcrumb :items="['Fees' => route('admin.fees.index')]" />

<x-page-header title="Fee Collection & Accounting" subtitle="Collect tuition fees, issue instant digital receipts, track pending dues, and financial summaries.">
    <x-slot:actions>
        <button class="btn btn-navy me-2" data-bs-toggle="modal" data-bs-target="#addFeeStructureModal"><i class="bi bi-plus-lg me-1"></i> Add Fee Structure</button>
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

<!-- FEE STRUCTURES LIST -->
<x-card title="Active Class Fee Structures" headerIcon="bi-list-check" class="mb-4">
    <x-table :headers="['Class', 'Fee Name', 'Amount (₹)', 'Frequency', 'Actions']">
        @forelse($feeStructures as $fs)
            <tr>
                <td class="fw-bold text-dark">{{ $fs->schoolClass->name ?? 'All Classes' }}</td>
                <td class="fw-semibold text-primary">{{ $fs->name }}</td>
                <td class="fw-bold text-success">₹ {{ number_format($fs->amount, 2) }}</td>
                <td><x-badge variant="info">{{ strtoupper($fs->frequency) }}</x-badge></td>
                <td>
                    <div class="d-flex gap-1">
                        <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editFeeStructureModal{{ $fs->id }}"><i class="bi bi-pencil"></i></button>
                        <form action="{{ route('admin.fees.structure.destroy', $fs->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this fee structure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </div>

                    <!-- EDIT FEE STRUCTURE MODAL -->
                    <x-modal id="editFeeStructureModal{{ $fs->id }}" title="Edit Fee Structure — {{ $fs->name }}">
                        <form action="{{ route('admin.fees.structure.update', $fs->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <x-select name="class_id" label="Class Grade Choice" :options="$classes->pluck('name', 'id')->toArray()" :value="$fs->class_id" required />
                                </div>
                                <div class="col-md-6">
                                    <x-input name="name" label="Fee Component Title" value="{{ $fs->name }}" required />
                                </div>
                                <div class="col-md-6">
                                    <x-input name="amount" label="Amount (₹)" type="number" step="0.01" value="{{ $fs->amount }}" required />
                                </div>
                                <div class="col-md-6">
                                    <x-select name="frequency" label="Frequency Choice" :options="['monthly' => 'Monthly', 'term' => 'Per Term (Quarterly)', 'yearly' => 'Yearly / Annual', 'one_time' => 'One Time']" :value="$fs->frequency" required />
                                </div>
                            </div>
                            <div class="text-end mt-3">
                                <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-navy">Save Structure</button>
                            </div>
                        </form>
                    </x-modal>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" class="text-center text-muted py-3">No fee structures configured yet. Click 'Add Fee Structure' above.</td></tr>
        @endforelse
    </x-table>
</x-card>

<x-card title="Recent Fee Receipts & Transactions" headerIcon="bi-receipt">
    <x-table :headers="['Receipt #', 'Student Name', 'Amount Paid', 'Date', 'Mode', 'Actions']">
        @forelse($recentPayments as $p)
            <tr>
                <td class="fw-semibold text-primary">{{ $p->receipt_number }}</td>
                <td class="fw-bold text-dark">{{ $p->student->full_name ?? 'Student' }}</td>
                <td class="fw-bold text-success">₹ {{ number_format($p->amount, 2) }}</td>
                <td class="small text-muted">{{ \Carbon\Carbon::parse($p->payment_date)->format('M d, Y') }}</td>
                <td><x-badge variant="info">{{ strtoupper($p->payment_mode) }}</x-badge></td>
                <td>
                    <div class="d-flex gap-1">
                        <button class="btn btn-sm btn-outline-secondary" onclick="alert('Receipt Print Window Opening...')"><i class="bi bi-printer"></i> Print</button>
                        <form action="{{ route('admin.fees.payment.destroy', $p->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete fee receipt {{ $p->receipt_number }}?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </div>
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
        <x-select name="student_id" label="Select Student Choice" :options="$students->pluck('full_name', 'id')->toArray()" required />
        <x-input name="amount" label="Amount to Collect (₹)" type="number" step="0.01" value="15000.00" required />
        <x-select name="payment_mode" label="Payment Method Choice" :options="['cash' => 'Cash', 'online' => 'Online Bank / UPI', 'cheque' => 'Cheque / Draft']" required />
        
        <div class="text-end mt-3">
            <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
            <x-button type="submit" variant="success" icon="bi-check-lg">Confirm & Generate Receipt</x-button>
        </div>
    </form>
</x-modal>

<!-- ADD FEE STRUCTURE MODAL -->
<x-modal id="addFeeStructureModal" title="Add Class Fee Structure">
    <form action="{{ route('admin.fees.structure.store') }}" method="POST">
        @csrf
        <div class="row g-2">
            <div class="col-md-6">
                <x-select name="class_id" label="Class Grade Choice" :options="$classes->pluck('name', 'id')->toArray()" required />
            </div>
            <div class="col-md-6">
                <x-input name="name" label="Fee Title" placeholder="e.g. Annual Tuition Fee" required />
            </div>
            <div class="col-md-6">
                <x-input name="amount" label="Amount (₹)" type="number" step="0.01" placeholder="15000.00" required />
            </div>
            <div class="col-md-6">
                <x-select name="frequency" label="Frequency Choice" :options="['monthly' => 'Monthly', 'term' => 'Per Term (Quarterly)', 'yearly' => 'Yearly / Annual', 'one_time' => 'One Time']" required />
            </div>
        </div>
        <div class="text-end mt-3">
            <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-navy"><i class="bi bi-check-lg me-1"></i> Save Fee Structure</button>
        </div>
    </form>
</x-modal>

@endsection
