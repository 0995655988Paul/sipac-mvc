<?php

namespace Tests\Unit;

use App\Services\PlanificacionService;
use App\Services\PronosticoService;
use PHPUnit\Framework\TestCase;

class PlanificacionServiceTest extends TestCase
{
    public function testSuavizadoYNecesidad(): void
    {
        self::assertSame(89, PronosticoService::suavizar([80, 90, 100]));
        self::assertSame(101, PlanificacionService::necesidad(89, 20, 8, 0));
    }

    public function testCostoIncluyeAdicionalUnitario(): void
    {
        self::assertSame(110.0, PlanificacionService::costo(10, 10.00, 1.00));
    }
}
