<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Acceso · SIPAC</title>
    <link rel="stylesheet" href="<?= esc(base_url('css/sipac.css?v=7'), 'attr') ?>">
</head>
<body class="acceso--login">
<main class="login">
    <section class="login__presentacion" aria-labelledby="presentacion-titulo">
        <div class="login__marca">
            <strong>SIPAC</strong>
            <span>Sistema de planificación<br>de compras</span>
        </div>

        <div class="login__introduccion">
            <p class="login__etiqueta">INVENTARIO · COMPRAS · PRESUPUESTO</p>
            <h2 id="presentacion-titulo">Planificación de compras<br>para tu institución.</h2>
            <p class="login__resumen">Consulta existencias, registra cotizaciones y prepara tus planes de compra.</p>
            <img class="login__ilustracion" src="<?= esc(base_url('img/compras.svg'), 'attr') ?>" alt="" width="420" height="320">
        </div>

        <p class="login__nota">Proyecto académico · Planificación de compras</p>
    </section>

    <section class="login__panel" aria-labelledby="login-titulo">
        <div class="login__aplicacion">
            <svg width="27" height="27" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
                <path d="M3 4h2l2.2 11h11.6L21 7H6" stroke-linecap="round" stroke-linejoin="round"/>
                <circle cx="9" cy="20" r="1.1"/>
                <circle cx="18" cy="20" r="1.1"/>
            </svg>
            <span>Administración</span>
        </div>

        <p class="login__etiqueta">ACCESO A SIPAC</p>
        <h1 id="login-titulo">Iniciar sesión</h1>
        <p class="login__descripcion">Ingresa para administrar inventario, proveedores y presupuesto.</p>

        <?php if ($exito = session()->getFlashdata('exito')): ?>
            <div class="alerta alerta--ok" role="status"><?= esc($exito) ?></div>
        <?php endif; ?>
        <?php if ($error = session()->getFlashdata('error')): ?>
            <div class="alerta alerta--error" role="alert"><?= esc($error) ?></div>
        <?php endif; ?>

        <form method="post" action="<?= esc(site_url('login'), 'attr') ?>" class="login__formulario">
            <?= csrf_field() ?>

            <div class="login__campo">
                <label for="correo">Correo electrónico</label>
                <input id="correo" name="correo" type="email" autocomplete="username" inputmode="email" autocapitalize="none" spellcheck="false" placeholder="Tu correo electrónico" required>
            </div>

            <div class="login__campo">
                <label for="password">Contraseña</label>
                <div class="login__password">
                    <input id="password" name="password" type="password" autocomplete="current-password" placeholder="Tu contraseña" required>
                    <button class="login__mostrar" type="button" aria-controls="password" aria-pressed="false" hidden>Mostrar</button>
                </div>
            </div>

            <button class="login__ingresar" type="submit">
                <span>Ingresar</span>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path d="M5 12h14m-6-6 6 6-6 6" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </form>

        <p class="login__registro">¿No tienes cuenta? <a href="<?= esc(site_url('registro'), 'attr') ?>">Registrar cuenta</a></p>
        <p class="login__seguridad">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
                <path d="m12 3 8 3v6c0 5-8 9-8 9s-8-4-8-9V6l8-3Z" stroke-linejoin="round"/>
                <path d="m8 12 3 3 5-6" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Acceso protegido con tu cuenta
        </p>
    </section>
</main>
<script>
    const passwordInput = document.querySelector('#password');
    const mostrarButton = document.querySelector('.login__mostrar');

    mostrarButton.hidden = false;
    mostrarButton.addEventListener('click', () => {
        const mostrar = passwordInput.type === 'password';
        passwordInput.type = mostrar ? 'text' : 'password';
        mostrarButton.textContent = mostrar ? 'Ocultar' : 'Mostrar';
        mostrarButton.setAttribute('aria-pressed', String(mostrar));
    });
</script>
</body>
</html>
