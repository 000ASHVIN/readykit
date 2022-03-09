<?php


namespace App\Helpers\App\General;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class UploadImage
{
    public static function upload($folder, $image) {
        try {
            $destination_path = "public/images/{$folder}/";
            
            $image_name = "reading_" . Carbon::now()->format('YmdHs') . "." . $image->getClientOriginalExtension();
            $img = Image::make($image->path());
            $img->resize(350, 350, function ($constraint) {
                $constraint->aspectRatio();
            });
            // $img->resize(350, 350);
            $img->stream();
            // ->save(storage_path($destination_path . $image_name) );
            Storage::disk('local')->put($destination_path . $image_name, $img, 'public');

            return $image_name;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}