<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $table = 'bkl_sections';

    protected $fillable = [
        'menu_id',
        'type',
        'order',
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }

    public function contents()
    {
        return $this->hasMany(SectionContent::class, 'section_id');
    }
}
