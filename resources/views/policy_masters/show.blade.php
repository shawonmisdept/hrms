@extends('layouts.dashboard')

@section('content')
<div class="max-w-3xl mx-auto mt-8 bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-6">Policy Master Details</h2>

    <div class="mb-4">
        <strong>Name:</strong> {{ $policyMaster->name }}
    </div>

    <div class="mb-4">
        <strong>Description:</strong> {{ $policyMaster->description }}
    </div>

    <div class="mb-4">
        <strong>Effective Date:</strong> {{ $policyMaster->effective_date }}
    </div>

    <div class="mb-4">
        <strong>Avail From:</strong> {{ ucfirst(str_replace('_', ' ', $policyMaster->avail_from)) }}
    </div>

    <div class="mb-4">
        <strong>Status:</strong> 
        @if($policyMaster->status == 'active')
            <span class="text-green-600 font-semibold">Active</span>
        @elseif($policyMaster->status == 'inactive')
            <span class="text-yellow-600 font-semibold">Inactive</span>
        @else
            <span class="text-red-600 font-semibold">Blocked</span>
        @endif
    </div>

    <div class="mb-4">
        <strong>Created At:</strong> {{ $policyMaster->created_at->format('d M Y h:i A') }}
    </div>

    <div class="mb-4">
        <strong>Updated At:</strong> {{ $policyMaster->updated_at->format('d M Y h:i A') }}
    </div>

    <div class="mb-6">
        <strong>Policy Details:</strong>
        <ul>
            @foreach($policyDetails as $detail)
                <li>
                    <a href="#" data-toggle="modal" data-target="#policyDetailModal{{ $detail->id }}">
                        {{ $detail->salaryHead->name }} ({{ $detail->type }}) - {{ $detail->amount }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="flex justify-end">
        <a href="{{ route('policy-masters.index') }}" class="bg-gray-300 px-4 py-2 rounded">Back</a>
    </div>
</div>

<!-- Modal Template -->
@foreach($policyDetails as $detail)
<div class="modal fade" id="policyDetailModal{{ $detail->id }}" tabindex="-1" role="dialog" aria-labelledby="policyDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="policyDetailModalLabel">Policy Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <strong>Salary Head:</strong> {{ $detail->salaryHead->name }}<br>
                <strong>Type:</strong> {{ ucfirst($detail->type) }}<br>
                <strong>Amount:</strong> {{ $detail->amount }}<br>
                <strong>Min Service Length:</strong> {{ $detail->min_service_length }} days<br>
                <strong>Max Service Length:</strong> {{ $detail->max_service_length }} days<br>
                <strong>Status:</strong> {{ ucfirst($detail->status) }}<br>
                <strong>Created At:</strong> {{ $detail->created_at->format('d M Y h:i A') }}<br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
