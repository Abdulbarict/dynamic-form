<!-- sidebar -->
<div class="col-md-3 col-lg-2 px-0 position-fixed h-100 bg-white shadow-sm sidebar" id="sidebar">
    <a class="text-decoration-none" href="{{ url('/dashboard') }}">
        <h1 class="bi bi-bootstrap text-primary d-flex my-4 justify-content-center">D-Forms</h1>
    </a>
    <div class="list-group rounded-0">
        <a href="{{ url('/dashboard') }}"
            class="list-group-item list-group-item-action active border-0 d-flex align-items-center">
            <span class="bi bi-border-all"></span>
            <span class="ml-2">Dashboard</span>
        </a>
        <a href="{{ route('forms.index') }}"
            class="list-group-item list-group-item-action  border-0 d-flex align-items-center">
            <span class="bi bi-border-all"></span>
            <span class="ml-2">Manage Forms</span>
        </a>

    </div>
</div>
