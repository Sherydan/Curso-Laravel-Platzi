<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');

        # le pregunto que es lo que deberia haber retornado
        # assert = obtubiste lo que espero?
        $response->assertStatus(200);
        $response->assertSee('Laratter');

        /* Pasos de los test */

        # Arrange | Preparacion (puede o no tenerla)

        # Act | Accion

        # Assert | Verificacion
    }

    public function testSearchForMessages(){
        # se le llama test de integracion por que se esta usando 
        # un servicio externo (algolia) para hacer la busqueda
        $response = $this->get('/messages?query=alice');

        $response->assertSee('alice');
    }
}
