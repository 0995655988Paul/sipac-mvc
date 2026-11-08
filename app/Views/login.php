<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Acceso · SIPAC</title>
    <link rel="stylesheet" href="<?= esc(base_url('css/sipac.css?v=4'), 'attr') ?>">
</head>
<body class="acceso acceso--login">
<main class="login">
    <header class="login__marca">
        <span class="marca__simbolo" aria-hidden="true">S</span>
        <div>
            <strong>SIPAC</strong>
            <span>Administración de compras</span>
        </div>
    </header>

    <section class="login__panel" aria-labelledby="login-titulo">
        <div class="login__contenido">
            <h1 id="login-titulo">Iniciar sesión</h1>
            <p class="login__descripcion">Accede con tu cuenta para administrar el sistema.</p>

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
                    <input id="correo" name="correo" type="email" autocomplete="username" inputmode="email" autocapitalize="none" spellcheck="false" placeholder="nombre@ejemplo.com" required>
                </div>

                <div class="login__campo">
                    <label for="password">Contraseña</label>
                    <div class="login__password">
                        <input id="password" name="password" type="password" autocomplete="current-password" placeholder="Ingresa tu contraseña" required>
                        <button class="login__mostrar" type="button" aria-controls="password" aria-pressed="false" hidden>Mostrar</button>
                    </div>
                </div>

                <button class="login__ingresar" type="submit">Ingresar al sistema</button>
            </form>
        </div>

        <footer class="login__registro">
            <span>¿Aún no tienes una cuenta?</span>
            <a href="<?= esc(site_url('registro'), 'attr') ?>">Crear cuenta</a>
        </footer>
    </section>

    <p class="login__pie">Sistema de planificación de compras</p>
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
