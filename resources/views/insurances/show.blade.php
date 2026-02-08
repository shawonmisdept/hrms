@extends('layouts.dashboard')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white rounded shadow mt-6">
    <h2 class="text-2xl font-semibold mb-6">Insurance Details</h2>

    <div class="space-y-4">
        <div>
            <label class="font-semibold">Name:</label>
            <p class="mt-1">{{ $insurance->name }}</p>
        </div>

        <div>
            <label class="font-semibold">Description:</label>
            <p class="mt-1">{{ $insurance->description ?? '-' }}</p>
        </div>

        <div>
            <label class="font-semibold">Coverage Amount:</label>
            <p class="mt-1">{{ $insurance->coverage_amount ? number_format($insurance->coverage_amount, 2) : '-' }}</p>
        </div>

        <div>
            <label class="font-semibold">Premium:</label>
            <p class="mt-1">{{ $insurance->premium ? number_format($insurance->premium, 2) : '-' }}</p>
        </div>

        <div>
            <label class="font-semibold">Provider Name:</label>
            <p class="mt-1">{{ $insurance->provider_name ?? '-' }}</p>
        </div>

        <div>
            <label class="font-semibold">Start Date:</label>
            <p class="mt-1">{{ $insurance->start_date ? $insurance->start_date->format('d M, Y') : '-' }}</p>
        </div>

        <div>
            <label class="font-semibold">End Date:</label>
            <p class="mt-1">{{ $insurance->end_date ? $insurance->end_date->format('d M, Y') : '-' }}</p>
        </div>

        <div>
            <label class="font-semibold">Status:</label>
            @if ($insurance->status)
                <span class="text-green-600 font-semibold">Active</span>
            @else
                <span class="text-red-600 font-semibold">Inactive</span>
            @endif
        </div>
    </div>

    <div class="mt-8 flex space-x-4">
        <a href="{{ route('insurances.index') }}" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Back to List</a>

        <a href="{{ route('insurances.edit', $insurance->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Edit</a>
    </div>
</div>
@endsection
