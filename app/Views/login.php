<!doctype html>
<html lang="es">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Acceso · SIPAC</title><link rel="stylesheet" href="<?= esc(base_url('css/sipac.css'), 'attr') ?>"></head>
<body class="acceso">
<main class="acceso__tarjeta">
    <section class="acceso__marca"><span class="marca__simbolo">S</span><p class="eyebrow">SIPAC · ADMINISTRACIÓN</p><h1>Planifica con<br><em>evidencia.</em></h1><p>Controla inventario, proveedores, cotizaciones y presupuesto desde un solo flujo MVC.</p><div class="acceso__orb orb--one"></div><div class="acceso__orb orb--two"></div></section>
    <section class="acceso__formulario">
        <p class="eyebrow">BIENVENIDO</p><h2>Iniciar sesión</h2><p class="muted">Ingresa a tu consola de planificación de compras.</p>
        <?php if ($exito = session()->getFlashdata('exito')): ?><div class="alerta alerta--ok"><?= esc($exito) ?></div><?php endif; ?>
        <?php if ($error = session()->getFlashdata('error')): ?><div class="alerta alerta--error"><?= esc($error) ?></div><?php endif; ?>
        <form method="post" action="<?= esc(site_url('login'), 'attr') ?>" class="formulario">
            <?= csrf_field() ?>
            <label>Correo institucional<input name="correo" type="email" autocomplete="username" placeholder="admin@sipac.local" required autofocus></label>
            <label>Contraseña<input name="password" type="password" autocomplete="current-password" placeholder="••••••••" required></label>
            <button class="boton boton--primario" type="submit">Entrar al panel <span>→</span></button>
        </form>
        <p class="formulario__pie">¿Es tu primera vez? <a href="<?= esc(site_url('registro'), 'attr') ?>">Crear cuenta administrativa</a></p>
        <p class="seguridad">▣ Sesión protegida con CSRF y contraseña con hash bcrypt.</p>
    </section>
</main>
</body>
</html>
