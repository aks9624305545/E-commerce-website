<?php

namespace App\Services;

use App\Models\Products;
use App\Traits\FileUploadTrait;

class ProductsServices
{

    use FileUploadTrait;

    public function addProducts($ProductsRequest)
    {

        $imageName = $this->uploadFile($ProductsRequest->file('products_images'),'products');

        $dataArray = [
            'sub_category_id' => $ProductsRequest->sub_category_id,
            'products_name' => $ProductsRequest->products_name,
            'products_images' => $imageName,
            'products_description' => $ProductsRequest->products_description
        ];

        return Products::create($dataArray);
    }

    public function getProducts()
    {
        return Products::where('is_deleted', '0')->with('subCategory.category')->get();
    }

    public function getProductsById($id)
    {
        return Products::findOrFail($id);
    }

    public function deleteProductsById($id)
    {
        return Products::where('id', $id)->update(['is_deleted' => '1']);
    }

    public function updateProductsById($ProductsRequest)
    {
        if ($ProductsRequest->hasFile('products_images')) {
            $imageName = $this->uploadFile($ProductsRequest->file('products_images'),'products');
        } else {
            $products = $this->getProductsById($ProductsRequest->id);
            $imageName = $products->products_images;
        }

        $dataArrayUpdate = [
            'sub_category_id' => $ProductsRequest->sub_category_id,
            'products_name' => $ProductsRequest->products_name,
            'products_images' => $imageName,
            'products_description' => $ProductsRequest->products_description
        ];
        return Products::where('id', $ProductsRequest->id)->update($dataArrayUpdate);
    }
}
