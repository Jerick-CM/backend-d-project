<?php

namespace App\Repositories;

use App\Models\Banner;
use Illuminate\Support\Facades\Storage;
use Takaworx\Brix\Traits\RepositoryTrait;

class BannerRepository extends Banner
{
    use RepositoryTrait;

    /**
     * DB table to be used for this repo
     *
     * @var string
     */
    protected $table = 'banners';

    public function uploadPhoto()
    {
        try {
            $request = request();

            $file = $request->file('photo');

            $photoName = str_random(32) . ".{$file->extension()}";

            $file->storeAs('img/banners', $photoName, 'public');
        } catch (\Exception $e) {
            return $e;
        }

        return $photoName;
    }

    public function updatePhoto()
    {
        try {
            $request = request();

            $photoName = $this->uploadPhoto();
    
            $deletePhoto = $this->deletePhoto($request->route('banner_id'));
    
            if ($deletePhoto instanceof \Exception) {
                throw $deletePhoto;
            }
        } catch (\Exception $e) {
            return $e;
        }

        return $photoName;
    }

    public function deletePhoto($banner_id)
    {
        try {
            $banner = $this->find($banner_id);

            Storage::disk('public')->delete("img/banners/{$banner->file}");
        } catch (\Exception $e) {
            return $e;
        }
        
        return true;
    }
}
