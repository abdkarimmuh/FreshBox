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
                            if (isset($column[$searchTerm])) {
                                $query->where($key, 'like', '%' . $searchValue . '%');
                            }
                            $first = false;
                        } else {
                            if ($column[$searchTerm]) {
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
