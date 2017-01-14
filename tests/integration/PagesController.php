<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PagesController extends TestCase
{
    /**
     * test home page link
     *
     * @test
     */
    public function navigate_to_home_page()
    {
        $this->call('GET', '/');
        $this->assertResponseStatus(200);
    }
}
