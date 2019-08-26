<?php

namespace App\Model\Etc;

use App\MyModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class SourceOrder extends MyModel
{
    use SoftDeletes;
    protected $table = 'master_source_order';
}
