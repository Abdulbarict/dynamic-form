@extends('layouts.app')
@section('title', 'Manage Forms')
@section('content')
    <div class="container">
        <div class="row justify-content-center mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Manage Forms</span>
                        <a href="{{ route('forms.create') }}" class="btn btn-primary">Create New Form</a>
                    </div>

                    <div class="card-body">
                        <table class="table table-bordered" id="forms-table">
                            <thead>
                                <tr>
                                    <th width="4%">#</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>

    @endsection
    @push('js')
        <script>
            $(document).ready(function() {
                let formtable = $('#forms-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{ route('forms.index') }}',
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'title',
                            name: 'title'
                        },
                        {
                            data: 'description',
                            name: 'description'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ]
                });

                $(document).on('click', '.delete-btn', function(e) {
                    e.preventDefault();
                    let url = $(this).data('href');

                    if (confirm('Are you sure you want to delete this form?')) {
                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(res) {
                                formtable.ajax.reload();
                                // alert('Form deleted successfully');
                            },
                            error: function(xhr) {
                                alert('Something went wrong!');
                            }
                        });
                    }
                });

            });
        </script>
    @endpush
