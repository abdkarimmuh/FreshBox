<?php
if (!function_exists('create')) {
    function create($model, $fields)
    {
        $model = new $model();
        foreach ($fields as $field) {
            $model->$field = request($field);
        }
        $model->created_by = auth()->user()->id;
        return $model->save();
    }
}

if (!function_exists('capitalize')) {
    function capitalize($value)
    {
        return ucwords(str_replace(['-', '_'], ' ', $value));
    }
}


