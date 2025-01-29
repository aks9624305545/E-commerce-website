<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public $name = 'Categories';
    public function __construct()
    {
        
    }

    public function showCategories(){
        $pageName = $this->name;
        return view('categories.showCategories',compact('pageName'));
    }

    public function addCategories(){
        
    }

    public function editCategories(){
        
    }

    public function updateCategories(){
        
    }

    public function deleteCategories(){

    }
}
