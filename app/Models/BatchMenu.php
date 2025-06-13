<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BatchMenu extends Model
{
    //
    protected $table = "bkl_batch_menu";

    protected $guarded = [''];

    public $timestamps = true;

    public function batch(): BelongsTo
    {
        return $this->belongsTo(MasterBatch::class);
    }
}
