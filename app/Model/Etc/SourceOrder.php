<?php

namespace App\Model\Etc;

use App\Config;
use Illuminate\Database\Eloquent\SoftDeletes;

class SourceOrder extends Config
{
    use SoftDeletes;
    protected $table = 'fresh_source_order';
}
