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

    public function test_funcion_añadir_un_artiulo_sin_cantidad_a_inventario():void{
        //Preparar(MOCK)
        $catalogoMock = $this->createMock(Catalogo::class);
        $catalogoMock->method("getPrecio")->willReturnCallback(function($articulo){
            if($articulo === "raqueta"){

                return 50.00;
            }
        });
        $inventario = new Inventario($catalogoMock);
        //Ejecutar Accion
        $resultado = $inventario->ejecutar("añadir raqueta");

        //Comprobar
        $this->assertEquals("raqueta x1", $resultado);
    }

    public function test_funcion_añadir_varios_articulos_los_devuelve_ordenados_alfabeticamente():void{
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
        $inventario = new Inventario($catalogoMock);
        //Ejecutar Accion
        $resultado = $inventario->ejecutar("añadir raqueta");
        $resultado = $inventario->ejecutar("añadir pelotas");

        //Comprobar
        $this->assertEquals("pelotas x1, raqueta x1", $resultado);
    }

        public function test_añadir_articulo_que_ya_existe():void{
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
        $inventario = new Inventario($catalogoMock);
        //Ejecutar Accion
        $resultado = $inventario->ejecutar("añadir raqueta");
        $resultado = $inventario->ejecutar("añadir raqueta");

        //Comprobar
        $this->assertEquals("raqueta x2", $resultado);
    }
    public function test_añadir_articulo_con_cantidad():void{
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
        $inventario = new Inventario($catalogoMock);
        //Ejecutar Accion
        $resultado = $inventario->ejecutar("añadir raqueta 2");
        //Comprobar
        $this->assertEquals("raqueta x2", $resultado);
    }

    public function test_añadir_articulo_que_no_existe_en_el_catalogo():void{
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
        $inventario = new Inventario($catalogoMock);
        //Ejecutar Accion
        $resultado = $inventario->ejecutar("añadir patatas");
        //Comprobar
        $this->assertEquals("El articulo no existe en el catalogo", $resultado);
    }
    
    public function test_vaciar_inventario_no_vacio():void{
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
        $inventario = new Inventario($catalogoMock);
        //Ejecutar Accion
        $inventario->ejecutar("añadir patatas");
        $resultado = $inventario->ejecutar("vaciar");
        //Comprobar
        $this->assertEquals("El inventario ha sido vaciado", $resultado);
    }

    public function test_eliminar_elemento_de_inventario_lo_borra():void{
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
        $inventario = new Inventario($catalogoMock);
        //Ejecutar Accion
        $inventario->ejecutar("añadir pelotas");
        $inventario->ejecutar("añadir raqueta");
        $resultado = $inventario->ejecutar("eliminar raqueta");
        //Comprobar
        $this->assertEquals("pelotas x1", $resultado);
    }
}