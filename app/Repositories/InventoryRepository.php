<?php

namespace App\Repositories;

use App\Models\Inventory;
use App\Models\InventoryLog;
use App\Models\InventoryPhoto;
use Takaworx\Brix\Traits\RepositoryTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class InventoryRepository extends Inventory
{
    use RepositoryTrait;

    /**
     * DB table to be used for this repo
     *
     * @var string
     */
    protected $table = 'inventory';

    public function log($inventoryID, $amount, $isCredit = 0, $isSale = 1)
    {
        /**
         * @todo add is valid action check
         */
        return InventoryLog::create([
            'inventory_id' => $inventoryID,
            'action'       => $isCredit ? InventoryLog::TYPE_CREDIT : InventoryLog::TYPE_DEBIT,
            'amount'       => $amount,
            'is_sale'      => $isSale,
        ]);
    }

    public function storePhoto($inventoryID, $request, $isPrimary = true, $file = null)
    {
        if (is_null($file)) {
            $file = $request->photo;
        }

        $photoName = str_random(32) . ".{$file->extension()}";

        $fullPhotoPath  = $this->storeFullPhoto($photoName, $file);
        $thumbPhotoPath = $this->storeThumbPhoto($photoName);

        if ($isPrimary) {
            $isPrimary = 1;
        } else {
            $isPrimary = 0;
        }

        $inventoryPhoto = InventoryPhoto::create([
            'inventory_id' => $inventoryID,
            'is_primary' => $isPrimary,
            'file' => $photoName,
        ]);

        return $inventoryPhoto;
    }

    public function updatePhoto($oldInventoryPhoto, $request)
    {
        $file = $request->photo;

        $photoName = str_random(32) . ".{$file->extension()}";

        $fullPhotoPath  = $this->storeFullPhoto($photoName, $file);
        $thumbPhotoPath = $this->storeThumbPhoto($photoName);

        $inventoryPhoto = InventoryPhoto::find($oldInventoryPhoto->id);
        $inventoryPhoto->file = $photoName;
        $inventoryPhoto->save();

        $this->deletePhoto($oldInventoryPhoto);

        return $inventoryPhoto;
    }

    public function storeFullPhoto($photoName, $file)
    {
        $fullPhotoPath = $file->storeAs('img/rewards/full', $photoName, 'public');

        $img = Image::make(public_path("img/rewards/full/$photoName"));

        $img->resize(1024, 1024, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })
        ->save();

        return $fullPhotoPath;
    }

    public function storeThumbPhoto($photoName)
    {
        Storage::disk('public')->copy("img/rewards/full/$photoName", "img/rewards/thumb/$photoName");

        $thumbPhotoPath = public_path("img/rewards/thumb/$photoName");

        $img = Image::make($thumbPhotoPath);

        $img->resize(350, 350, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })
        ->save();
        
        return $thumbPhotoPath;
    }

    public function sortPhoto($inventory_id, $photo_id, $order)
    {
        $photo = InventoryPhoto::where('inventory_id', $inventory_id)
        ->where('id', $photo_id)
        ->first();

        $photo->order = $order;

        $photo->save();
    }

    public function deletePhotoFromDB($inventory_id, $photo_id)
    {
        $delete = InventoryPhoto::where('inventory_id', $inventory_id)
            ->where('id', $photo_id)
            ->delete();

        return true;
    }

    public function setPrimaryPhoto($inventory_id, $photo_id)
    {
        $oldPrimary = InventoryPhoto::where('inventory_id', $inventory_id)
            ->where('is_primary', 1)
            ->first();
        
        $oldPrimary->is_primary = 0;
        $oldPrimary->save();

        $newPrimary = InventoryPhoto::where('inventory_id', $inventory_id)
            ->where('id', $photo_id)
            ->first();

        $newPrimary->is_primary = 1;
        $newPrimary->save();

        return true;
    }

    public function deletePhoto($oldInventoryPhoto)
    {
        try {
            Storage::disk('public')->delete([
                public_path("img/rewards/full/{$oldInventoryPhoto->file}"),
                public_path("img/rewards/thumb/{$oldInventoryPhoto->file}"),
            ]);
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }
}
