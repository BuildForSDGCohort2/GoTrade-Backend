<?php

use App\Models\Storagefiles;
use App\Models\ProductMedia;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * Generate slug for string.
 *
 * @param $string
 *
 * @return mixed|string|string[]|null
 */
function generateSlug($string)
{
    $string = strtolower(trim($string));
    $string = str_replace('-', ' ', $string);
    $string = preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
    $string = str_replace(' ', '-', $string);

    return $string;
}

/**
 * Upload and save files.
 * Returns attachment object.
 *
 * @param \Illuminate\Http\UploadedFile $attachment
 * @param $file
 * @param $fileType
 *
 * @return \Illuminate\Http\UploadedFile|null
 */
function uploadFile(\Illuminate\Http\UploadedFile $file, $fileType)
{
    try {
        $tempFileName = $file->getClientOriginalName();
        $fileName = generateSlug($tempFileName);
        $fileExtension = $file->getClientOriginalExtension();
        $fileMime = $file->getClientMimeType();
        $fileNameWithoutExtension = pathinfo($fileName, PATHINFO_FILENAME);

        $filename = $fileNameWithoutExtension . '_' . time() . '.' . $file->getClientOriginalExtension();
        $fileType = \FileType::getValue($fileType, true);
        $path = storage_path()."/$fileType/";
        Storage::put('$fileType/', file_get_contents($file));

        $storagefiles = Storagefiles::add($filename, $path, $fileType, $fileExtension, $fileMime);

        if ($file) {
            return $storagefiles;
        }
    } catch (Exception $e) {

    }

    return null;
}

/**
 * Upload and save files.
 * Returns attachment object.
 *
 * @param \Illuminate\Http\UploadedFile $attachment
 * @param $file
 * @param $fileType
 *
 * @return \Illuminate\Http\UploadedFile|null
 */
function uploadProductFile(\Illuminate\Http\UploadedFile $file, $productId)
{
    try {
        $tempFileName = $file->getClientOriginalName();
        $fileName = generateSlug($tempFileName);
        // $fileExtension = $file->getClientOriginalExtension();
        // $fileMime = $file->getClientMimeType();
        $fileNameWithoutExtension = pathinfo($fileName, PATHINFO_FILENAME);

        $filename = $fileNameWithoutExtension . '_' . time() . '.' . $file->getClientOriginalExtension();
        $fileType = \FileType::getValue($fileType, true);
        $path = storage_path()."/$fileType/";
        Storage::put('$fileType/', file_get_contents($file));

        $productMedia = ProductMedia::add($filename, $productId, $path);

        if ($file) {
            return $productMedia;
        }
    } catch (Exception $e) {

    }

    return null;
}

/**
 * Delete file from storage_file table.
 *
 * @param $id
 *
 * @return bool
 * @throws Exception
 */
function deleteFile($id)
{
    try {
        $file = Storagefiles::getById($id);
        if ($file instanceof Storagefiles) {
            $file->delete();

            return true;
        }
    } catch (\Exception $exception) {
        Log::error("Method :: deleteFile :: " . $exception->getMessage());
    }

    return false;
}

/**
 * Delete product file from product_media table.
 *
 * @param $id
 *
 * @return bool
 * @throws Exception
 */
function deleteProductFile($id)
{
    try {
        $file = ProductMedia::getById($id);
        if ($file instanceof ProductMedia) {
            $file->delete();

            return true;
        }
    } catch (\Exception $exception) {
        Log::error("Method :: deleteFile :: " . $exception->getMessage());
    }

    return false;
}