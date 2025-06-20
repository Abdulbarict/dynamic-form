@extends('layouts.app')
@section('title', 'Edit Forms')
@section('content')
    <div class="container">
        <div class="row justify-content-center mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Edit Form - {{ $form->title }}</div>
                    <div class="card-body">
                        <form method="PUT" action="{{ route('forms.update', $form->id) }}" id="form-update">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="form_id" id="form-id" value="{{ $form->id ?? '' }}">

                            <div class="row">
                                <div class="col-7">
                                    <div class="form-group">
                                        <label for="title">Form Title</label>
                                        <input type="text" class="form-control" id="title" name="title"
                                            value="{{ $form->title }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control" id="description" name="description" rows="3">{{ $form->description ?? '' }} </textarea>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-8">
                                    <div class="col-12">
                                        <h5>Form Builder</h5>
                                    </div>
                                    <ul id="form-builder" class="sortable list-group min-vh-50  p-2">

                                    </ul>
                                    {{-- <textarea id="formJson" class="form-control mt-2" name="fields_json" rows="6" readonly></textarea> --}}
                                    <button type="submit" class="btn btn-success mt-3" id="updateForm">Update Form</button>
                                </div>
                                <div class="col-4">
                                    <div class="col-12">
                                        <h5>Form Inputs</h5>
                                    </div>
                                    <a class="btn btn-outline-primary mb-2 input-btn" data-type="text">Text</a>
                                    <a class="btn btn-outline-primary mb-2 input-btn" data-type="email">Email</a>
                                    <a class="btn btn-outline-primary mb-2 input-btn" data-type="password">Password</a>
                                    <a class="btn btn-outline-primary mb-2 input-btn" data-type="number">Number</a>
                                    <a class="btn btn-outline-primary mb-2 input-btn" data-type="textarea">Textarea</a>
                                    <a class="btn btn-outline-primary mb-2 input-btn" data-type="checkbox">Checkbox
                                    </a>
                                    <a class="btn btn-outline-primary mb-2 input-btn" data-type="radio">Radio
                                        Button</a>
                                    <a class="btn btn-outline-primary mb-2 input-btn" data-type="select">Select
                                        Dropdown</a>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    @endsection
    @push('js')
        <script>
            const fields = @json($form->fields);

            $(document).ready(function() {

                fields.forEach(field => {
                    const id = 'field_' + Math.floor(Math.random() * 1000);
                    var options = '';

                    if (field.field_options) {

                        option = JSON.parse(field.field_options);

                    }

                    const required = field.is_required ? 'checked' : '';

                    let html = `
                        <li class="list-group-item mb-2 d-flex flex-column" data-type="${field.field_type}">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="drag-handle" style="cursor:move;">
                                    <i class="fas fa-grip-vertical mr-2"></i> <strong>${field.field_type}</strong>
                                </div>
                                <a class="btn btn-sm btn-secondary toggle-edit" type="button" data-target="#collapse_${id}">Settings</a>
                                <a class="btn btn-sm btn-danger delete-field">Delete</a>
                            </div>
                            <div class="collapse mt-2 show" id="collapse_${id}">
                                <div class="form-group mt-2">
                                    <label>Label</label>
                                    <input type="text" class="form-control field-label" value="${field.field_label}">
                                </div>
                                <div class="form-group">
                                    <label>Field Name</label>
                                    <input type="text" class="form-control field-name" value="${field.field_name}">
                                </div>
                                <div class="form-group">
                                    <label>Placeholder</label>
                                    <input type="text" class="form-control field-placeholder" value="${field.placeholder ?? ''}">
                                </div>
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input field-required" id="required_${id}" ${required}>
                                    <label class="form-check-label" for="required_${id}">Required</label>
                                </div>`;

                    if (['select', 'radio', 'checkbox'].includes(field.field_type)) {

                        html += `
                        <div class="form-group">
                            <label>Options (comma-separated)</label>
                            <input type="text" class="form-control field-options" value="${JSON.parse(field.field_options)}">
                        </div>`;
                    }

                    html += `</div></li>`;

                    $('#form-builder').append(html);
                });

            });
            $(document).on('click', '#updateForm', function(e) {
                e.preventDefault();

                const fields = [];
                $('#form-builder li').each(function() {
                    const order = $(this).index() + 1;
                    const field = {
                        type: $(this).data('type'),
                        label: $(this).find('.field-label').val(),
                        name: $(this).find('.field-name').val(),
                        placeholder: $(this).find('.field-placeholder').val(),
                        required: $(this).find('.field-required').is(':checked'),
                        options: $(this).find('.field-options').val(),
                        order: order,
                    };
                    fields.push(field);
                });

                const form = $('#form-update');

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        _method: 'PUT',
                        form_name: form.find('input[name="title"]').val(),
                        description: form.find('textarea[name="description"]').val(),
                        input_fields: JSON.stringify(fields),
                    },
                    success: function(response) {
                        if (response.success) {
                            window.location.href = response.route;
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            let errorMsg = '';
                            for (const key in errors) {
                                errorMsg += errors[key].join(', ') + '\n';
                            }
                            alert(errorMsg);
                        } else {
                            alert('Error updating form: ' + xhr.responseText);
                        }
                    }
                });

            });
        </script>
    @endpush
