<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class ProductRepository
{
    public const TABLE = 'products';

    public function getProductOfCatgory ($id, $paginate = null, $orderBy = null, $idAtv = null) {
        $result = DB::table($this::TABLE)
        ->where([
            'pro_category_id' => $id,
            'pro_status'       => 1
        ]);
        
        if (!empty($orderBy)) {
            switch ($orderBy) {
                case 'd1t':
                    $result->where('pro_price','<',1000000);
                    break;
                case '1t-10t':
                    $result->whereBetween('pro_price',[1000000,10000000]);
                    break;
                case '10t-20t':
                    $result->whereBetween('pro_price',[10000000,20000000]);
                    break;
                case '20t-50t':
                    $result->whereBetween('pro_price',[20000000,50000000]);
                break;
                case 't50t':
                    $result->where('pro_price','>',50000000);
                break;
                case 'az':
                    $result->orderBy('pro_name','ASC');
                    break;
                case 'za':
                    $result->orderBy('pro_name','DESC');
                    break;
                case 'mn':
                    $result->orderBy('created_at','DESC');
                    break;
                case 'cn':
                    $result->orderBy('created_at','ASC');
                    break;
                case 'td':
                    $result->orderBy('pro_price','ASC');
                    break;
                case 'gd':
                    $result->orderBy('pro_price','DESC');
                    break;
                default:
                    dd("Lỗi");
                    break;
            }
        }

        if (!empty($idAtv)) {
            $result = $result->join('product_attribute', $this::TABLE . '.id', '=', 'product_attribute.pa_product_id')->where('product_attribute.pa_attribute_value_id', $idAtv);
        }

        if (!empty($paginate)) {
            $result = $result->paginate($paginate);
        } else {
            $result = $result->get();
        }

        return $result;
    }
}