<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Models\Link;


class LinkController extends Controller
{
   public function store(Request $request)
   {
        $this->validate($request,[
            'url' => 'required|url',
        ], [
            'url.required' => 'Please enter a url to shorten.',
            'url.url' => 'Enter a valid url.',
        ]);

        $link = Link::firstOrNew([
            'original_url' => $request->get('url')
        ]);

        if(!$link->exists){
            $link->save();
        }

        $link->increment('requested_count');

        $link->touchTimestamp('last_requested');

        return $this->linkResponse($link);

    }

    public function show(Request $request)
    {
        $code = $request->get('code');

        $link = Cache::rememberForever("link.{$code}", function() use ($code) {
            return Link::byCode($code)->first();
        });

        if($link === null)
        {
            return response(null, 404);
        }

        $link->increment('used_count');

        $link->touchTimestamp('last_used');
        
        return $this->linkResponse($link);
        
    }

   

}
