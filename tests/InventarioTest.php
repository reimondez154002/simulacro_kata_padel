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
}