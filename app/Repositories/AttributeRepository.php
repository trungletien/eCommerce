<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class AttributeRepository
{
    public const TABLE = 'attributes';

    public function getValueOfAttribute($id)
    {
        $result = DB::table($this::TABLE)
        ->join('attribute_value', AttributeValueRepository::TABLE . '.atv_attribute_id', '=', $this::TABLE . '.id')
        ->where($this::TABLE . ('.id'), $id)->get();

        return $result;
    }
}