<?php

use App\Models\Basket;
use App\Models\Currency;
use Illuminate\Support\Facades\Storage;
use App\Models\MediaFile;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\VariationImage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

if (!function_exists('uploadFile')) {
    /**
     * Handle file upload.
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @param  string  $destinationPath
     * @param  string  $disk
     * @return string|null
     */
    function uploadFile($file, $destinationPath, $disk = 'public')
    {
        if ($file && $file->isValid()) {
            // Generate a unique filename
            $filename = uniqid() . '-' . time() . '.' . $file->getClientOriginalExtension();

            // Store the file on the specified disk
            $path = $file->storeAs('images/' . $destinationPath, $filename, $disk);

            // Return the path of the uploaded file
            return str_replace('images/', '', $path);
        }

        return null;
    }
}
// if (!function_exists('uploadFiletoMedia')) {

//     function uploadFiletoMedia($file, $destinationPath, $disk = 'public')
//     {
//         if ($file && $file->isValid()) {
//             // Generate a unique filename
//             $filename = uniqid() . '-' . time() . '.' . $file->getClientOriginalExtension();

//             // Store the file on the specified disk
//             $path = $file->storeAs('images/' . $destinationPath, $filename, $disk);

//             // Prepare data for insertion
//             $mediaData = [
//                 'user_id'    => auth()->id() ?? 0, // Optional: Associate with logged-in user
//                 'name'       => $file->getClientOriginalName(),
//                 'alt'        => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME), // Optional alt text
//                 'folder_id'  => 0, // Set the appropriate folder ID if needed
//                 'mime_type'  => $file->getClientMimeType(),
//                 'size'       => $file->getSize(),
//                 'url'        => str_replace('images/', '', $path),
//                 'options'    => null, // Add any additional options or metadata
//                 'created_at' => now(),
//                 'updated_at' => now(),
//             ];

//             // Insert data into the database
//             $mediaId = MediaFile::insertGetId($mediaData);

//             // Return file information or media ID
//             return ['media_id' => $mediaId, 'file_path' => str_replace('images/', '', $path)];
//         }

//         return null;
//     }
// }


// if (!function_exists('deleteFilefromMedia')) {

//     function deleteFilefromMedia($id)
//     {

//         $media = MediaFile::where('id',$id)->first();

//         if ($media) {
//             if ($media->url && Storage::disk('public')->exists('images/'.$media->url)) {

//                 Storage::disk('public')->delete('images/'.$media->url);
//             }
//         }

//         return null;
//     }
// }



if (!function_exists('deleteFile')) {
    /**
     * Delete a file from storage.
     *
     * @param  string  $filePath
     * @param  string  $disk
     * @return bool
     */
    function deleteFile($filePath, $disk = 'public')
    {
        if ($filePath && Storage::disk($disk)->exists('images/' . $filePath)) {
            // Delete the file
            return Storage::disk($disk)->delete('images/' . $filePath);
        }

        return false;
    }
}

function stringify($content): string|null
{
    if (empty($content)) {
        return null;
    }

    if (is_string($content) || is_numeric($content) || is_bool($content)) {
        return $content;
    }

    if (is_array($content)) {
        return json_encode($content);
    }

    return null;
}


if (!function_exists('clean')) {
    function clean($dirty, $config = null)
    {
        return $dirty;
    }
}


if (!function_exists('shorten_price')) {
    function shorten_price($price)
    {
        if ($price >= 10000000) {
            return '₹' . number_format($price / 10000000, 2) . ' Cr';
        } elseif ($price >= 100000) {
            return '₹' . number_format($price / 100000, 2) . ' L';
        } elseif ($price >= 1000) {
            return '₹' . number_format($price / 1000, 2) . ' K';
        } else {
            return '₹' . number_format($price, 2);
        }
    }
}


if (!function_exists('dateTimeFormat')) {

    function dateTimeFormat($date)
    {
        $date = date('d M,Y', strtotime($date));
        $time = date('h:i a', strtotime($date));
        return  $date . '<br>' . $time;
    }
}

if (!function_exists('dateFormat')) {

    function dateFormat($date)
    {
        $date = date('d M,Y', strtotime($date));
        return  $date;
    }
}

function product_images($product_id)
{
    // $picture = VariationImage::leftJoin('product_images','variation_images.product_id','product_images.product_id')
    //                         ->where('product_images.product_id', $product_id)
    //                         ->where('product_images.type','<>','Nutritional Facts')
    //                         ->select('product_images.image', 'variation_id', 'product_images.type')
    //                         ->orderByRaw("CASE WHEN type = 'Main Image' THEN 0 ELSE 1 END, type ASC")
    //                         ->get();

    $picture = ProductImage::leftJoin('variation_images', 'variation_images.picture_id', 'product_images.id')
        ->where('product_images.product_id', $product_id)
        ->select('product_images.image', 'variation_id', 'product_images.type')
        ->orderByRaw("CASE WHEN type = 'Main Image' THEN 0 ELSE 1 END, type ASC")
        ->get();

    // Initialize an empty array to store the grouped data
    $groupedData = [];

    foreach ($picture as $item) {
        $variation_id = $item->variation_id;

        // If the variation_id doesn't exist in the groupedData array, create a new array for it
        if (!isset($groupedData[$variation_id])) {
            $groupedData[$variation_id] = [];
        }

        if (in_array($item->picture, $groupedData[$variation_id])) {
        } else {
            // Store the picture data in the corresponding variation_id array
            $groupedData[$variation_id][] = $item->image;
        }
    }

    return $groupedData;
}


function imageExisted($imagePath)
{
    if (File::exists(public_path($imagePath))) {
        $imageUrl = asset($imagePath);
    } else {
        $defaultImagePath = "/assets/images/9.png";
        $imageUrl = asset($defaultImagePath);
    }


    return $imageUrl;
}

function min_price($product_id)
{

    $minimumPrice = ProductVariant::where('product_id', $product_id)->min('price');
    return getPrice($minimumPrice);
}

function getPrice($value = 0, $decimal = 2)
{
    return '₹ ' . number_format($value, $decimal);
}

if (!function_exists('getVariants')) {

    function getVariants($opt = [], $idx = 0, $prefix = null)
    {

        $string = '';

        if (isset($opt[$idx])) {
            foreach ($opt[$idx]['values'] as $item) {
                if (isset($opt[$idx + 1])) {
                    $string .= getVariants($opt, $idx + 1, $prefix . ($idx === 0 ? '' : ',') . $opt[$idx]['name'] . ':' . $item);
                } else {
                    $string .= $prefix . ($idx === 0 ? '' : ',') . $opt[$idx]['name'] . ':' . $item . "\n";
                }
            }
        } else {
            return false;
        }

        return $string;
    }


    function basketItems()
    {
        $randomString = Str::random(45);

        if (session()->has('session_string')) {
            $session_string = session('session_string');
        } else {
            $session_string = $randomString;
        }

        $basketItem = Basket::where('session', $session_string)->where('status', 0)->first();

        if (!$basketItem) {
            $basketCount = 0;
        } else {
            $basketCount = $basketItem->items->count();
        }

        return $basketCount;
    }


    function productVariationName($baseName, $color)
    {
        $parts = explode('Women', $baseName);

        $rest = isset($parts[1]) ? $parts[1] : ''; // 'Casual Slides'

        return ucfirst(strtolower('Women' . ' ' . ucfirst($color) . ' ' . $rest));
    }
}
