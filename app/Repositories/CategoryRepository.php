<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class CategoryRepository
{
    public const TABLE = 'categories';

    public function find($id)
    {
        $result = DB::table($this::TABLE)->where('id', $id)->first();
        
        return $result;
    }

    public function getAttributesOfCategory($id)
    {
        $result = DB::table($this::TABLE)
            ->join('category_attribute', $this::TABLE . '.id', '=', 'category_attribute.c_a_category_id')
            ->join('attributes', 'attributes.id', '=', 'category_attribute.c_a_attribute_id')
            ->where($this::TABLE . ('.id'), $id)
            ->get();

        return $result;
    }

    public function getAll() 
    {
        $result = DB::table($this::TABLE)->where('c_status', 1)->get();
        
        return $result;
    }
}