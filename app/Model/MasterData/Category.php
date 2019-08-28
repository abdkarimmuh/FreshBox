<?php

namespace App\Model\MasterData;

use App\MyModel;

class Category extends MyModel
{
    protected $table = 'master_category';
    protected $appends = [
        'created_by_name',
        'updated_by_name'
    ];
}
