<?php

namespace App\Services;

use Exception;

use App\Models\UsersImage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ImageService
{
    public function createOrUpdate(array $data): array
    {
        try {

            $imageRecord = UsersImage::updateOrCreate(
                ['bp' => $data['bp']],
                ['image_data' => $data['image_data']]
            );

            return [
                'error_code' => 0,
                'status' => 200,
                'error_message' => 'Data saved successfully.',
                'data' => $imageRecord,
            ];
        } catch (ModelNotFoundException $e) {
            return [
                'status' => 404,
                'error_code' => 1,
                'error_message' => 'Employee not found.',
            ];
        } catch (Exception $e) {
            return [
                'status' => 500,
                'error_code' => 1,
                'error_message' => 'An error occurred: ' . $e->getMessage(),
            ];
        }
    }

    public function getImageByBp(string $bp): array
    {
        $image = UsersImage::where('bp', $bp)->first();

        return [
            'status' => 200,
            'data' => $image,
        ];
    }

    /**
     * Fetch image data based on partner ID.
     *
     * @param string $partnerId
     * @return string|null Base64 image data or null if not found
     */
    public function fetchImageData(string $partnerId): ?string
    {
        try {
            $response = UsersImage::where('bp', $partnerId)->first();

            if ($response) {
                // Assuming `image_data` is stored in the database field
                return $response->image_data ?? null;
            } else {
                Log::warning('No image data found for partner ID: ' . $partnerId);
                return null;
            }
        } catch (\Exception $e) {
            Log::error('Error fetching image data: ' . $e->getMessage(), [
                'partner_id' => $partnerId,
            ]);
            return null;
        }
    }

}
