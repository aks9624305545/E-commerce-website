<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public $name = 'Products';
    public function __construct()
    {
        
    }
    
    public function showProducts(){
        $pageName = $this->name;
        return view('products.showProducts',compact('pageName'));
    }

    public function addProducts(){
        
    }

    public function editProducts(){
        
    }

    public function updateProducts(){
        
    }

    public function deleteProducts(){

    }
}
