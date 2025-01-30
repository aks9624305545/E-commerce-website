<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __($addOrUpdate . ' Categories') }}
        </h2>
    </x-slot>

    @include('message.flashMessage')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form action="{{ isset($getCategoryData) ? route('updateCategories', ['id' => $getCategoryData->id]) : route('addCategories') }}" 
                    method="post" enctype="multipart/form-data">
                    @csrf

                    <!-- Category Name -->
                    <div class="mb-3">
                        <label for="category_name" class="form-label">Category Name</label>
                        <input type="text" name="category_name" class="form-control" id="category_name"
                            placeholder="Category Name" value="{{ old('category_name', $getCategoryData->category_name ?? '') }}">
                        @error('category_name')
                        <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Category Description -->
                    <div class="mb-3">
                        <label for="category_description" class="form-label">Category Description</label>
                        <textarea name="category_description" class="form-control" placeholder="Category Description" 
                            id="category_description" rows="3">{{ old('category_description', $getCategoryData->category_description ?? '') }}</textarea>
                        @error('category_description')
                        <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Category Image Upload -->
                    <div class="input-group mb-3">
                        <input type="file" class="form-control" name="category_images" id="inputGroupFile04"
                            aria-describedby="inputGroupFileAddon04" aria-label="Upload">
                        @if(isset($getCategoryData) && $getCategoryData->category_images)
                        <div class="mt-2">
                            <img src="{{ asset('storage/categories/' . $getCategoryData->category_images) }}" 
                                alt="{{ $getCategoryData->category_name }}" width="100">
                        </div>
                        @endif
                        @error('category_images')
                        <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-secondary">Save</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
