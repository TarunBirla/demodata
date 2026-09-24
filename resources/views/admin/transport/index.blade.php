@extends('layouts.app')

@section('title', 'Transport Management')

@section('content')
<x-page-header title="Transport Management" subtitle="Manage school vehicles, routes, and transport fee schedules">
    @if(in_array(auth()->user()->role_name, ['super_admin', 'school_admin', 'transport_manager']))
    <button type="button" class="btn btn-navy rounded-pill px-4 me-2" data-bs-toggle="modal" data-bs-target="#addVehicleModal">
        <i class="bi bi-plus-lg me-1"></i> Add Vehicle
    </button>
    <button type="button" class="btn btn-outline-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#addRouteModal">
        <i class="bi bi-plus-lg me-1"></i> Add Route
    </button>
    @endif
</x-page-header>

<div class="row g-4 mb-4">
    <div class="col-md-6">
        <x-stat-card title="Total Fleet Vehicles" value="{{ $vehicles->count() }}" icon="bi-bus-front" bgClass="bg-soft-primary" />
    </div>
    <div class="col-md-6">
        <x-stat-card title="Active Transport Routes" value="{{ $routes->count() }}" icon="bi-geo-alt" bgClass="bg-soft-success" />
    </div>
</div>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="fw-bold mb-0 text-navy"><i class="bi bi-bus-front me-2"></i> School Vehicles</h5>
            </div>
            <div class="card-body p-0">
                @if($vehicles->isEmpty())
                    <x-empty-state title="No Vehicles" message="No fleet vehicles registered." />
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Reg Number</th>
                                    <th>Type</th>
                                    <th>Capacity</th>
                                    <th>Driver Name</th>
                                    <th>Phone</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($vehicles as $v)
                                <tr>
                                    <td class="ps-4 fw-bold text-dark">{{ $v->registration_number }}</td>
                                    <td><span class="badge bg-soft-info text-info">{{ $v->vehicle_type }}</span></td>
                                    <td>{{ $v->capacity }} seats</td>
                                    <td>{{ $v->driver_name ?: 'N/A' }}</td>
                                    <td>{{ $v->driver_phone ?: 'N/A' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="fw-bold mb-0 text-navy"><i class="bi bi-map me-2"></i> Transport Routes</h5>
            </div>
            <div class="card-body p-0">
                @if($routes->isEmpty())
                    <x-empty-state title="No Routes" message="No transport routes configured." />
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Route Name</th>
                                    <th>Assigned Vehicle</th>
                                    <th>Monthly Fee</th>
                                    <th>Stops</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($routes as $r)
                                <tr>
                                    <td class="ps-4 fw-bold text-dark">{{ $r->route_name }}</td>
                                    <td>{{ $r->vehicle->registration_number ?? 'Unassigned' }}</td>
                                    <td><strong class="text-success">₹{{ number_format($r->fee, 2) }}</strong></td>
                                    <td class="small text-muted">{{ $r->stops ?: 'Main Route' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Vehicle Modal -->
<div class="modal fade" id="addVehicleModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('admin.transport.vehicles.store') }}" method="POST">
            @csrf
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-0 bg-navy text-white">
                    <h5 class="modal-title fw-bold">Register New Vehicle</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Registration Number *</label>
                        <input type="text" name="registration_number" class="form-control" placeholder="e.g. MP-10-AB-1234" required>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Vehicle Type *</label>
                            <input type="text" name="vehicle_type" class="form-control" value="Bus" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Capacity (Seats) *</label>
                            <input type="number" name="capacity" class="form-control" value="40" min="1" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Driver Name</label>
                        <input type="text" name="driver_name" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Driver Phone</label>
                        <input type="text" name="driver_phone" class="form-control">
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-navy rounded-pill px-4">Save Vehicle</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Route Modal -->
<div class="modal fade" id="addRouteModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('admin.transport.routes.store') }}" method="POST">
            @csrf
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-0 bg-navy text-white">
                    <h5 class="modal-title fw-bold">Add Transport Route</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Route Name *</label>
                        <input type="text" name="route_name" class="form-control" placeholder="e.g. Kedwa Road Express" required>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Vehicle</label>
                            <select name="vehicle_id" class="form-select">
                                <option value="">Select Vehicle</option>
                                @foreach($vehicles as $v)
                                <option value="{{ $v->id }}">{{ $v->registration_number }} ({{ $v->vehicle_type }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Monthly Transport Fee (₹) *</label>
                            <input type="number" step="0.01" name="fee" class="form-control" value="1200.00" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Stops / Coverage Area</label>
                        <textarea name="stops" class="form-control" rows="2" placeholder="e.g. Stop A -> Stop B -> School"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-navy rounded-pill px-4">Save Route</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
