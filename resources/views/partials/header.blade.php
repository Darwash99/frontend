<div class="header">

    <div>
        <strong>@yield('title')</strong>
    </div>

    <div class="d-flex align-items-center">

        <span class="me-3">
            <i class="bi bi-person-circle"></i> {{ ucfirst(session('user_name')) ?? 'Usuario' }}
        </span>

        <form method="GET" action="/logout">
            @csrf
            <button class="btn btn-sm btn-outline-danger">
                <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
            </button>
        </form>

    </div>

</div>
