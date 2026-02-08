<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label for="name" class="block font-semibold mb-1">Unit Name</label>
        <input type="text" name="name" id="name" value="{{ old('name', $unit->name ?? '') }}" required class="w-full border border-gray-300 rounded px-3 py-1">
    </div>

    <div>
        <label for="address" class="block font-semibold mb-1">Address</label>
        <input type="text" name="address" id="address" value="{{ old('address', $unit->address ?? '') }}" class="w-full border border-gray-300 rounded px-3 py-1">
    </div>

    <div>
        <label for="email" class="block font-semibold mb-1">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email', $unit->email ?? '') }}" class="w-full border border-gray-300 rounded px-3 py-1">
    </div>

    <div>
        <label for="phone" class="block font-semibold mb-1">Phone</label>
        <input type="text" name="phone" id="phone" value="{{ old('phone', $unit->phone ?? '') }}" class="w-full border border-gray-300 rounded px-3 py-1">
    </div>

    <div>
        <label for="status" class="block font-semibold mb-1">Status <span class="text-red-500">*</span></label>
        <select name="status" id="status" required class="w-full border border-gray-300 rounded px-3 py-2">
            <option value="active" {{ old('status', $unit->status ?? '') == 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ old('status', $unit->status ?? '') == 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
    </div>
</div>
