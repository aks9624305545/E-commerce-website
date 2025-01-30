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

    public function getProducts($request)
    {
        $ProductsQuery = Products::where('is_deleted', '0')->with('subCategory.category');

        if (!empty($request->category_id)) {
            $ProductsQuery->whereHas('subCategory.category', function ($q) use ($request) {
                $q->where('id', $request->category_id);
            });
        }

        if (!empty($request->sub_category_id)) {
            $ProductsQuery->where('sub_category_id', $request->sub_category_id);
        }

        return $ProductsQuery->get();
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
