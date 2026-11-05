<a class="saltar-contenido" href="#contenido">Ir al contenido</a>
<header class="barra-superior">
    <?= view('partials/marca') ?>
    <div class="marca-hanaska"><?= view('partials/icono', ['nombre' => 'alimento']) ?><span>Hanaska</span><small>CAFETERÍA</small></div>
</header>
<aside class="barra-lateral" aria-label="Menú del inventario">
    <a class="titulo-app" href="<?= esc(site_url('productos'), 'attr') ?>">
        <span class="marca-icono"><?= view('partials/icono', ['nombre' => 'alimento']) ?></span>
        <span>Alimentos<small>GESTIÓN DE INVENTARIO</small></span>
    </a>
    <p class="menu-etiqueta">TU ESPACIO</p>
    <nav aria-label="Navegación principal">
        <a class="menu-activo" href="<?= esc(site_url('productos'), 'attr') ?>" <?= uri_string() === 'productos' ? 'aria-current="page"' : '' ?>><?= view('partials/icono', ['nombre' => 'caja']) ?> Inventario</a>
    </nav>
    <div class="nota-cocina">
        <?= view('partials/icono', ['nombre' => 'alimento']) ?>
        <strong>Cada alimento cuenta.</strong>
        <p>Mantén las cantidades al día para planificar mejor tu cocina.</p>
    </div>
    <div class="sesion">
        <div class="usuario-sesion"><span class="avatar" aria-hidden="true"><?= esc(mb_strtoupper(mb_substr($usuario, 0, 1))) ?></span><span><small>SESIÓN INICIADA</small><strong><?= esc($usuario) ?></strong></span></div>
        <form method="post" action="<?= esc(site_url('salir'), 'attr') ?>">
            <?= csrf_field() ?>
            <button class="boton boton-salir" type="submit"><?= view('partials/icono', ['nombre' => 'salir']) ?> Cerrar sesión</button>
        </form>
    </div>
</aside>
