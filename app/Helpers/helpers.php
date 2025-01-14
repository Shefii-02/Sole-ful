<?php

use App\Models\Currency;
use Illuminate\Support\Facades\Storage;
use App\Models\MediaFile;

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
if (!function_exists('uploadFiletoMedia')) {

    function uploadFiletoMedia($file, $destinationPath, $disk = 'public')
    {
        if ($file && $file->isValid()) {
            // Generate a unique filename
            $filename = uniqid() . '-' . time() . '.' . $file->getClientOriginalExtension();

            // Store the file on the specified disk
            $path = $file->storeAs('images/' . $destinationPath, $filename, $disk);

            // Prepare data for insertion
            $mediaData = [
                'user_id'    => auth()->id() ?? 0, // Optional: Associate with logged-in user
                'name'       => $file->getClientOriginalName(),
                'alt'        => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME), // Optional alt text
                'folder_id'  => 0, // Set the appropriate folder ID if needed
                'mime_type'  => $file->getClientMimeType(),
                'size'       => $file->getSize(),
                'url'        => str_replace('images/', '', $path),
                'options'    => null, // Add any additional options or metadata
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Insert data into the database
            $mediaId = MediaFile::insertGetId($mediaData);

            // Return file information or media ID
            return ['media_id' => $mediaId, 'file_path' => str_replace('images/', '', $path)];
        }

        return null;
    }
}


if (!function_exists('deleteFilefromMedia')) {

    function deleteFilefromMedia($id)
    {

        $media = MediaFile::where('id',$id)->first();
        
        if ($media) {
            if ($media->url && Storage::disk('public')->exists('images/'.$media->url)) {
     
                Storage::disk('public')->delete('images/'.$media->url);
            }
        }

        return null;
    }
}



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
        if ($filePath && Storage::disk($disk)->exists('images/'.$filePath)) {
            // Delete the file
            return Storage::disk($disk)->delete('images/'.$filePath);
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



if (! function_exists('format_price')) {
    function format_price(
        float|null|string $price,
        Currency|null|string $currency = null,
        bool $withoutCurrency = false,
        bool $useSymbol = true,
        bool $fullNumber = false
    ): string {
        if ($currency) {
            if (! $currency instanceof Currency) {
                $currency = Currency::query()->find($currency);
            }

            if (! $currency) {
                return human_price_text($price, $currency, fullNumber: $fullNumber);
            }

            if ($currency->getKey() != get_application_currency_id() && $currency->exchange_rate > 0) {
                $currentCurrency = get_application_currency();

                if ($currentCurrency->is_default) {
                    $price = $price / $currency->exchange_rate;
                } else {
                    $price = $price / $currency->exchange_rate * $currentCurrency->exchange_rate;
                }

                $currency = $currentCurrency;
            }
        } else {
            $currency = get_application_currency();

            if (! $currency) {
                return human_price_text($price, $currency);
            }

            if (! $currency->is_default && $currency->exchange_rate > 0) {
                $price = $price * $currency->exchange_rate;
            }
        }

        if ($withoutCurrency) {
            return (string)$price;
        }

        if ($useSymbol && $currency->is_prefix_symbol) {
            $space = setting('real_estate_add_space_between_price_and_currency', 0) == 1 ? ' ' : null;

            return $currency->symbol . $space . human_price_text($price, $currency, fullNumber: $fullNumber);
        }

        return human_price_text($price, $currency, ($useSymbol ? $currency->symbol : $currency->title), fullNumber: $fullNumber);
    }
}

if (! function_exists('human_price_text')) {
    function human_price_text(float|null|string $price, Currency|null|string $currency, string|null $priceUnit = '', bool $fullNumber = false): string
    {
        $numberAfterDot = ($currency instanceof Currency) ? $currency->decimals : 0;

        if (! $fullNumber) {
            if ($price >= 1000000 && $price < 1000000000) {
                $price = round($price / 1000000, 2) + 0;
                $priceUnit = __('Million') . ' ' . $priceUnit;
                $numberAfterDot = strlen(substr(strrchr((string)$price, '.'), 1));
            } elseif ($price >= 1000000000) {
                $price = round($price / 1000000000, 2) + 0;
                $priceUnit = __('Billion') . ' ' . $priceUnit;
                $numberAfterDot = strlen(substr(strrchr((string)$price, '.'), 1));
            }
        }

        if (is_numeric($price)) {
            $price = preg_replace('/[^0-9,.]/s', '', (string)$price);
        }

        $decimalSeparator = setting('real_estate_decimal_separator', '.');

        if ($decimalSeparator == 'space') {
            $decimalSeparator = ' ';
        }

        $thousandSeparator = setting('real_estate_thousands_separator', ',');

        if ($thousandSeparator == 'space') {
            $thousandSeparator = ' ';
        }

        $price = number_format(
            (float)$price,
            (int)$numberAfterDot,
            $decimalSeparator,
            $thousandSeparator
        );

        $space = setting('real_estate_add_space_between_price_and_currency', 0) == 1 ? ' ' : null;

        return $price . $space . ($priceUnit ?: '');
    }
}

if (!function_exists('setting')) {
    /**
     * Retrieve application setting by key.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function setting(string $key, $default = null)
    {
        // Example: Assume settings are stored in a cached configuration or database
        $settings = [
            'real_estate_decimal_separator' => '.',
            'real_estate_thousands_separator' => ',',
            'real_estate_add_space_between_price_and_currency' => 1,
        ];

        return $settings[$key] ?? $default;
    }
}


if (!function_exists('dateTimeFormat')) {

    function dateTimeFormat($date)
    {
        $date = date('d M,Y',strtotime($date));
        $time = date('h:i a',strtotime($date));
        return  $date . '<br>' . $time ;
    }
}

if (!function_exists('dateFormat')) {

    function dateFormat($date)
    {
        $date = date('d M,Y',strtotime($date));
        return  $date;
    }
}


if (!function_exists('getVariants')) {

    function getVariants($opt = [], $idx = 0, $prefix = null) {
    
        $string = '';
        
        if(isset($opt[$idx])) {                                            
            foreach($opt[$idx]['values'] as $item) {
                if(isset($opt[$idx+1])) {
                    $string .= getVariants($opt, $idx+1, $prefix . ($idx === 0 ? '':',') . $opt[$idx]['name'] . ':' . $item);
                }   
                else {
                    $string .= $prefix . ($idx === 0 ? '':',') . $opt[$idx]['name'] . ':' . $item . "\n";
                }
            
            }
        }
        else {
            return false;
        }
        
        return $string;
        
    }    
}

