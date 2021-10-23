<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comentario;

class Plantas extends Model
{
    //use HasFactory;

    protected $fillable = ["nombre","altura","perene"];

    public function image(){
        return $this->morphOne('App\Models\Image','imageable');
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }

    public function  usuarios()
    {
        return $this->belongsToMany(User::class);
    }
}
