<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterItemCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'nama',
        'harga_beli',
        'laba',
        'supplier',
        'jenis'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'master_item_categories')
                    ->withTimestamps();
    }
}
