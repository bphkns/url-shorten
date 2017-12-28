<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Models\Link;
use Illuminate\Http\Request;
use App\Http\Middleware\ModifiesUrlRequestData;


class UrlMiddlewareTest extends TestCase
{


    /**
     * @test 
     *
     * @return void
     */
    public function http_is_actually_prepended_to_url()
    {
        $request = new Request();

        
        $request->replace([
            'url' => 'google.com'
        ]);

        $middleware = new ModifiesUrlRequestData();

        $middleware->handle($request, function($req){
            $this->assertEquals('http://google.com', $req->get('url'));
        });
        
    }

    /**
     * @test 
     *
     * @return void
     */
    public function http_is_not_prepended_to_url_if_scheme_exists()
    {
        $request = new Request();

        $urls = [
            'ftp://google.com',
            'http://google.com',
            'https://google.com'
        ];
        
        foreach($urls as $url)
        {
            $request->replace([
                'url' => $url
            ]); 

        $middleware = new ModifiesUrlRequestData();

        $middleware->handle($request, function($req) use ($url){
            $this->assertEquals($url, $req->get('url'));
        });
        }

        

        
        
    }
}
