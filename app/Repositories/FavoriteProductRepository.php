<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class FavoriteProductRepository
{
    public const TABLE = 'categories';

    public function getFavoriteProductOfUser($id)
    {
        $result = DB::table('favorite_product')->where('fp_user_id', $id);
    }
}
