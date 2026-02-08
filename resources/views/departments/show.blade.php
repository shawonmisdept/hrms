@extends('layouts.dashboard')

@section('content')
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-6">Department Details</h1>

        {{-- Departments Table --}}
        <table class="min-w-full border border-gray-300 text-center">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border border-gray-300 px-4 py-3 text-xs font-bold uppercase">#</th>
                    <th class="border border-gray-300 px-4 py-3 text-xs font-bold uppercase">Department Name</th>
                    <th class="border border-gray-300 px-4 py-3 text-xs font-bold uppercase">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($departments as $department)
                    <tr class="hover:bg-gray-50 text-xs">
                        <td class="border border-gray-300 px-4 py-3">{{ $loop->iteration }}</td>
                        <td class="border border-gray-300 px-4 py-3">{{ $department->name }}</td>
                        <td class="border border-gray-300 px-4 py-3">
                            {{-- Show button to open modal --}}
                            <button onclick="openModal('{{ $department->id }}')"
                                    class="bg-blue-500 hover:bg-blue-600 text-white p-1 rounded">
                                Show
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $departments->links() }}
        </div>
    </div>

    {{-- Modal --}}
    <div id="departmentModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold">Department Details</h2>
                <button onclick="closeModal()" class="text-gray-600 font-bold">X</button>
            </div>
            <div id="modalContent" class="mt-4">
                <!-- Department details will be injected here dynamically -->
            </div>
        </div>
    </div>

    {{-- Modal Scripts --}}
    <script>
        function openModal(departmentId) {
            // Fetch department details via AJAX or you can pass directly from controller
            fetch(`/departments/${departmentId}`)
                .then(response => response.json())
                .then(data => {
                    const modalContent = document.getElementById('modalContent');
                    modalContent.innerHTML = `
                        <p><strong>Department Name:</strong> ${data.name}</p>
                        <p><strong>Description:</strong> ${data.description ?? 'N/A'}</p>
                        <p><strong>Department Head:</strong> ${data.department_head_id ?? 'N/A'}</p>
                        <p><strong>Email:</strong> ${data.email ?? 'N/A'}</p>
                        <p><strong>Employee Count:</strong> ${data.employees_count}</p>
                        <p><strong>Status:</strong> ${data.status ? 'Active' : 'Inactive'}</p>
                        <p><strong>Created At:</strong> ${data.created_at}</p>
                        <p><strong>Updated At:</strong> ${data.updated_at}</p>
                    `;
                    document.getElementById('departmentModal').classList.remove('hidden');
                })
                .catch(error => console.log(error));
        }

        function closeModal() {
            document.getElementById('departmentModal').classList.add('hidden');
        }
    </script>
@endsection
