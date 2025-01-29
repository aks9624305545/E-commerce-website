<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CategoriesRequest;
use App\Services\CategoriesServices;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;

class CategoriesController extends Controller
{
    public $name = 'Categories';
    public $categoriesServices;
    public function __construct(CategoriesServices $categoriesServices)
    {
        $this->categoriesServices = $categoriesServices;
    }

    public function showCategories()
    {
        try {
            $pageName = $this->name;
            return view('categories.showCategories', compact('pageName'));
        } catch (\Exception $e) {
            Log::error('Error displaying categories page: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong while loading the categories page.');
        }
    }

    public function addUpdateCategories(Request $request)
    {
        try {
            if (!empty($request->id)) {
                $getCategoryData = $this->categoriesServices->getCategoriesById($request->id);
                return view('categories.addUpdateCategories', compact('getCategoryData'));
            }
            return view('categories.addUpdateCategories');
        } catch (\Exception $e) {
            Log::error('Error fetching category data for edit: ' . $e->getMessage());
            return redirect()->route('categories')->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function getCategories(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = $this->categoriesServices->getCategories();
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('images', function ($row) {
                        $categoryImages = "<img src='" . asset('storage/categories/' . $row->category_images) . "' alt='" . $row->category_name . "'>";
                        return $categoryImages;
                    })
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="' . route('addUpdateCategories', ['id' => $row->id]) . '" class="edit btn btn-primary btn-sm">Edit</a>';
                        $deleteBtn = '<button onclick="confirmDelete(' . $row->id . ')" class="btn btn-danger btn-sm">Delete</button>';
                        return $btn . $deleteBtn;
                    })
                    ->rawColumns(['action', 'images'])
                    ->make(true);
            }
            return view('categories.showCategories');
        } catch (\Exception $e) {
            Log::error('Error fetching categories for DataTables: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong while fetching categories.');
        }
    }

    public function addCategories(CategoriesRequest $CategoriesRequest)
    {

        try {
            $addCategory = $this->categoriesServices->addCategories($CategoriesRequest);

            if (!empty($addCategory)) {
                return redirect()->route('categories')->with('success', 'Category added successfully.');
            } else {
                return redirect()->back()->with('error', 'Failed to add category.');
            }
        } catch (\Exception $e) {
            Log::error('Category addition failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong! Please try again.');
        }
    }

    public function editCategories() {}

    public function updateCategories(CategoriesRequest $CategoriesRequest)
    {
        try {
            $updatedCategory = $this->categoriesServices->updateCategoriesById($CategoriesRequest);

            if ($updatedCategory) {
                return redirect()->route('categories')->with('success', 'Category updated successfully.');
            } else {
                return redirect()->back()->with('error', 'Failed to update category.');
            }
        } catch (\Exception $e) {
            Log::error('Category update failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong! Please try again.');
        }
    }

    public function deleteCategories(Request $request)
    {
        try {
            $deleted = $this->categoriesServices->deleteCategoriesById($request->id);
            if ($deleted) {
                return redirect()->back()->with('success', 'Category deleted successfully.');
            } else {
                return redirect()->back()->with('error', 'Failed to delete category.');
            }
        } catch (\Exception $e) {
            Log::error('Category deletion failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong! Please try again.');
        }
    }
}
