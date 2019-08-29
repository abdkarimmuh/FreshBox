<?php


namespace App\Traits;

trait SearchTraits
{
    /**
     * Method to get a Vue Datatable Query
     */
    public function scopeDataTableQuery($query, $searchValue = '')
    {
        $columns = $this->columns;
//        $id = $this->primaryKey;
//
//        if (isset(array_keys($columns)[$column])) {
//            $query = $query->orderBy(array_keys($columns)[$column], $orderBy);
//        } else {
//            $defaultOrderBy = $id;
//            if (is_null($defaultOrderBy)) {
//                $defaultOrderBy = 'id';
//            }
//            $query = $query->orderBy($defaultOrderBy, $orderBy);
//        }

        if ($searchValue) {
            $query->where(function ($query) use ($searchValue, $columns) {

                $first = true;
                if (count($columns)) {
                    foreach ($columns as $key => $column) {
                        $searchTerm = config('laravel-vue-datatables.models.search_term');
                        if ($first) {
                            if (isset($column[$searchTerm]) && !$column['search_relation']) {
                                $query->where($key, 'like', '%' . $searchValue . '%');
                            }
                            $first = false;
                        } elseif ($column['search_relation'] && $column[$searchTerm]) {
                            $query->orWhereHas($column['relation_name'], function ($q) use($column,$searchValue) {
                                $q->where($column['relation_field'], 'like', '%' . $searchValue . '%');
                            });
                        } else {
                            if ($column[$searchTerm] && !$column['search_relation']) {
                                $query->orWhere($key, 'like', '%' . $searchValue . '%');
                            }
                        }
                    }
                }
            });
        }
        return $query;
    }
}
