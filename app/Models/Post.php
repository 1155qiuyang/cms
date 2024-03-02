<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    

    protected $fileable = [
        
        'title',
        'content'

    ];

    public function user(){

        return $this->hasOne('App\Models\User');
    }

}
