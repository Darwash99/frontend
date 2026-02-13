<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>

<div class="login-container">

    <div class="avatar-circle">
        <i class="bi bi-person"></i>
    </div>

    <form method="POST" action="/login" id="loginForm">
        @csrf

        <div class="input-group">
            <i class="bi bi-envelope"></i>
            <input type="text" name="name" placeholder="Usuario" value="{{ old('name') }}" autocomplete="off">
        </div>

        <div class="input-group">
            <i class="bi bi-lock"></i>
            <input type="password" name="password" placeholder="Contraseña">
        </div>

        <div class="options">
            <label>
                <input type="checkbox"> Recuerdame
            </label>
            <a href="#">Olvido de contraseña?</a>
        </div>

        <button class="login-btn" id="loginButton">
            <span id="btnText">INGRESAR</span>
            <span id="btnSpinner" class="spinner-border spinner-border-sm ms-2 d-none"></span>
        </button>

    </form>
</div>

<div class="position-fixed top-0 end-0 p-4" style="z-index: 1100">
    <div id="liveToast" class="toast shadow border-0" role="alert">
        <div class="toast-body d-flex align-items-center">
            <div id="toastIconWrapper" class="me-3">
                <i id="toastIcon" class="fs-4"></i>
            </div>
            <div class="flex-grow-1">
                <strong id="toastTitle" class="d-block"></strong>
                <span id="toastMessage" class="small text-muted">
                    @if(session('error'))
                        {{ session('error') }}                    
                    @endif
                </span>
            </div>
            <button type="button" class="btn-close ms-3" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/showtoast.js') }}"></script>

<script>
    @if(session('error'))
        showToast("{{ session('error') }}", "danger");
    @endif

    //Validar formulario y mostrar cargando al enviar
    document.getElementById("loginForm").addEventListener("submit", function(e) {
        if (!validarFormulario()) {
            e.preventDefault();
            return;
        }
        const button = document.getElementById("loginButton");
        const spinner = document.getElementById("btnSpinner");
        const btnText = document.getElementById("btnText");

        // 🔥 Activar modo cargando
        button.disabled = true;
        spinner.classList.remove("d-none");
        btnText.textContent = "Cargando...";
    });

    //validacion de formulario
    function validarFormulario() {
        const name = document.querySelector("input[name='name']").value.trim();
        const password = document.querySelector("input[name='password']").value.trim();

        if (!name) {
            showToast("El usuario es obligatorio");
            return false;
        }

        if (!password) {
            showToast("La contraseña es obligatoria");
            return false;
        }

        if (password.length < 4) {
            showToast("La contraseña debe tener al menos 4 caracteres");
            return false;
        }

        return true;
    }

</script>
</body>
</html>


