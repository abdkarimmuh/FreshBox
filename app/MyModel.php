<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MyModel extends Model
{
    public function create_by()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function update_by()
    {
        return $this->belongsTo(User::class, 'edited_by');
    }


    public function getCreatedByNameAttribute()
    {
        if (isset($this->create_by->name)) {
            return $this->create_by->name;
        } else {
            return '';
        }
    }

    function getUpdatedByNameAttribute()
    {
        if (isset($this->update_by->name)) {
            return $this->update_by->name;
        } else {
            return '';
        }
    }


}
