<?php

use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use League\Flysystem\FileNotFoundException as FileDownloadException;
use Illuminate\Contracts\Filesystem\FileNotFoundException as FileGetException;

if (!function_exists('unique_random')) {

  /**
   *
   * Generate a unique random string of characters
   * uses str_random() helper for generating the random string
   *
   * @param string $table - name of the table
   * @param string $col - name of the column that needs to be tested
   * @param string $prefix Any prefix you want to add to generated string
   * @param int $chars - length of the random string
   * @param bool $numeric Whether or not the generated characters should be numeric
   *
   * @return string
   */
  function unique_random($table, $col, $prefix = null, $chars = null, $numeric = false)
  {
    $unique = false;

    // Store tested results in array to not test them again
    $tested = [];

    do {

      // Generate random string of characters

      if ($chars == null) {
        if ($numeric) {
          $random = $prefix . rand(100001, 999999999);
        } else {
          $random = $prefix . Str::uuid();
        }
      } else {
        if ($numeric) {
          $random = $prefix . rand(substr(100000001, 1, ($chars)), substr(9999999999, - ($chars)));
        } else {
          $random = $prefix . Str::random($chars);
        }
      }

      // Check if it's already testing
      // If so, don't query the database again
      if (in_array($random, $tested)) {
        continue;
      }

      // Check if it is unique in the database
      $count = DB::table($table)->where($col, '=', $random)->count();

      // Store the random character in the tested array
      // To keep track which ones are already tested
      $tested[] = $random;

      // String appears to be unique
      if ($count == 0) {
        // Set unique to true to break the loop
        $unique = true;
      }

      // If unique is still false at this point
      // it will just repeat all the steps until
      // it has generated a random string of characters

    } while (!$unique);


    return $random;
  }
}

if (!function_exists('download_file')) {

  /**
   *
   * Generate a file download response
   * uses default filesystems disk
   *
   * @param     $file - The file to download
   * @param     $name_to_use - the name the user sees (optional)
   *
   * @return response
   */
  function download_file($file, $name_to_use = null)
  {
    try {
      return Storage::download($file, $name_to_use);
    } catch (FileGetException $e) {
      abort(404, "Requested file ({$e->getMessage()}) not found");
    } catch (FileDownloadException $e) {
      abort(404, $e->getMessage());
    }
  }
}

if (!function_exists('view_file_in_browser')) {

  /**
   *
   * Generate a url redirect response that enables browser to access the file directly
   * uses a custom filesystems disk that does not append app_url to the url method
   * Something like this
   *
   *      'browser_view' => [
   *          'driver' => 'local',
   *          'root' => storage_path('app/public'),
   *          'url' => '/storage',
   *          'visibility' => 'public',
   *      ],
   *
   * @param     $file - The file to download
   *
   *
   *
   * @return redirect response
   */
  function view_file_in_browser($file)
  {

    try {
      return redirect(Storage::disk('browser_view')->url($file));
    } catch (FileGetException $e) {
      abort(404, "Requested file ({$e->getMessage()}) not found");
    } catch (FileDownloadException $e) {
      abort(404, $e->getMessage());
    }
  }
}

if (!function_exists('slug_to_string')) {
  function slug_to_string($data)
  {
    return str_replace('-', ' ', $data);
  }
}

if (!function_exists('to_naira')) {
  /**
   * convert a number to naira with the naira symbol
   *
   * @param float $amount The amount to convert
   * @return string
   * @throws Exception when the amount supplied is not a number
   **/

  function to_naira($amount): string
  {
    if (!is_numeric($amount)) {
      throw new Exception("can only convert numbers to naira", 500);
    }
    return '₦' . number_format($amount, 2);
  }
}

if (!function_exists('generate_422_error')) {
  /**
   * Generate a 422 error in a format that axios and sweetalert 2 can display it
   *
   * @param  array|string  $errors An array of errors to display
   * @param  null|string  $url An optional url to redirect to
   * @return Response
   */
  function generate_422_error($error, $url = null)
  {
    $errors = $error;
    if (! is_array($error)) $errors = ['message' => $error];

    // if (request()->isApi()) return response()->json(['error' => 'form validation error', $errors], Response::HTTP_UNPROCESSABLE_ENTITY);
    throw ValidationException::withMessages($errors)
      ->redirectTo($url)
      ->status(Response::HTTP_UNPROCESSABLE_ENTITY);
  }
}

if (!function_exists('get_11_digit_nigerian_number')) {
  /**
   * convert a number from international standard to 11 digit number
   *
   * @param float $number The number to convert
   *
   * @return string
   **/

  function get_11_digit_nigerian_number(string $number): string
  {
    return '0' . mb_substr(preg_replace('/(\D+)/i', '', $number), -10);
  }
}

if (!function_exists('str_ordinal')) {
  /**
   * Append an ordinal indicator to a numeric value.
   *
   * @param  string|int $value
   * @param  bool $superscript
   * @return string
   */
  function str_ordinal($value, $superscript = false)
  {
    $number = abs($value);

    if (class_exists('NumberFormatter')) {
      $nf = new \NumberFormatter('en_US', \NumberFormatter::ORDINAL);
      $ordinalized = $superscript ?
        number_format($number) .
        '<sup>' .
        substr($nf->format($number), -2) .
        '</sup>' : $nf->format($number);

      return $ordinalized;
    }


    $indicators = ['th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th'];

    $suffix = $superscript ? '<sup>' . $indicators[$number % 10] . '</sup>' : $indicators[$number % 10];
    if ($number % 100 >= 11 && $number % 100 <= 13) {
      $suffix = $superscript ? '<sup>th</sup>' : 'th';
    }

    return number_format($number) . $suffix;
  }
}

if (!function_exists('uses_trait')) {
  function uses_trait($trait, $class): bool
  {
    return in_array($trait, class_uses_recursive($class));
  }
}

if (!function_exists('compress_image_upload')) {

  /**
   * Compress uploaded image files for better optimisation
   *
   * Uses the Intervention library to compress files into the specified size at 85% quality
   *  and optionally create thumbnail images and saves them in the paths provided
   * for the image and the thumbnail. The aspect ration can optionally be maintained
   * returns an array of file names.
   *
   * @param string $key The index name of the file field in the request object
   * @param string $save_path The path to save the compressed image
   * @param string $thumb_path The optional path to save the thumbnail. If provided, thumbnails will be generated
   * @param int $size The size to compress the image into. Defaults to 1400px
   * @param bool $constrain_aspect_ration Boolean value indication whether to constrain the aspect ratio on compression
   *
   * @package \Intervention\Image\Facades\Image
   *
   * composer require intervention/image
   *
   * compress_image_upload('img', 'product_models_images/', 'product_models_images/thumbs/', 800, true, 50)['img_url'],
   *
   * @return array
   **/

  function compress_image_upload(string $key, string $save_path, ?string $thumb_path = null, ?int $size = 1400, ?bool $constrain_aspect_ratio = true, ?int $thumb_size = 200)
  {
    // dd(public_path(Storage::url($save_path)));

    Storage::makeDirectory('public/' . $save_path, 0777);
    Storage::makeDirectory('public/' . $thumb_path, 0777);

    // if ($thumb_path && !File::isDirectory(Storage::url($thumb_path))) {
    //   File::makeDirectory(Storage::url($thumb_path), 0755);
    // }

    $image = Image::make(request()->file($key)->getRealPath());

    if ($constrain_aspect_ratio) {
      $image->resize($size, null, function ($constraint) {
        $constraint->aspectRatio();
        $constraint->upsize();
      })->save(public_path(Storage::url($save_path)) . request()->file($key)->hashName(), 85);

      $url = Storage::url($save_path) . request()->file($key)->hashName();

      if ($thumb_path) {
        $image->resize(null, $thumb_size, function ($constraint) {
          $constraint->aspectRatio();
          $constraint->upsize();
        })->save(public_path(Storage::url($thumb_path)) . request()->file($key)->hashName(), 70);

        $thumb_url = Storage::url($thumb_path) . request()->file($key)->hashName();

        return ['img_url' => $url, 'thumb_url' => $thumb_url];
      }
      return ['img_url' => $url];
    } else {
      $image->resize($size)->save(public_path(Storage::url($save_path)) . request()->file($key)->hashName(), 85);
      $url = Storage::url($save_path) . request()->file($key)->hashName();

      if ($thumb_path) {
        $image->resize($thumb_size)->save(public_path(Storage::url($thumb_path)) . request()->file($key)->hashName(), 70);
        $thumb_url = Storage::url($thumb_path) . request()->file($key)->hashName();

        return ['img_url' => $url, 'thumb_url' => $thumb_url];
      }

      return ['img_url' => $url];
    }
  }
}

if (!function_exists('get_directories')) {
  function get_directories($directory): array
  {
    // A hack. Downside, this will return filenames too ,but Modules only contains directories right?
    return array_filter(scandir($directory), fn($dir) => ! is_dir($dir) );

    /**
     * ! Ideally I should use this and the exclude the . and .. and - directories BUT WHO CARES
     */
    // return array_filter(scandir($directory), fn($dir) => is_dir($directory . DIRECTORY_SEPARATOR . $dir) );
  }
}

if (!function_exists('get_inertia_page_paths')) {
  function get_inertia_page_paths(): array
  {
    return collect(get_directories(app_path('Modules')))
    ->transform(
      fn($moduleName) => app_path('Modules') . DIRECTORY_SEPARATOR . $moduleName . DIRECTORY_SEPARATOR . 'Resources' . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'Pages'
    )->merge(resource_path('js/Pages'))->toArray();
  }
}

/**
 * Return the data for the extras defaults
 *
 * @param bool $navSkip
 * @param string $icon
 *
 * @return array
 */
function __e($name, $authorization, $icon = null, $sort_order, $nav_skip = false, $group = null, $group_order = null)
{
  return compact(['name', 'icon', 'nav_skip', 'authorization', 'group', 'sort_order', 'group_order']);
}
