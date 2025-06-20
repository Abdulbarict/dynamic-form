@extends('layouts.guest')
@section('title', $form->title)
@push('css')
    <style>
        body {
            background-color: #f8f9fa;
        }

        .form-container {
            max-width: 720px;
            margin: 50px auto;
            background-color: #fff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        }

        .form-title {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 20px;
            color: #202124;
        }

        .form-description {
            color: #5f6368;
            margin-bottom: 30px;
        }

        .form-check-label {
            margin-left: 8px;
        }

        .btn-submit {
            background-color: #1a73e8;
            color: white;
        }
    </style>
@endpush
@section('content')
    <div class="form-container">
        <div class="form-title">{{ $form->title }}</div>
        <div class="form-description">{{ $form->description }}</div>

        <form method="POST" action="">
            @csrf

            @foreach ($form->fields as $field)
                <div class="mb-3">
                    <label for="{{ $field->field_name }}" class="form-label">
                        {{ $field->field_label }}
                        @if ($field->is_required)
                            <span class="text-danger">*</span>
                        @endif
                    </label>

                    @php
                        $required = $field->is_required ? 'required' : '';
                        $options = $field->field_options ? explode(',', $field->field_options) : [];
                    @endphp

                    @switch($field->field_type)
                        @case('text')
                        @case('email')
                            <input type="{{ $field->field_type }}" name="{{ $field->field_name }}" class="form-control"
                                placeholder="{{ $field->placeholder }}" id="{{ $field->field_name }}" {{ $required }}>
                        @break

                        @case('textarea')
                            <textarea name="{{ $field->field_name }}" id="{{ $field->field_name }}" class="form-control" rows="3"
                                placeholder="{{ $field->placeholder }}" {{ $required }}></textarea>
                        @break

                        @case('select')
                            @if (!empty($options))
                                <select name="{{ $field->field_name }}" id="{{ $field->field_name }}" class="form-control"
                                    {{ $required }}>
                                    <option value="" disabled selected>Select an option</option>
                                    @foreach ($options as $option)
                                        <option value="{{ trim($option, '"') }}">{{ trim($option, '"') }}</option>
                                    @endforeach
                                </select>
                            @endif
                        @break

                        @case('radio')
                            @if (!empty($options))
                                @foreach ($options as $option)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="{{ $field->field_name }}"
                                            id="{{ $field->field_name }}_{{ $loop->index }}" value="{{ $option }}"
                                            {{ $required }}>
                                        <label class="form-check-label" for="{{ $field->field_name }}_{{ $loop->index }}">
                                            {{ trim($option, '"') }}
                                        </label>
                                    </div>
                                @endforeach
                            @endif
                        @break

                        @case('checkbox')
                            @if (!empty($options))
                                @foreach ($options as $option)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="{{ $field->field_name }}[]"
                                            id="{{ $field->field_name }}_{{ $loop->index }}" value="{{ $option }}">
                                        <label class="form-check-label" for="{{ $field->field_name }}_{{ $loop->index }}">
                                            {{ trim($option, '"') }}
                                        </label>
                                    </div>
                                @endforeach
                            @endif
                        @break

                        @default
                            <input type="text" name="{{ $field->field_name }}" class="form-control"
                                placeholder="{{ $field->placeholder }}" id="{{ $field->field_name }}" {{ $required }}>
                    @endswitch
                </div>
            @endforeach

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

    </div>
@endsection
