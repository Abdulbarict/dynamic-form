@extends('layouts.app')
@section('title', 'Create Form')
@section('content')
    <div class="container">
        <div class="row justify-content-center mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Create New Form</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('forms.store') }}" id="form-create">
                            @csrf
                            <div class="row">
                                <div class="col-7">
                                    <div class="form-group">
                                        <label for="title">Form Title</label>
                                        <input type="text" class="form-control" id="title" name="title" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
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
                                    <button disabled="" class="btn btn-success mt-3" id="saveForm">Save Form</button>
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
