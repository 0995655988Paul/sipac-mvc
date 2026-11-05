<!doctype html>
<html lang="es">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Acceso · SIPAC</title><link rel="stylesheet" href="<?= esc(base_url('css/sipac.css?v=3'), 'attr') ?>"></head>
<body class="acceso acceso--login">
<main class="acceso__tarjeta acceso__tarjeta--login">
    <section class="acceso__formulario">
        <div class="login__marca"><span class="marca__simbolo">S</span><span><strong>SIPAC</strong><small>Sistema de planificación de compras</small></span></div>
        <h1>Iniciar sesión</h1><p class="muted">Ingresa tus datos para continuar.</p>
        <?php if ($exito = session()->getFlashdata('exito')): ?><div class="alerta alerta--ok"><?= esc($exito) ?></div><?php endif; ?>
        <?php if ($error = session()->getFlashdata('error')): ?><div class="alerta alerta--error"><?= esc($error) ?></div><?php endif; ?>
        <form method="post" action="<?= esc(site_url('login'), 'attr') ?>" class="formulario">
            <?= csrf_field() ?>
            <label>Correo electrónico<input name="correo" type="email" autocomplete="username" placeholder="admin@sipac.local" required autofocus></label>
            <label>Contraseña<input name="password" type="password" autocomplete="current-password" placeholder="••••••••" required></label>
            <button class="boton boton--primario" type="submit">Ingresar</button>
        </form>
        <p class="formulario__pie">¿No tienes una cuenta? <a href="<?= esc(site_url('registro'), 'attr') ?>">Registrarse</a></p>
    </section>
</main>
</body>
</html>
