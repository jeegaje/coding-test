<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'nama',
        'deskripsi',
        'is_active'
    ];

    public function masterItems()
    {
        return $this->belongsToMany(MasterItem::class, 'master_item_categories')
                    ->withTimestamps();
    }
}
