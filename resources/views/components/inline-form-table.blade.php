@props([
    'title',
    'fields',           // associative array: ['name' => 'label']
    'items',
    'editItem' => null,
    'routePrefix',
    'columns',          // associative array: ['key' => 'Label']
    'relations' => [],  // optional: ['module_id' => 'module.name']
])

<div class="bg-white p-6 shadow rounded mb-6">
    <h2 class="text-xl font-semibold mb-4">
        {{ $editItem ? 'Edit ' . $title : 'Create ' . $title }}
    </h2>

    <form action="{{ $editItem ? route($routePrefix . '.update', $editItem->id) : route($routePrefix . '.store') }}" method="POST">
        @csrf
        @if($editItem) @method('PUT') @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($fields as $name => $label)
                <div>
                    <label class="block text-sm font-medium">{{ $label }}</label>
                    <input type="text" name="{{ $name }}" class="w-full border border-gray-300 rounded p-2"
                        value="{{ $editItem ? $editItem->$name : old($name) }}" required>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                {{ $editItem ? 'Update' : 'Submit' }}
            </button>
            @if($editItem)
                <a href="{{ route($routePrefix . '.index') }}" class="ml-3 text-gray-600 hover:underline">Cancel</a>
            @endif
        </div>
    </form>
</div>

{{-- Table --}}
<div class="bg-white p-6 shadow rounded">
    <h2 class="text-xl font-semibold mb-4">{{ $title }} List</h2>
    <table class="min-w-full table-auto border border-gray-300">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="border px-4 py-2">#</th>
                @foreach($columns as $key => $label)
                    <th class="border px-4 py-2">{{ $label }}</th>
                @endforeach
                <th class="border px-4 py-2">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $index => $item)
                <tr>
                    <td class="border px-4 py-2">{{ $index + 1 }}</td>
                    @foreach($columns as $key => $label)
                        <td class="border px-4 py-2">
                            @if(array_key_exists($key, $relations))
                                {{ data_get($item, $relations[$key]) }}
                            @else
                                {{ $item->$key }}
                            @endif
                        </td>
                    @endforeach
                    <td class="border px-4 py-2">
                        <a href="{{ route($routePrefix . '.index', ['edit' => $item->id]) }}" class="text-blue-600 hover:underline">Edit</a>
                        <form action="{{ route($routePrefix . '.destroy', $item->id) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Are you sure?')" class="text-red-600 hover:underline ml-2">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="{{ count($columns) + 2 }}" class="text-center py-4">No data found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
