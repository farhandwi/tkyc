<?php

namespace App\Http\Controllers;

use App\Services\ImageService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\ImageRequest;

class UsersImageController extends Controller
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }


    /**
     * @OA\Post(
     *     path="/api/image",
     *     tags={"Users Images"},
     *     summary="Create or update image data",
     *     description="Creates a new image record or updates an existing one based on the 'bp' value.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"bp", "image_data"},
     *             @OA\Property(property="bp", type="string", example="1300001000"),
     *             @OA\Property(property="image_data", type="string", example="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAUA...")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Data saved successfully.",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="Data saved successfully."),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Employee not found.",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=404),
     *             @OA\Property(property="message", type="string", example="Employee not found.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="An error occurred.",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=500),
     *             @OA\Property(property="message", type="string", example="An error occurred.")
     *         )
     *     )
     * )
     */

    public function createOrUpdate(ImageRequest $request): JsonResponse
    {
        $data = $request->validated();

        $result = $this->imageService->createOrUpdate($data);

        return response()->json($result, $result['status']);
    }


    /**
     * @OA\Get(
     *     path="/api/image/{bp}",
     *     tags={"Users Images"},
     *     summary="Get image data by BP",
     *     description="Returns image data for the given BP value.",
     *     @OA\Parameter(
     *         name="bp",
     *         in="path",
     *         description="BP value",
     *         required=true,
     *         @OA\Schema(type="string", example="1300001000")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="bp", type="string", example="1300001000"),
     *                 @OA\Property(property="image_data", type="string", example="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAUA...")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="BP not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=404),
     *             @OA\Property(property="message", type="string", example="BP not found.")
     *         )
     *     )
     * )
     */
    public function getImage(string $bp): JsonResponse
    {
        $result = $this->imageService->getImageByBp($bp);


        return response()->json($result, 200);
    }
}
