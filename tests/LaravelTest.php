<?php
/**
 * Created by PhpStorm.
 * User: nyirendajr
 * Date: 4/13/20
 * Time: 2:03 AM
 */

namespace Thelabdevtz\MumProductModule\Tests;


use Orchestra\Testbench\TestCase;

class LaravelTest extends TestCase
{
    /** @test */
    public function the_route_can_be_accessed(){
        $this->get('/mum/products')->assertStatus(200);
    }
}