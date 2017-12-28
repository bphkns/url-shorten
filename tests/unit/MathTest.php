<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class MathTest extends TestCase
{

    protected $mappings = [
        1 => 1,
        100 => '1C',
        100000 =>  "q0U",
        9999999999 => "aUKYOz"


    ];

    /**
     * @test A basic test example.
     *
     * @return void
     */
    public function corectly_encodes_values()
    {
        $math = new App\Helpers\Math();

        

        foreach ($this->mappings   as $value => $encoded) {
            $this->assertEquals($encoded, $math->toBase($value));
        }
    }
}
