<!doctype html>
<html lang="es">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Crear cuenta · SIPAC</title><link rel="stylesheet" href="<?= esc(base_url('css/sipac.css'), 'attr') ?>"></head>
<body class="acceso">
<main class="acceso__tarjeta acceso__tarjeta--registro">
    <section class="acceso__marca"><span class="marca__simbolo">S</span><p class="eyebrow">CONTROL DE ACCESO</p><h1>Una cuenta.<br><em>Todo el control.</em></h1><p>Las credenciales se guardan como hash y cada operación exige sesión autenticada.</p></section>
    <section class="acceso__formulario"><a class="volver" href="<?= esc(site_url('/'), 'attr') ?>">← Volver al acceso</a><p class="eyebrow">NUEVO ADMINISTRADOR</p><h2>Crear cuenta</h2><p class="muted">La validación ocurre en el servidor antes de registrar.</p>
        <?php if (isset($errores['registro'])): ?><div class="alerta alerta--error"><?= esc($errores['registro']) ?></div><?php endif; ?>
        <form method="post" action="<?= esc(site_url('registro'), 'attr') ?>" class="formulario">
            <?= csrf_field() ?>
            <label>Nombre completo<input name="nombre" type="text" maxlength="120" required value="<?= esc($datos['nombre'] ?? '', 'attr') ?>"><small><?= isset($errores['nombre']) ? esc($errores['nombre']) : '' ?></small></label>
            <label>Correo<input name="correo" type="email" maxlength="254" required value="<?= esc($datos['correo'] ?? '', 'attr') ?>"><small><?= isset($errores['correo']) ? esc($errores['correo']) : '' ?></small></label>
            <label>Contraseña<input name="password" type="password" minlength="8" maxlength="72" required><small><?= isset($errores['password']) ? esc($errores['password']) : 'Mínimo 8 caracteres, con mayúscula, minúscula, número y símbolo.' ?></small></label>
            <label>Confirmar contraseña<input name="confirmar_password" type="password" minlength="8" maxlength="72" required><small><?= isset($errores['confirmar_password']) ? esc($errores['confirmar_password']) : '' ?></small></label>
            <button class="boton boton--primario" type="submit">Crear cuenta <span>→</span></button>
        </form>
    </section>
</main>
</body>
</html>
