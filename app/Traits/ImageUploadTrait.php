<?php

namespace App\Traits;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait ImageUploadTrait
{
    public function uploadImage(Request $request, $imageName, $subPath)
    {
        if ($request->hasFile($imageName)) {
            $image = $request->{$imageName};
            $ext = $image->getClientOriginalExtension();
            $newImageName = 'media_' . uniqid() . '.' . $ext;
            $path = $image->storeAs("uploads/{$subPath}", $newImageName, 'public');
            return $path;
        }
    }

    public function updateImage(Request $request, $imageName, $oldPath = null, $subPath)
    {
        if ($request->hasFile($imageName)) {
            $this->deleteImage($oldPath);
            $image = $request->{$imageName};
            $ext = $image->getClientOriginalExtension();
            $newImageName = 'media_' . uniqid() . '.' . $ext;
            $path = $image->storeAs("uploads/{$subPath}", $newImageName, 'public');
            return $path;
        }
        return $oldPath;
    }

    public function deleteImage($path)
    {
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    public function uploadMultipleImage(Request $request, $imageName)
    {
        $imagePaths = [];
        if ($request->hasFile($imageName)) {
            $images = $request->{$imageName};
            foreach ($images as $image) {
                $ext = $image->getClientOriginalExtension();
                $newImageName = 'media_' . uniqid() . '.' . $ext;
                $path = $image->storeAs('uploads', $newImageName, 'public');
                $imagePaths[] = $path;
            }
            return $imagePaths;
        }
    }
}
