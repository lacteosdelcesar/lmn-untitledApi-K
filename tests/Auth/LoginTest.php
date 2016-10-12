<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class LoginTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testauth()
    {
        $this->post('/api/user/autenticate', ['nombre' => 'admin', 'contrasena' => '123']);

        $this->assertEquals(
            $this->response->getContent(), $this->app->version()
        );
    }
}
