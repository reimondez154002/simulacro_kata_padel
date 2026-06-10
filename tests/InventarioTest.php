<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . "/../src/Inventario.php";

class InventarioTest extends TestCase{

    private Inventario $inventario;
    public function setUp():void{
         //Preparar(MOCK)
        $catalogoMock = $this->createMock(Catalogo::class);
        $catalogoMock->method("getPrecio")->willReturnCallback(function($articulo){
            if($articulo === "raqueta"){

                return 50.00;
            }

            if($articulo === "pelotas"){

                return 5.00;
            }
        });
        $this->inventario = new Inventario($catalogoMock);
    }
    
    public function test_vaciar_devuelve_respuesta_de_vaciado_correcto():void{
        //Ejecutar Accion
        $resultado = $this->inventario->ejecutar("vaciar");

        //Comprobar
        $this->assertEquals("El inventario ha sido vaciado", $resultado);
    }

    public function test_funcion_cuenta_vacia_devuelve_00():void{
        //Ejecutar Accion
        $resultado = $this->inventario->ejecutar("cuenta");

        //Comprobar
        $this->assertEquals("Total: 0.00", $resultado);
    }

    public function test_funcion_añadir_un_artiulo_sin_cantidad_a_inventario():void{
        //Ejecutar Accion
        $resultado = $this->inventario->ejecutar("añadir raqueta");

        //Comprobar
        $this->assertEquals("raqueta x1", $resultado);
    }

    public function test_funcion_añadir_varios_articulos_los_devuelve_ordenados_alfabeticamente():void{
        //Ejecutar Accion
        $resultado = $this->inventario->ejecutar("añadir raqueta");
        $resultado = $this->inventario->ejecutar("añadir pelotas");

        //Comprobar
        $this->assertEquals("pelotas x1, raqueta x1", $resultado);
    }

        public function test_añadir_articulo_que_ya_existe():void{
        //Ejecutar Accion
        $resultado = $this->inventario->ejecutar("añadir raqueta");
        $resultado = $this->inventario->ejecutar("añadir raqueta");

        //Comprobar
        $this->assertEquals("raqueta x2", $resultado);
    }
    public function test_añadir_articulo_con_cantidad():void{
        //Ejecutar Accion
        $resultado = $this->inventario->ejecutar("añadir raqueta 2");
        //Comprobar
        $this->assertEquals("raqueta x2", $resultado);
    }

    public function test_añadir_articulo_que_no_existe_en_el_catalogo():void{
        //Ejecutar Accion
        $resultado = $this->inventario->ejecutar("añadir patatas");
        //Comprobar
        $this->assertEquals("El articulo no existe en el catalogo", $resultado);
    }
    
    public function test_vaciar_inventario_no_vacio():void{
        //Ejecutar Accion
        $this->inventario->ejecutar("añadir patatas");
        $resultado = $this->inventario->ejecutar("vaciar");
        //Comprobar
        $this->assertEquals("El inventario ha sido vaciado", $resultado);
    }

    public function test_eliminar_elemento_de_inventario_lo_borra():void{
        //Ejecutar Accion
        $this->inventario->ejecutar("añadir pelotas");
        $this->inventario->ejecutar("añadir raqueta");
        $resultado = $this->inventario->ejecutar("eliminar raqueta");
        //Comprobar
        $this->assertEquals("pelotas x1", $resultado);
    }

    public function test_eliminar_elemento_no_existente():void{
        //Ejecutar Accion
        $this->inventario->ejecutar("añadir pelotas");
        $this->inventario->ejecutar("añadir raqueta");
        $resultado = $this->inventario->ejecutar("eliminar agua");
        //Comprobar
        $this->assertEquals("El elemento a eliminar no esta en el inventario", $resultado);
    }

    public function test_eliminar_hasta_vaciar():void{
        //Ejecutar Accion
        $this->inventario->ejecutar("añadir pelotas");
        $this->inventario->ejecutar("añadir raqueta");
        $this->inventario->ejecutar("eliminar raqueta");
        $resultado = $this->inventario->ejecutar("eliminar pelotas");

        //Comprobar
        $this->assertEquals("La lista ha sido vaciada", $resultado);
    }
}