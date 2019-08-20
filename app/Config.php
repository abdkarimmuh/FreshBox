<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    public function create_by()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function edit_by()
    {
        return $this->belongsTo(User::class, 'edited_by');
    }
}
