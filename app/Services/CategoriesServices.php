<?php

namespace App\Services;

use App\Models\Categories;
use App\Traits\FileUploadTrait;

class CategoriesServices
{

    use FileUploadTrait;

    public function addCategories($CategoriesRequest)
    {

        $imageName = $this->uploadFile($CategoriesRequest->file('category_images'));

        $dataArray = [
            'category_name' => $CategoriesRequest->category_name,
            'category_images' => $imageName,
            'category_description' => $CategoriesRequest->category_description
        ];

        return Categories::create($dataArray);
    }

    public function getCategories()
    {
        return Categories::where('is_deleted', '0')->get();
    }

    public function getCategoriesById($id)
    {
        return Categories::findOrFail($id);
    }

    public function deleteCategoriesById($id)
    {
        return Categories::where('id', $id)->update(['is_deleted' => '1']);
    }

    public function updateCategoriesById($CategoriesRequest)
    {
        if ($CategoriesRequest->hasFile('category_images')) {
            $imageName = $this->uploadFile($CategoriesRequest->file('category_images'));
        } else {
            $category = $this->getCategoriesById($CategoriesRequest->id);
            $imageName = $category->category_images;
        }

        $dataArrayUpdate = [
            'category_name' => $CategoriesRequest->category_name,
            'category_images' => $imageName,
            'category_description' => $CategoriesRequest->category_description
        ];
        return Categories::where('id', $CategoriesRequest->id)->update($dataArrayUpdate);
    }
}
