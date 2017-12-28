<?php


namespace App\Models\Traits\Eloquent;

trait TouchTimeStamps 
{
    public function touchTimestamp($column)
    {
        $this->{$column} = $this->freshTimestamp();
        $this->save();
    }
}