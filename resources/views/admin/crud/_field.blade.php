@php
    $name = $field['name'];
    $type = $field['type'] ?? 'text';
    $label = $field['label'] ?? str($name)->headline();
    $value = old($name, $item->{$name} ?? '');

    if (($type === 'date' || $type === 'datetime-local') && is_object($value) && method_exists($value, 'format')) {
        $value = $type === 'date' ? $value->format('Y-m-d') : $value->format('Y-m-d\TH:i');
    }
@endphp

<div class="{{ $field['col'] ?? 'col-12' }}">
    @if($type === 'checkbox')
        <div class="form-check mt-4">
            <input class="form-check-input @error($name) is-invalid @enderror" type="checkbox" name="{{ $name }}" value="1" id="{{ $name }}" @checked(old($name, $item->{$name} ?? true))>
            <label class="form-check-label" for="{{ $name }}">{{ $label }}</label>
            @error($name)<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
        </div>
    @else
        <label for="{{ $name }}" class="form-label">{{ $label }}</label>

        @if($type === 'textarea')
            <textarea id="{{ $name }}" name="{{ $name }}" rows="{{ $field['rows'] ?? 4 }}" class="form-control @error($name) is-invalid @enderror">{{ $value }}</textarea>
        @elseif($type === 'select')
            <select id="{{ $name }}" name="{{ $name }}" class="form-select @error($name) is-invalid @enderror">
                @foreach(($field['options'] ?? []) as $optionValue => $optionLabel)
                    <option value="{{ $optionValue }}" @selected((string) $value === (string) $optionValue)>{{ $optionLabel }}</option>
                @endforeach
            </select>
        @elseif($type === 'file')
            <input id="{{ $name }}" type="file" name="{{ $name }}" accept="{{ $field['accept'] ?? '' }}" class="form-control @error($name) is-invalid @enderror">
            @if(! empty($item->{$name}))
                <div class="form-text">
                    File saat ini:
                    <a href="{{ asset('storage/'.$item->{$name}) }}" target="_blank" rel="noopener">{{ basename($item->{$name}) }}</a>
                </div>
            @endif
        @else
            <input id="{{ $name }}" type="{{ $type }}" name="{{ $name }}" value="{{ $value }}" class="form-control @error($name) is-invalid @enderror">
        @endif

        @error($name)<div class="invalid-feedback">{{ $message }}</div>@enderror
    @endif
</div>
