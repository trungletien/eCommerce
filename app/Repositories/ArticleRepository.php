<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class ArticleRepository
{
    public const TABLE = 'articles';

    public function find($id)
    {
        $result = DB::table($this::TABLE)->where('id', $id)->first();
        
        return $result;
    }

    public function findByStatus($status, $paginate = null)
    {
        if (!empty($paginate)) {
            $result = DB::table($this::TABLE)->where('a_status', $status)->paginate($paginate);
        } else {
            $result = DB::table($this::TABLE)->where('a_status', $status)->get();
        }

        return $result;
    }

    public function getAll() {
        $result = DB::table($this::TABLE)->get();

        return $result;
    }

    public function getAnother($id, $limit = null) {
        $result = DB::table($this::TABLE)->where('id', '<>' ,$id)->limit(!empty($limit) ? $limit : -1)->get();

        return $result;
    }
}