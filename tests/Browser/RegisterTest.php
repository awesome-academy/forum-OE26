<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegisterTest extends DuskTestCase
{
    public function test_register_fail()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(env('APP_URL') . '/register')
                ->type('name', 'Vu Van Chuc')
                ->type('email', 'abc@email.com')
                ->type('password', 'aaa')
                ->type('password_confirmation', 'bbb')
                ->type('location', 'ccc')
                ->type('title', 'ddd')
                ->type('description', 'eee')
                ->press('Register')
                ->assertPathIs('/register');
        });
    }

    public function test_register_success()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(env('APP_URL') . '/register')
                ->type('name', 'aaa')
                ->type('email', 'bbb@email.com')
                ->type('password', 'password')
                ->type('password_confirmation', 'password')
                ->type('location', 'ccc')
                ->type('title', 'ddd')
                ->type('description', 'eee')
                ->press('Register')
                ->assertPathIs('/');
        });
    }
}
