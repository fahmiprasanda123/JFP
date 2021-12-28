<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPajak extends Model
{
    protected $guarded = [];
    use HasFactory;

    public function Item(){
        return $this->belongsTo(Item::class , 'id');
    }

    public function Pajak(){
        return $this->belongsTo(Pajak::class , 'id');
    }
}
