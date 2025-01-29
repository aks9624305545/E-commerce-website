<?php

namespace App\Services;

use App\Models\SubCategories;
use App\Traits\FileUploadTrait;

class SubCategoriesServices
{

    use FileUploadTrait;

    public function addSubCategories($SubCategoriesRequest)
    {

        $imageName = $this->uploadFile($SubCategoriesRequest->file('sub_category_images'),'sub_categories');

        $dataArray = [
            'category_id' => $SubCategoriesRequest->category_id,
            'sub_category_name' => $SubCategoriesRequest->sub_category_name,
            'sub_category_images' => $imageName,
            'sub_category_description' => $SubCategoriesRequest->sub_category_description
        ];

        return SubCategories::create($dataArray);
    }

    public function getSubCategories()
    {
        return SubCategories::where('is_deleted', '0')->with('category')->get();
    }

    public function getSubCategoriesById($id)
    {
        return SubCategories::findOrFail($id);
    }

    public function deleteSubCategoriesById($id)
    {
        return SubCategories::where('id', $id)->update(['is_deleted' => '1']);
    }

    public function updateSubCategoriesById($SubCategoriesRequest)
    {
        if ($SubCategoriesRequest->hasFile('sub_category_images')) {
            $imageName = $this->uploadFile($SubCategoriesRequest->file('sub_category_images'),'sub_categories');
        } else {
            $subCategory = $this->getSubCategoriesById($SubCategoriesRequest->id);
            $imageName = $subCategory->sub_category_images;
        }

        $dataArrayUpdate = [
            'category_id' => $SubCategoriesRequest->category_id,
            'sub_category_name' => $SubCategoriesRequest->sub_category_name,
            'sub_category_images' => $imageName,
            'sub_category_description' => $SubCategoriesRequest->sub_category_description
        ];
        return SubCategories::where('id', $SubCategoriesRequest->id)->update($dataArrayUpdate);
    }
}
