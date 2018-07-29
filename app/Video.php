<?php

namespace App;

use Cviebrock\EloquentTaggable\Taggable;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use Taggable;

    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

}
