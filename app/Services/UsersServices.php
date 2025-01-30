<?php

namespace App\Services;

use App\Models\User;
use App\Traits\FileUploadTrait;

class UsersServices
{

    use FileUploadTrait;

    public function updateProfileImageByUsersId($Request)
    {

        if ($Request->hasFile('profile_image')) {
            $imageName = $this->uploadFile($Request->file('profile_image'),'profile_image');
        } else {
            $subCategory = $this->getUserById($Request->user()->id);
            $imageName = $subCategory->profile_image;
        }

        $dataArrayUpdate = [
            'profile_image' => $imageName
        ];
        return User::where('id', $Request->user()->id)->update($dataArrayUpdate);
    }

    public function getUserById($id)
    {
        return User::findOrFail($id);
    }

    public function UserVendorWise()
    {
        return User::where('is_vendor','0')->get();
    }

    public function deleteUsersById($id)
    {
        return User::where('id', $id)->update(['is_deleted' => '1']);
    }
}
