<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Sub Categories') }}
        </h2>
    </x-slot>
    @include('message.flashMessage')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form action="{{ isset($getSubCategoryData) ? route('updateSubCategories', ['id' => $getSubCategoryData->id]) : route('addSubCategories') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Select Category Name</label>
                        <select class="form-select" name="category_id" aria-label="Default select example">
                            <option value="">Select Category Name</option>
                            @foreach($getCategories as $category)
                            <option value="{{ $category->id }}" 
                                {{ old('category_id', $getSubCategoryData->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                {{ $category->category_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="sub_category_name" class="form-label">Sub Category Name</label>
                        <input type="text" name="sub_category_name" class="form-control" id="sub_category_name"
                            placeholder="Sub Category Name" value="{{ old('sub_category_name', $getSubCategoryData->sub_category_name ?? '') }}">
                    </div>

                    <div class="mb-3">
                        <label for="sub_category_description" class="form-label">Sub Category Description</label>
                        <textarea name="sub_category_description" class="form-control" placeholder="Sub Category Description" id="sub_category_description" rows="3">{{ old('sub_category_description', $getSubCategoryData->sub_category_description ?? '') }}</textarea>
                    </div>

                    <div class="input-group mb-3">
                        <input type="file" class="form-control" name="sub_category_images" id="inputGroupFile04"
                            aria-describedby="inputGroupFileAddon04" aria-label="Upload">
                        @if(isset($getSubCategoryData) && $getSubCategoryData->sub_category_images)
                        <div class="mt-2">
                            <img src="{{ asset('storage/sub_categories/' . $getSubCategoryData->sub_category_images) }}" alt="{{ $getSubCategoryData->sub_category_name }}" width="100">
                        </div>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-secondary">Save</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>