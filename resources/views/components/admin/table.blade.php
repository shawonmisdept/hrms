<x-app-layout>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-6">Departments</h1>

    {{-- Table Card --}}
    <div class="overflow-x-auto bg-white rounded-lg shadow-md p-4">

      {{-- ➕ Add New Button (Top Right) --}}
      <div class="flex justify-end mb-2">
        <a href="{{ route('departments.create') }}"
           class="inline-block bg-green-500 hover:bg-green-600 text-white text-xs font-semibold px-4 py-1.5 rounded">
          Add New
        </a>
      </div>

      {{-- Departments Table --}}
      <table class="min-w-full border border-gray-300 text-center">
        <thead class="bg-gray-100">
          <tr>
            <th class="border border-gray-300 px-4 py-3 text-xs font-bold uppercase">#</th>
            <th class="border border-gray-300 px-4 py-3 text-xs font-bold uppercase">Department Name</th>
            <th class="border border-gray-300 px-4 py-3 text-xs font-bold uppercase">Description</th>
            <th class="border border-gray-300 px-4 py-3 text-xs font-bold uppercase">Employee Count</th>
            <th class="border border-gray-300 px-4 py-3 text-xs font-bold uppercase">Status</th>
            <th class="border border-gray-300 px-4 py-3 text-xs font-bold uppercase">Created At</th>
            <th class="border border-gray-300 px-4 py-3 text-xs font-bold uppercase">Updated At</th>
            <th class="border border-gray-300 px-2 py-3 text-xs font-bold uppercase w-48">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($departments as $department)
            <tr class="hover:bg-gray-50 text-xs">
              <td class="border border-gray-300 px-4 py-3">{{ $loop->iteration }}</td>
              <td class="border border-gray-300 px-4 py-3">{{ $department->name }}</td>
              <td class="border border-gray-300 px-4 py-3">{{ $department->description ?? '-' }}</td>
              <td class="border border-gray-300 px-4 py-3">{{ $department->employees_count ?? 0 }}</td>
              <td class="border border-gray-300 px-4 py-3">
                @if($department->status)
                  <span class="text-green-600 font-bold">Active</span>
                @else
                  <span class="text-red-600 font-bold">Inactive</span>
                @endif
              </td>
              <td class="border border-gray-300 px-4 py-3">{{ $department->created_at->format('Y-m-d') }}</td>
              <td class="border border-gray-300 px-4 py-3">{{ $department->updated_at->format('Y-m-d') }}</td>
              <td class="border border-gray-300 px-2 py-2">
                <div class="flex flex-row flex-wrap justify-center gap-1">
                  
                  {{-- ✏️ Edit --}}
                  <a href="{{ route('departments.edit', $department->id) }}"
                     class="bg-blue-500 hover:bg-blue-600 text-white p-1 rounded">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15.232 5.232l3.536 3.536M9 11l6-6M5 19h14M5 19l4-4 4 4 4-4 4 4"/>
                    </svg>
                  </a>

                  {{-- 🔄 Activate/Deactivate --}}
                  <form action="{{ route('departments.toggleStatus', $department->id) }}" method="POST" onsubmit="return confirm('Are you sure to change status?');" style="display:inline;">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                            class="bg-yellow-400 hover:bg-yellow-500 text-white p-1 rounded">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v16h16V4H4z"/>
                      </svg>
                    </button>
                  </form>

                  {{-- 🗑️ Delete --}}
                  <form action="{{ route('departments.destroy', $department->id) }}" method="POST" onsubmit="return confirm('Are you sure to delete?');" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="bg-red-500 hover:bg-red-600 text-white p-1 rounded">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>
                      </svg>
                    </button>
                  </form>

                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>

    </div>
  </div>
</x-app-layout>
