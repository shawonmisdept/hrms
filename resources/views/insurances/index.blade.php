@extends('layouts.dashboard')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold">Insurance List</h2>
        <a href="{{ route('insurances.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Add New</a>
    </div>

            <table class="min-w-full table-auto border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 px-4 py-2">#</th> 
                        <th class="border border-gray-300 px-4 py-2">Name</th>
                        <th class="border border-gray-300 px-4 py-2">Provider</th>
                        <th class="border border-gray-300 px-4 py-2">Premium</th>
                        <th class="border border-gray-300 px-4 py-2">Start Date</th>
                        <th class="border border-gray-300 px-4 py-2">End Date</th>
                        <th class="border border-gray-300 px-4 py-2">Status</th>
                        <th class="border border-gray-300 px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($insurances as $insurance)
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $insurance->name }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $insurance->provider_name }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ number_format($insurance->premium, 2) }}</td>

                        <td class="border border-gray-300 px-4 py-2">
                            {{ $insurance->start_date ? \Carbon\Carbon::parse($insurance->start_date)->format('d M, Y') : '-' }}
                        </td>

                        <td class="border border-gray-300 px-4 py-2">
                            {{ $insurance->end_date ? \Carbon\Carbon::parse($insurance->end_date)->format('d M, Y') : '-' }}
                        </td>

                        <td class="border border-gray-300 px-4 py-2">
                            @if($insurance->status)
                                <span class="text-green-600 font-semibold">Active</span>
                            @else
                                <span class="text-red-600 font-semibold">Inactive</span>
                            @endif
                        </td>

                        <td class="border border-gray-300 px-4 py-2 space-x-2">
                            <a href="{{ route('insurances.show', $insurance->id) }}" class="text-blue-600 hover:underline">Show</a>
                            <a href="{{ route('insurances.edit', $insurance->id) }}" class="text-yellow-600 hover:underline">Edit</a>
                            <form action="{{ route('insurances.destroy', $insurance->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>


        <div class="mt-4">
            {{ $insurances->links() }}
        </div>
    </div>
</div>
@endsection
