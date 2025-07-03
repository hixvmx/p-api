<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'type', 'price'];


    //if product is a variable product, it can have many variations.
    public function variations()
    {
        return $this->hasMany(Variation::class);
    }
}
