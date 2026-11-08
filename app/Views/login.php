<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Acceso · SIPAC</title>
    <link rel="stylesheet" href="<?= esc(base_url('css/sipac.css?v=6'), 'attr') ?>">
</head>
<body class="acceso--login">
<header class="login__cabecera">
    <div class="login__barra">
        <a class="login__marca" href="<?= esc(site_url('/'), 'attr') ?>">
            <strong>SIPAC</strong>
            <span>Planificación de compras</span>
        </a>
        <nav class="login__navegacion" aria-label="Acceso de usuarios">
            <a href="<?= esc(site_url('/'), 'attr') ?>" aria-current="page">Iniciar sesión</a>
            <a href="<?= esc(site_url('registro'), 'attr') ?>">Crear cuenta</a>
        </nav>
    </div>
</header>

<main class="login" id="contenido">
    <nav class="login__ruta" aria-label="Ruta de navegación">
        <a href="<?= esc(site_url('/'), 'attr') ?>">SIPAC</a>
        <span aria-hidden="true">/</span>
        <span aria-current="page">Acceso</span>
    </nav>

    <div class="login__titulo">
        <h1 id="login-titulo">Acceso al sistema</h1>
        <p>Inicia sesión con tu cuenta de administrador.</p>
    </div>

    <section class="login__panel" aria-labelledby="login-titulo">
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
                <input id="correo" name="correo" type="email" autocomplete="username" inputmode="email" autocapitalize="none" spellcheck="false" placeholder="usuario@correo.com" required>
            </div>

            <div class="login__campo">
                <label for="password">Contraseña</label>
                <div class="login__password">
                    <input id="password" name="password" type="password" autocomplete="current-password" required>
                    <button class="login__mostrar" type="button" aria-controls="password" aria-pressed="false" hidden>Mostrar</button>
                </div>
            </div>

            <div class="login__acciones">
                <button class="login__ingresar" type="submit">Ingresar</button>
            </div>
        </form>

        <div class="login__registro">
            <span>¿No tienes una cuenta?</span>
            <a href="<?= esc(site_url('registro'), 'attr') ?>">Registrarse</a>
        </div>
    </section>
</main>

<footer class="login__pie">
    <div>
        <span>SIPAC · Sistema de planificación de compras</span>
        <span>Administración</span>
    </div>
</footer>
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
