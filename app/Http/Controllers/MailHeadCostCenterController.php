<?php

namespace App\Http\Controllers;

use App\Models\MailHeadCostCenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MailHeadCostCenterController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/mail-head-cost-center",
     *     summary="Get mail head data by cost center",
     *     tags={"Mail Head Cost Center"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"cost_center"},
     *             @OA\Property(
     *                 property="cost_center",
     *                 type="string",
     *                 example="CC001",
     *                 description="Cost center code"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Data retrieved successfully"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="cost_center", type="string", example="CC001"),
     *                     @OA\Property(property="employee_name", type="string", example="Bapak John Doe, Ibu Jane Smith"),
     *                     @OA\Property(property="email", type="string", example="john.doe@example.com;jane.smith@example.com")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Validation Error"),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Data not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Data not found for the specified cost center"),
     *             @OA\Property(property="data", type="array", @OA\Items())
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Internal Server Error"),
     *             @OA\Property(property="error", type="string")
     *         )
     *     )
     * )
     */
    public function getCostCenterData(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'cost_center' => 'required|string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation Error',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Ambil data
            $costCenter = $request->cost_center;
            $data = MailHeadCostCenter::where('cost_center', $costCenter)->get();

            // Cek apakah data ditemukan
            if ($data->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data not found for the specified cost center',
                    'data' => []
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Data retrieved successfully',
                'data' => $data
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Internal Server Error',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}