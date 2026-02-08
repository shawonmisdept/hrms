@props(['name', 'label' => '', 'required' => false, 'accept' => ''])

<div>
    @if($label)
        <label for="{{ $name }}" class="block text-xs font-bold mb-1">
            {{ $label }} @if($required)<span class="text-red-500">*</span>@endif
        </label>
    @endif

    <input type="file" name="{{ $name }}" id="{{ $name }}"
        {{ $required ? 'required' : '' }}
        {{ $accept ? "accept=$accept" : '' }}
        {{ $attributes->merge(['class' => 'w-full border border-gray-300 rounded px-3 py-2 text-sm file:border-0 file:bg-gray-100 file:mr-4 file:px-4 file:py-2 file:rounded']) }}>

    @error($name)
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>
