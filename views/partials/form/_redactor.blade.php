@php
    $translated = $translated ?? false;
    $maxlength = $maxlength ?? false;
    $options = $options ?? false;
    $placeholder = $placeholder ?? false;
    $note = $note ?? false;
    $disabled = $disabled ?? false;
    $readonly = $readonly ?? false;
    $inModal = $fieldsInModal ?? false;
    $options = $customOptions ?? $toolbarOptions ?? false;
    $imageUpload = $imageUpload ?? false;
    $imageList = $imageList ?? false;
@endphp

@if($translated)
    <a17-locale
        type="a17-redactor"
        :attributes="{
            label: '{{ $label }}',
            @include('twill::partials.form.utils._field_name', ['asAttributes' => true])
            @if ($note) note: '{{ $note }}', @endif
            @if ($options) options: {!! e(json_encode($options)) !!}, @endif
            @if ($placeholder) placeholder: '{{ $placeholder }}', @endif
            @if ($maxlength) maxlength: {{ $maxlength }}, @endif
            @if ($disabled) disabled: true, @endif
            @if ($readonly) readonly: true, @endif
            @if ($inModal) inModal: true, @endif
            @if ($imageUpload) imageUpload: '{{ $imageUpload }}', @endif
            @if ($imageList) imageList: '{{ $imageList }}', @endif
            inStore: 'value'
            uploadToken: '{{ csrf_token() }}'
        }"
    ></a17-locale>
@else
    <a17-redactor
        label="{{ $label }}"
        @include('twill::partials.form.utils._field_name')
        @if ($note) note="{{ $note }}" @endif
        @if ($options) :options='{!! json_encode($options) !!}' @endif
        @if ($placeholder) placeholder='{{ $placeholder }}' @endif
        @if ($maxlength) :maxlength='{{ $maxlength }}' @endif
        @if ($disabled) disabled @endif
        @if ($readonly) readonly @endif
        @if ($inModal) :in-modal="true" @endif
        @if ($imageUpload) imageUpload='{{ $imageUpload }}', @endif
        @if ($imageList) imageList='{{ $imageList }}', @endif
        in-store="value"
        uploadToken='{{ csrf_token() }}'
    ></a17-redactor>
@endif

@unless($renderForBlocks || $renderForModal)
@push('vuexStore')
    @if($translated && isset($form_fields['translations']) && isset($form_fields['translations'][$name]))
        window.STORE.form.fields.push({
            name: '{{ $name }}',
            value: {
                @foreach(getLocales() as $locale)
                    '{{ $locale }}': {!! json_encode(
                        $form_fields['translations'][$name][$locale] ?? ''
                    ) !!}@unless($loop->last),@endif
                @endforeach
            }
        })
    @elseif(isset($item->$name) || null !== $formFieldsValue = getFormFieldsValue($form_fields, $name))
        window.STORE.form.fields.push({
            name: '{{ $name }}',
            value: {!! json_encode(isset($item->$name) ? $item->$name : $formFieldsValue) !!}
        })
    @endif

@endpush
@endunless
