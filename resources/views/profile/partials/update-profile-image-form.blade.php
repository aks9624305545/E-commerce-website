<section>
    <style>
        h1 {
            font-size: 20px;
            text-align: center;
            margin: 20px 0 20px;
        }

        .avatar-upload {
            position: relative;
            max-width: 205px;
            margin: 50px auto;
        }

        .avatar-edit {
            position: absolute;
            right: 12px;
            z-index: 1;
            top: 10px;
        }

        .avatar-edit input {
            display: none;
        }

        .avatar-edit label {
            display: inline-block;
            width: 34px;
            height: 34px;
            margin-bottom: 0;
            border-radius: 100%;
            background: #FFFFFF;
            border: 1px solid transparent;
            box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
            cursor: pointer;
            transition: all .2s ease-in-out;
            text-align: center;
            line-height: 34px;
        }

        .avatar-edit label:hover {
            background: #f1f1f1;
            border-color: #d6d6d6;
        }

        .avatar-preview img {
            width: 192px;
            height: 192px;
            border-radius: 100%;
            border: 6px solid #F8F8F8;
            box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);
            object-fit: cover;
        }
    </style>

    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Image') }}
        </h2>
    </header>

    <form method="post" action="{{ route('profileImage') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf

        <div>
            <div class="avatar-upload">
                <div class="avatar-edit">
                    <input type="file" name="profile_image" id="imageUpload" accept=".png, .jpg, .jpeg" onchange="previewImage(event)"/>
                    <label for="imageUpload">📷</label>
                </div>
                <div class="avatar-preview">
                    <img id="imagePreview" src="{{ asset('storage/profile_image/'.$user->profile_image) }}" alt="Profile Image">
                </div>
            </div>
        </div>
        
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
        </div>
    </form>
</section>

<script>
    function previewImage(event) {
        let input = event.target;
        let preview = document.getElementById('imagePreview');
        if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
