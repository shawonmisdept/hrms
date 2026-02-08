@props(['name', 'label' => '', 'required' => false])

<div>
    @if($label)
        <label for="{{ $name }}" class="block text-xs font-bold mb-1">
            {{ $label }} @if($required)<span class="text-red-500">*</span>@endif
        </label>
    @endif

    <input type="password" name="{{ $name }}" id="{{ $name }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => 'w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-green-200 focus:border-green-500']) }}>

    @error($name)
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>
