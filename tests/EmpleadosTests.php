<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class EpleadosTests extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testShowall()
    {
        $this->get('/empleados/1065567198');

        $this->assertJsonStringEqualsJsonString(
            '[{"codigo":1065567198,"salario":"1218371"},{"codigo":1065567198,"salario":"2406413"}]',
            $this->response->getContent()
        );
    }
}
