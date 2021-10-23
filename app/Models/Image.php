<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    //Ningun campo protegido
    protected $guarded = [];

    public function imageable(){
        return $this->morphTo();
    }
}
