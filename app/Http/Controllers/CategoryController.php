<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Repositories\AttributeRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class CategoryController extends CustomerController
{
    private $categoryRepo;
    private $attributeRepo;
    private $productRepo;

    public function __construct(CategoryRepository $categoryRepo, AttributeRepository $attributeRepo, ProductRepository $productRepo)
    {
        parent::__construct($categoryRepo);
        $this->categoryRepo = $categoryRepo;
        $this->attributeRepo = $attributeRepo;
        $this->productRepo = $productRepo;
    }

    public function index($slugname, $id)
    {
        $checkLink = 0;
        $checkProduct = $this->productRepo->getProductOfCatgory($id)->count();
        $category = $this->categoryRepo->find($id);

        if ($checkProduct > 9) {
            $checkLink = 1;
            $products = $this->productRepo->getProductOfCatgory($id, 9);
        } else {
            $products = $this->productRepo->getProductOfCatgory($id);
        }

        $attributeOfCategory = $this->categoryRepo->getAttributesOfCategory($id);
        foreach($attributeOfCategory as $attribute) {
            $attribute->value = $this->attributeRepo->getValueOfAttribute($attribute->id);
        }
        
        $data =  [
            'category' => $category,
            'products' => $products,
            'checkLink' =>$checkLink,
            'attributeOfCategory' => $attributeOfCategory
        ];

        return view('customer.category.index',$data);
    }
    public function indexOrder($slugname, $id, $order)
    {
        $checkLink = 0;
        $checkproduct = $this->productRepo->getProductOfCatgory($id)->count();
        $category = $this->categoryRepo->find($id);
        $products = Product::where([
            'pro_category_id' =>$id,
            'pro_status'       => 1,
        ]);
        
        if ($checkproduct > 9) {
            $checkLink = 1;
            $products =$this->productRepo->getProductOfCatgory($id, 3, $order);
        } else {
            $products =$this->productRepo->getProductOfCatgory($id, null, $order);
        }

        $attributeOfCategory = $this->categoryRepo->getAttributesOfCategory($id);
        foreach($attributeOfCategory as $attribute) {
            $attribute->value = $this->attributeRepo->getValueOfAttribute($attribute->id);
        }

        $data =  [
            'category' => $category,
            'products' => $products,
            'checkLink' => $checkLink,
            'attributeOfCategory' => $attributeOfCategory
        ];
        return view('customer.category.index',$data);
    }

    public function indexOrderAttribute($slugname, $id, $idatv)
    {
        $checkLink = 0;
        $category = $this->categoryRepo->find($id);
        $products = $this->productRepo->getProductOfCatgory($id, null, null, $idatv);

        $attributeOfCategory = $this->categoryRepo->getAttributesOfCategory($id);
        foreach($attributeOfCategory as $attribute) {
            $attribute->value = $this->attributeRepo->getValueOfAttribute($attribute->id);
        }

        $data =  [
            'category' => $category,
            'products' => $products,
            'checkLink' => $checkLink,
            'attributeOfCategory' => $attributeOfCategory
        ];

        return view('customer.category.index',$data);
    }
}
