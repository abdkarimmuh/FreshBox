<?php

namespace App\Model\MasterData;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $table = 'master_warehouse';
    protected $fillable = ['name', 'address', 'created_at', 'updated_at'];
}
