<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class ListEmpleados extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->get('/empleados');

        $this->assertResponseStatus(200);
        $this->assertJson($this->response->getContent());
        $this->assertEquals('["hola"]', ($this->response->getContent()));
    }
}
