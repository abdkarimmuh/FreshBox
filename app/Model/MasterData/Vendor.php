<?php

namespace App\Model\MasterData;

use App\MyModel;
use App\Traits\SearchTraits;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends MyModel
{
    use SearchTraits;
    use SoftDeletes;

    protected $table = 'master_vendor';

    protected $fillable = ['name', 'category_id', 'pic_vendor', 'tlp_pic', 'bank_account', 'bank_id', 'ppn', 'pph', 'type_vendor', 'remarks', 'created_by', 'updated_by', 'created_at', 'updated_at'];

    protected $appends = ['created_by_name', 'updated_by_name', 'category_name', 'bank_name', 'type_vendor_html'];

    protected $columns = [
        'id' => [
            'searchable' => false,
            'search_relation' => false,
        ],
        'name' => [
            'searchable' => true,
            'search_relation' => false,
        ],
        'category_name' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'Category',
            'relation_field' => 'name',
        ],
        'bank_name' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'Bank',
            'relation_field' => 'name',
        ],
        'created_at' => [
            'searchable' => true,
            'search_relation' => false,
        ],
        'created_by_name' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'create_by',
            'relation_field' => 'name',
        ],
        'updated_by_name' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'update_by',
            'relation_field' => 'name',
        ],
    ];

    public function Category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getCategoryNameAttribute()
    {
        if (isset($this->Category->name)) {
            return $this->Category->name;
        } else {
            return '';
        }
    }

    public function getTypeVendorHtmlAttribute()
    {
        if ($this->status === 1) {
            return '<span class="badge badge-secondary">Employee</span>';
        } elseif ($this->status === 2) {
            return '<span class="badge badge-primary">Vendor</span>';
        } else {
            return 'Status NotFound';
        }
    }

    public function Bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function getBankNameAttribute()
    {
        if (isset($this->Bank->name)) {
            return $this->Bank->name;
        } else {
            return '';
        }
    }

    public function getColumns()
    {
        return $this->columns;
    }
}
