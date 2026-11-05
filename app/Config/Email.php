<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Email extends BaseConfig
{
    public string $fromEmail  = '';
    public string $fromName   = '';
    public string $recipients = '';

    // Nombre del cliente de correo.
    public string $userAgent = 'CodeIgniter';

    // Protocolo de envío: mail, sendmail o smtp.
    public string $protocol = 'mail';

    // Ruta del programa Sendmail.
    public string $mailPath = '/usr/sbin/sendmail';

    // Servidor SMTP.
    public string $SMTPHost = '';

    // Método de autenticación SMTP: login o plain.
    public string $SMTPAuthMethod = 'login';

    // Usuario SMTP.
    public string $SMTPUser = '';

    // Contraseña SMTP.
    public string $SMTPPass = '';

    // Puerto SMTP.
    public int $SMTPPort = 25;

    // Tiempo máximo de espera SMTP, en segundos.
    public int $SMTPTimeout = 5;

    // Mantiene abierta la conexión SMTP.
    public bool $SMTPKeepAlive = false;

    /**
     * Cifrado SMTP: tls, ssl o vacío.
     * @var string
     */
    public string $SMTPCrypto = 'tls';

    // Ajusta las líneas del mensaje.
    public bool $wordWrap = true;

    // Cantidad de caracteres por línea.
    public int $wrapChars = 76;

    // Formato del correo: text o html.
    public string $mailType = 'text';

    // Codificación del mensaje.
    public string $charset = 'UTF-8';

    // Comprueba el formato de la dirección de correo.
    public bool $validate = false;

    // Prioridad: 1 alta, 3 normal y 5 baja.
    public int $priority = 3;

    // Separador de líneas según RFC 822.
    public string $CRLF = "\r\n";

    // Salto de línea según RFC 822.
    public string $newline = "\r\n";

    // Envía copias ocultas por lotes.
    public bool $BCCBatchMode = false;

    // Cantidad de destinatarios por lote.
    public int $BCCBatchSize = 200;

    // Solicita avisos de entrega al servidor.
    public bool $DSN = false;
}
