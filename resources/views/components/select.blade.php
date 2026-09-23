@props([
    'name',
    'label' => null,
    'options' => [],
    'selected' => null,
    'placeholder' => 'Select an option',
    'required' => false
])

<div class="mb-3">
    @if($label)
        <label for="{{ $name }}" class="form-label fw-medium text-secondary small mb-1">
            {{ $label }}
            @if($required) <span class="text-danger">*</span> @endif
        </label>
    @endif
    <select 
        id="{{ $name }}" 
        name="{{ $name }}" 
        {{ $required ? 'required' : '' }} 
        {{ $attributes->merge(['class' => 'form-select form-select-md rounded-2 ' . ($errors->has($name) ? 'is-invalid' : '')]) }}
    >
        @if($placeholder)
            <option value="">{{ $placeholder }}</option>
        @endif
        @foreach($options as $val => $text)
            <option value="{{ $val }}" {{ (string)old($name, $selected) === (string)$val ? 'selected' : '' }}>
                {{ $text }}
            </option>
        @endforeach
    </select>
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
