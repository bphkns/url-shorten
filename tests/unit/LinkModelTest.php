<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Models\Link;
use App\Exceptions\CodeGenerationException;

class LinkModeltest extends TestCase
{

    protected $mappings = [
        1 => 1,
        100 => '1C',
        100000 =>  "q0U",
        9999999999 => "aUKYOz"


    ];

    /**
     * @test 
     *
     * @return void
     */
    public function correct_code_is_generated()
    {
        $link = new Link();

        foreach ($this->mappings   as $id => $expectedCode) {
            $link->id = $id;
            $this->assertEquals($link->getCode(),$expectedCode);
        }
    }

    /**
     *  @test
     */

    public function exception_is_thrown_with_no_id()
    {
        $this->expectException(CodeGenerationException::class);
        
        $link = new Link();
        $link->getCode();
        
    }

    /**
     * @test
     */
    public function can_get_model_by_code()
    {
       $link =  factory(Link::class)->create([
           'code' => 'abc'
       ]);

       $model = $link->byCode($link->code)->first();

       $this->assertInstanceOf(Link::class, $model);

       $this->assertEquals($model->original_url, $link->original_url);
    }

    /**
     * @test
     */

    public function can_get_shortened_url_from_link_model()
    {
        $link =  factory(Link::class)->create([
            'code' => 'abc'
        ]);
        $this->assertEquals($link->shortenedUrl(), env('CLIENT_URL')."/".$link->code);
    }

    /**
     * @test
     */

    public function null_is_returned_for_shortend_url_when_no_code_is_present()
    {
        Link::flushEventListeners();

        $link = factory(Link::class)->create();

        $this->assertNull($link->shortenedUrl());
    }
}
