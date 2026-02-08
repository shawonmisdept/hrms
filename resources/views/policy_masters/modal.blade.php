{{-- Create Modal --}}
<div id="createModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden z-50">
    <div class="bg-white p-6 rounded w-96">
        <h2 class="text-lg font-bold mb-4">Create Salary Grade</h2>
        <form method="POST" action="{{ route('salary-grades.store') }}">
            @csrf
            <input type="text" name="grade_name" placeholder="Grade Name" class="w-full border mb-2 p-2" required>
            <textarea name="description" placeholder="Description" class="w-full border mb-2 p-2"></textarea>
            <select name="status" class="w-full border mb-4 p-2">
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
            <div class="flex justify-end">
                <button type="button" onclick="closeCreateModal()" class="mr-2 px-3 py-1 border">Cancel</button>
                <button type="submit" class="bg-blue-600 text-white px-3 py-1">Save</button>
            </div>
        </form>
    </div>
</div>

{{-- Edit Modal --}}
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden z-50">
    <div class="bg-white p-6 rounded w-96">
        <h2 class="text-lg font-bold mb-4">Edit Salary Grade</h2>
        <form method="POST" id="editForm">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="edit_id">
            <input type="text" name="grade_name" id="edit_grade_name" class="w-full border mb-2 p-2" required>
            <textarea name="description" id="edit_description" class="w-full border mb-2 p-2"></textarea>
            <select name="status" id="edit_status" class="w-full border mb-4 p-2">
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
            <div class="flex justify-end">
                <button type="button" onclick="closeEditModal()" class="mr-2 px-3 py-1 border">Cancel</button>
                <button type="submit" class="bg-green-600 text-white px-3 py-1">Update</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('editForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const id = document.getElementById('edit_id').value;
        this.action = '/salary-grades/' + id;
        this.submit();
    });
</script>
