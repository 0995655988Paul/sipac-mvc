<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

// Reglas de origen para el contenido de la página (CSP).
class ContentSecurityPolicy extends BaseConfig
{
    // Informa de infracciones sin bloquear contenido.
    public bool $reportOnly = false;

    // URL que recibe informes de infracciones.
    public ?string $reportURI = null;

    // Destino de los informes de infracciones.
    public ?string $reportTo = null;

    // Convierte peticiones HTTP a HTTPS.
    public bool $upgradeInsecureRequests = false;

    /**
     * Origen predeterminado; usa self si no se configura.
     * @var list<string>|string|null
     */
    public $defaultSrc;

    /**
     * Orígenes permitidos para scripts.
     * @var list<string>|string
     */
    public $scriptSrc = 'self';

    /**
     * Orígenes permitidos para etiquetas script.
     * @var list<string>|string
     */
    public array|string $scriptSrcElem = 'self';

    /**
     * Permisos para eventos y enlaces con JavaScript.
     * @var list<string>|string
     */
    public array|string $scriptSrcAttr = 'self';

    /**
     * Orígenes permitidos para estilos.
     * @var list<string>|string
     */
    public $styleSrc = 'self';

    /**
     * Orígenes permitidos para hojas de estilo.
     * @var list<string>|string
     */
    public array|string $styleSrcElem = 'self';

    /**
     * Permisos para estilos dentro del HTML.
     * @var list<string>|string
     */
    public array|string $styleSrcAttr = 'self';

    /**
     * Orígenes permitidos para imágenes.
     * @var list<string>|string
     */
    public $imageSrc = 'self';

    /**
     * Orígenes permitidos para la etiqueta base.
     * @var list<string>|string|null
     */
    public $baseURI;

    /**
     * Orígenes permitidos para marcos y tareas en segundo plano.
     * @var list<string>|string
     */
    public $childSrc = 'self';

    /**
     * Destinos permitidos para conexiones del navegador.
     * @var list<string>|string
     */
    public $connectSrc = 'self';

    /**
     * Orígenes permitidos para fuentes.
     * @var list<string>|string
     */
    public $fontSrc;

    /**
     * Destinos permitidos para formularios.
     * @var list<string>|string
     */
    public $formAction = 'self';

    /**
     * Sitios que pueden incrustar esta página.
     * @var list<string>|string|null
     */
    public $frameAncestors;

    /**
     * Orígenes permitidos para marcos.
     * @var list<string>|string|null
     */
    public $frameSrc;

    /**
     * Orígenes permitidos para audio y video.
     * @var list<string>|string|null
     */
    public $mediaSrc;

    /**
     * Orígenes permitidos para objetos y complementos.
     * @var list<string>|string
     */
    public $objectSrc = 'self';

    /**
     * Orígenes permitidos para el manifiesto.
     * @var list<string>|string|null
     */
    public $manifestSrc;

    /**
     * Orígenes permitidos para tareas en segundo plano.
     * @var list<string>|string
     */
    public array|string $workerSrc = [];

    /**
     * Tipos de complementos permitidos.
     * @var list<string>|string|null
     */
    public $pluginTypes;

    /**
     * Acciones permitidas dentro del entorno aislado.
     * @var list<string>|string|null
     */
    public $sandbox;

    // Marcador de autorización para estilos.
    public string $styleNonceTag = '{csp-style-nonce}';

    // Marcador de autorización para scripts.
    public string $scriptNonceTag = '{csp-script-nonce}';

    // Reemplaza los marcadores de autorización automáticamente.
    public bool $autoNonce = true;
}
