<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meta extends Model
{
    protected $table = 'bkl_meta_contents';

    protected $fillable = [
        'menu_id',
        'meta_title',
        'meta_keywords',
        'meta_description',
    ];

    public function menu()
    {
        return $this->belongsTo(MenuHeader::class, 'menu_id');
    }
}
