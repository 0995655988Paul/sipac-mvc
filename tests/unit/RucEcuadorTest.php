<?php

namespace Tests\Unit;

use App\Services\RucEcuador;
use PHPUnit\Framework\TestCase;

class RucEcuadorTest extends TestCase
{
    public function testRucValidoDePersonaJuridica(): void
    {
        self::assertTrue(RucEcuador::esValido('1790016919001'));
    }

    public function testRucInvalidoNoPasaAlmacenamiento(): void
    {
        self::assertFalse(RucEcuador::esValido('1790016919002'));
        self::assertFalse(RucEcuador::esValido('123'));
    }
}
