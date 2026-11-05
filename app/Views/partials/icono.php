<?php
$trazos = [
    'alimento' => '<path d="M6 10h12a6 6 0 0 1-12 0Z"/><path d="M4 10h16M8 20h8M9 6c-2-2 2-2 0-4m6 4c-2-2 2-2 0-4"/>',
    'caja' => '<path d="m12 3 9 5-9 5-9-5 9-5ZM3 8v9l9 5 9-5V8M12 13v9M7.5 5.5l9 5"/>',
    'mas' => '<path d="M12 5v14M5 12h14"/>',
    'editar' => '<path d="m16 3 5 5-12 12-6 1 1-6L16 3ZM13 6l5 5"/>',
    'eliminar' => '<path d="M3 6h18M9 6V3h6v3M5 6l1 15h12l1-15M10 10v7m4-7v7"/>',
    'salir' => '<path d="M10 4H4v16h6M8 12h13m-4-4 4 4-4 4"/>',
    'flecha' => '<path d="M5 12h14m-5-5 5 5-5 5"/>',
    'atras' => '<path d="M19 12H5m5-5-5 5 5 5"/>',
    'alerta' => '<path d="m12 3 10 18H2L12 3ZM12 9v5m0 3v.1"/>',
    'escudo' => '<path d="m12 3 8 3v6c0 5-8 9-8 9s-8-4-8-9V6l8-3Z"/><path d="m8 12 3 3 5-6"/>',
    'check' => '<path d="m5 12 4 4L19 6"/>',
];
?>
<svg class="icono" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><?= $trazos[$nombre ?? 'alimento'] ?? $trazos['alimento'] ?></svg>
