<?php

namespace App\Model\MasterData;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'master_item';

    public function uom()
    {
        return $this->belongsTo(Uom::class);
    }
}
