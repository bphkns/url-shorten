<?php


namespace App\Observers;

use App\Models\Link;
use Carbon\Carbon;


class LinkObserver
{
    public function created(Link $link)
    {
        $link->update([
            'code' => $link->getCode(),
            'last_requested' => Carbon::now() ,
            
        ]);
    }

    
}