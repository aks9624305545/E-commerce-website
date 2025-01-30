<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __($addOrUpdate . ' Products') }}
        </h2>
    </x-slot>
    
    @include('message.flashMessage')
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form action="{{ isset($getProductsData) ? route('updateProducts', ['id' => $getProductsData->id]) : route('addProducts') }}" 
                    method="post" enctype="multipart/form-data">
                    @csrf

                    <!-- Sub Category Selection -->
                    <div class="mb-3">
                        <label for="sub_category_id" class="form-label">Select Sub Category Name</label>
                        <select class="form-select" name="sub_category_id">
                            <option value="">Select Sub Category Name</option>
                            @foreach($getSubCategories as $subCategory)
                            <option value="{{ $subCategory->id }}" 
                                {{ old('sub_category_id', $getProductsData->sub_category_id ?? '') == $subCategory->id ? 'selected' : '' }}>
                                {{ $subCategory->sub_category_name }}
                            </option>
                            @endforeach
                        </select>
                        @error('sub_category_id')
                        <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Product Name -->
                    <div class="mb-3">
                        <label for="products_name" class="form-label">Products Name</label>
                        <input type="text" name="products_name" class="form-control" id="products_name"
                            placeholder="Products Name" value="{{ old('products_name', $getProductsData->products_name ?? '') }}">
                        @error('products_name')
                        <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Product Description -->
                    <div class="mb-3">
                        <label for="products_description" class="form-label">Products Description</label>
                        <textarea name="products_description" class="form-control" placeholder="Products Description" 
                            id="products_description" rows="3">{{ old('products_description', $getProductsData->products_description ?? '') }}</textarea>
                        @error('products_description')
                        <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Product Image Upload -->
                    <div class="input-group mb-3">
                        <input type="file" class="form-control" name="products_images" id="inputGroupFile04"
                            aria-describedby="inputGroupFileAddon04" aria-label="Upload">
                        @if(isset($getProductsData) && $getProductsData->products_images)
                        <div class="mt-2">
                            <img src="{{ asset('storage/products/' . $getProductsData->products_images) }}" 
                                alt="{{ $getProductsData->products_name }}" width="100">
                        </div>
                        @endif
                        @error('products_images')
                        <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-secondary">Save</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
