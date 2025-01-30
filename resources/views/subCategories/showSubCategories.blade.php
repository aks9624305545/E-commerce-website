<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sub Categories') }}
        </h2>
    </x-slot>
    @include('message.flashMessage')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="d-grid gap-2 justify-content-md-end mb-2">
                <a href="{{route('addUpdateSubCategories')}}" class="btn btn-primary me-md-2" type="button">Add Sub Categories</a>
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
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="table table-bordered data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Category Name</th>
                                <th>Sub Category Name</th>
                                <th>Sub Category Images</th>
                                <th>Sub Category Description</th>
                                <th width="100px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script type="text/javascript">
    $(function() {

        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('getSubCategories') }}",
                data: function(d) {
                    d.category_id = $('select[name="category_id"]').val();
                }
            },
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'category_name',
                    name: 'category_name'
                },
                {
                    data: 'sub_category_name',
                    name: 'sub_category_name'
                },
                {
                    data: 'images',
                    name: 'images'
                },
                {
                    data: 'sub_category_description',
                    name: 'sub_category_description'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });

        $('select[name="category_id"]').on('change', function() {
            table.ajax.reload();
        });

    });

    function confirmDelete(id) {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ url('deleteSubCategories') }}/" + id;
            }
        });
    }
</script>