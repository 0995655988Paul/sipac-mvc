<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

// Opciones de cifrado de la aplicación.
class Encryption extends BaseConfig
{
    // Clave principal de cifrado.
    public string $key = '';

    /**
     * Claves anteriores para descifrar datos existentes.
     * @var list<string>|string
     */
    public array|string $previousKeys = '';

    // Gestor de cifrado: OpenSSL o Sodium.
    public string $driver = 'OpenSSL';

    // Tamaño de relleno de Sodium, en bytes.
    public int $blockSize = 16;

    // Algoritmo HMAC para verificar los datos.
    public string $digest = 'SHA512';

    // Guarda datos sin codificar; false usa base64 con OpenSSL.
    public bool $rawData = true;

    // Etiqueta de derivación de la clave de cifrado OpenSSL.
    public string $encryptKeyInfo = '';

    // Etiqueta de derivación de la clave de autenticación OpenSSL.
    public string $authKeyInfo = '';

    // Algoritmo de cifrado de OpenSSL.
    public string $cipher = 'AES-256-CTR';
}
