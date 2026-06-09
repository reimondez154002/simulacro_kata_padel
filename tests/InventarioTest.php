<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . "/../src/Inventario.php";

class InventarioTest extends TestCase{
    public function test_vaciar_devuelve_respuesta_de_vaciado_correcto():void{
        //Preparar(Preparar Mock)
        $catalogoMock = $this->createMock(Catalogo::class);
        $inventario = new Inventario($catalogoMock);

        //Ejecutar Accion
        $resultado = $inventario->ejecutar("vaciar");

        //Comprobar
        $this->assertEquals("El inventario ha sido vaciado", $resultado);
    }

    public function test_funcion_cuenta_vacia_devuelve_00():void{
        //Preparar(MOCK)
        $catalogoMock = $this->createMock(Catalogo::class);
        $inventario = new Inventario($catalogoMock);
        //Ejecutar Accion
        $resultado = $inventario->ejecutar("cuenta");

        //Comprobar
        $this->assertEquals("Total: 0.00", $resultado);
    }
}