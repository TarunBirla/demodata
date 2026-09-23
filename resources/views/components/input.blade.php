@props([
    'name',
    'label' => null,
    'type' => 'text',
    'value' => null,
    'placeholder' => '',
    'required' => false,
    'error' => null
])

<div class="mb-3">
    @if($label)
        <label for="{{ $name }}" class="form-label fw-medium text-secondary small mb-1">
            {{ $label }}
            @if($required) <span class="text-danger">*</span> @endif
        </label>
    @endif
    <input 
        type="{{ $type }}" 
        id="{{ $name }}" 
        name="{{ $name }}" 
        value="{{ old($name, $value) }}" 
        placeholder="{{ $placeholder }}" 
        {{ $required ? 'required' : '' }} 
        {{ $attributes->merge(['class' => 'form-control form-control-md rounded-2 ' . ($errors->has($name) || $error ? 'is-invalid' : '')]) }}
    >
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
