<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuHeader extends Model
{
    protected $table = 'bkl_menu_header';

    protected $fillable = [
        'name',
        'slug',
        'status',
    ];

    public function metaContents()
    {
        return $this->hasOne(Meta::class, 'menu_id');
    }
}
