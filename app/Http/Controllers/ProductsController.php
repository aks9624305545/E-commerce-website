<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductsRequest;
use App\Services\SubCategoriesServices;
use App\Services\ProductsServices;
use App\Services\CategoriesServices;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;

class ProductsController extends Controller
{
    public $name = 'Products';
    public $productsServices;
    public $subCategoriesServices;
    public $categoriesServices;
    public function __construct(ProductsServices $productsServices, SubCategoriesServices $subCategoriesServices, CategoriesServices $categoriesServices)
    {
        $this->subCategoriesServices = $subCategoriesServices;
        $this->categoriesServices = $categoriesServices;
        $this->productsServices = $productsServices;
    }

    public function showProducts()
    {
        try {
            $pageName = $this->name;
            return view('products.showProducts', compact('pageName'));
        } catch (\Exception $e) {
            Log::error('Error displaying products page: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong while loading the products page.');
        }
    }

    public function addUpdateProducts(Request $request)
    {
        try {
            $addOrUpdate = 'Add';
            $getSubCategories = $this->subCategoriesServices->getSubCategories();
            if (!empty($request->id)) {
                $addOrUpdate = 'Update';
                $getProductsData = $this->productsServices->getProductsById($request->id);
                return view('products.addUpdateProducts', compact('getProductsData', 'getSubCategories', 'addOrUpdate'));
            }
            return view('products.addUpdateProducts', compact('getSubCategories', 'addOrUpdate'));
        } catch (\Exception $e) {
            Log::error('Error fetching products data for edit: ' . $e->getMessage());
            return redirect()->route('products')->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function getProducts(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = $this->productsServices->getProducts();
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('images', function ($row) {
                        $productsImages = "<img src='" . asset('storage/products/' . $row->products_images) . "' alt='" . $row->products_name . "'>";
                        return $productsImages;
                    })
                    ->addColumn('category_name', function ($row) {
                        $categoryName = $row->subCategory->category->category_name;
                        return $categoryName;
                    })
                    ->addColumn('sub_category_name', function ($row) {
                        $subCategoryName = $row->subCategory->sub_category_name;
                        return $subCategoryName;
                    })
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="' . route('addUpdateProducts', ['id' => $row->id]) . '" class="edit btn btn-primary btn-sm">Edit</a>';
                        $deleteBtn = '<button onclick="confirmDelete(' . $row->id . ')" class="btn btn-danger btn-sm mt-2">Delete</button>';
                        return $btn . $deleteBtn;
                    })
                    ->rawColumns(['action', 'images', 'category_name', 'sub_category_name'])
                    ->make(true);
            }
            return view('products.showProducts');
        } catch (\Exception $e) {
            Log::error('Error fetching products for DataTables: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong while fetching products.');
        }
    }

    public function addProducts(ProductsRequest $ProductsRequest)
    {

        try {
            $addProducts = $this->productsServices->addProducts($ProductsRequest);

            if (!empty($addProducts)) {
                return redirect()->route('products')->with('success', 'Products added successfully.');
            } else {
                return redirect()->back()->with('error', 'Failed to add products.');
            }
        } catch (\Exception $e) {
            Log::error('Products addition failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong! Please try again.');
        }
    }

    public function editProducts() {}

    public function updateProducts(ProductsRequest $ProductsRequest)
    {
        try {
            $updatedProducts = $this->productsServices->updateProductsById($ProductsRequest);

            if ($updatedProducts) {
                return redirect()->route('products')->with('success', 'Products updated successfully.');
            } else {
                return redirect()->back()->with('error', 'Failed to update products.');
            }
        } catch (\Exception $e) {
            Log::error('Products update failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong! Please try again.');
        }
    }

    public function deleteProducts(Request $request)
    {
        try {
            $deleted = $this->productsServices->deleteProductsById($request->id);
            if ($deleted) {
                return redirect()->back()->with('success', 'Products deleted successfully.');
            } else {
                return redirect()->back()->with('error', 'Failed to delete products.');
            }
        } catch (\Exception $e) {
            Log::error('Products deletion failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong! Please try again.');
        }
    }
}
