<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    // public $timestamps = false;
    protected $guarded = [];
    use HasFactory;

    public function DetailPajak(){
        return $this->belongsTo(DetailPajak::class , 'iditem');
    }
}
