<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\User;
use App\Hotelier;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
class UsersTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * @return void
     * @test
     */
    public function a_user_can_register_as_hotelier() {
        $request = Request::create('/api/register', 'POST',[
            'email'     =>     'unit@test.com',
            'password'     =>     '123456',
            'type'  => 'hotelier'
        ]);

        $authController = new AuthController();
        $response = $authController->register($request);
        $this->assertEquals(201, $response->status());
        
        $this->assertEquals('App\\Hotelier created', $response->getData()->message);

        $response = $authController->login($request);

        $this->assertEquals('App\\Hotelier', $response->getData()->user_type);
    }

    /**
     * @return void
     * @test
     */
    public function a_user_can_register_as_customer() {
        $request = Request::create('/api/register', 'POST',[
            'email'     =>     'unit@test.com',
            'password'     =>     '123456',
            'type'  => 'customer'
        ]);

        $authController = new AuthController();
        $response = $authController->register($request);
        $this->assertEquals(201, $response->status());
        
        $this->assertEquals('App\\Customer created', $response->getData()->message);

        $response = $authController->login($request);

        $this->assertEquals('App\\Customer', $response->getData()->user_type);
    }
}