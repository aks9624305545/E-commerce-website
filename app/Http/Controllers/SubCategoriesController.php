<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SubCategoriesRequest;
use App\Services\SubCategoriesServices;
use App\Services\CategoriesServices;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;

class SubCategoriesController extends Controller
{
    public $name = 'Sub Categories';
    public $subCategoriesServices;
    public $categoriesServices;
    public function __construct(SubCategoriesServices $subCategoriesServices, CategoriesServices $categoriesServices)
    {
        $this->subCategoriesServices = $subCategoriesServices;
        $this->categoriesServices = $categoriesServices;
    }

    public function showSubCategories()
    {
        try {
            $pageName = $this->name;
            $getCategories = $this->categoriesServices->getCategories();
            return view('subCategories.showSubCategories', compact('pageName', 'getCategories'));
        } catch (\Exception $e) {
            Log::error('Error displaying sub categories page: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong while loading the sub categories page.');
        }
    }

    public function addUpdateSubCategories(Request $request)
    {
        try {
            $addOrUpdate = 'Add';
            $getCategories = $this->categoriesServices->getCategories();
            if (!empty($request->id)) {
                $addOrUpdate = 'Update';
                $getSubCategoryData = $this->subCategoriesServices->getSubCategoriesById($request->id);
                return view('subCategories.addUpdateSubCategories', compact('getSubCategoryData', 'getCategories', 'addOrUpdate'));
            }
            return view('subCategories.addUpdateSubCategories', compact('getCategories', 'addOrUpdate'));
        } catch (\Exception $e) {
            Log::error('Error fetching category data for edit: ' . $e->getMessage());
            return redirect()->route('subCategories')->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function getSubCategories(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = $this->subCategoriesServices->getSubCategories($request);
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('images', function ($row) {
                        $subCategoryImages = "<img src='" . asset('storage/sub_categories/' . $row->sub_category_images) . "' alt='" . $row->sub_category_name . "'>";
                        return $subCategoryImages;
                    })
                    ->addColumn('category_name', function ($row) {
                        $categoryName = $row->category->category_name;
                        return $categoryName;
                    })
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="' . route('addUpdateSubCategories', ['id' => $row->id]) . '" class="edit btn btn-primary btn-sm">Edit</a>';
                        $deleteBtn = '<button onclick="confirmDelete(' . $row->id . ')" class="btn btn-danger btn-sm mt-2">Delete</button>';
                        return $btn . $deleteBtn;
                    })
                    ->rawColumns(['action', 'images', 'category_name'])
                    ->make(true);
            }
            return view('subCategories.showSubCategories');
        } catch (\Exception $e) {
            Log::error('Error fetching sub categories for DataTables: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong while fetching sub categories.');
        }
    }

    public function addSubCategories(SubCategoriesRequest $SubCategoriesRequest)
    {

        try {
            $addSubCategory = $this->subCategoriesServices->addSubCategories($SubCategoriesRequest);

            if (!empty($addSubCategory)) {
                return redirect()->route('subCategories')->with('success', 'Sub Category added successfully.');
            } else {
                return redirect()->back()->with('error', 'Failed to add sub category.');
            }
        } catch (\Exception $e) {
            Log::error('Sub Category addition failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong! Please try again.');
        }
    }

    public function editSubCategories() {}

    public function updateSubCategories(SubCategoriesRequest $CategoriesRequest)
    {
        try {
            $updatedSubCategory = $this->subCategoriesServices->updateSubCategoriesById($CategoriesRequest);

            if ($updatedSubCategory) {
                return redirect()->route('subCategories')->with('success', 'Sub Category updated successfully.');
            } else {
                return redirect()->back()->with('error', 'Failed to update sub category.');
            }
        } catch (\Exception $e) {
            Log::error('Sub Category update failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong! Please try again.');
        }
    }

    public function deleteSubCategories(Request $request)
    {
        try {
            $deleted = $this->subCategoriesServices->deleteSubCategoriesById($request->id);
            if ($deleted) {
                return redirect()->back()->with('success', 'Sub Category deleted successfully.');
            } else {
                return redirect()->back()->with('error', 'Failed to delete sub category.');
            }
        } catch (\Exception $e) {
            Log::error('Sub Category deletion failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong! Please try again.');
        }
    }
}
