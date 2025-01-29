<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubCategoriesController extends Controller
{
    public $name = 'Sub Categories';
    public function __construct()
    {
        
    }
    
    public function showSubCategories(){
        $pageName = $this->name;
        return view('subCategories.showSubCategories',compact('pageName'));
    }

    public function addSubCategories(){
        
    }

    public function editSubCategories(){
        
    }

    public function updateSubCategories(){
        
    }

    public function deleteSubCategories(){

    }
}
