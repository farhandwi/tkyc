<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DotsApproval;
use App\Models\MapEmployeeTitle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class DotsApprovalController extends Controller
{
    /**
     * Get approvals based on cost centers
     * 
     * @OA\Post(
     *     path="/api/dots-approval",
     *     summary="Get approval data based on cost centers",
     *     description="Retrieves approval data for given cost centers with employee information and titles",
     *     operationId="getApprovals",
     *     tags={"Views For Employee"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"approval1"},
     *             @OA\Property(property="approval1", type="string", example="TCD0010200", description="Cost center for first approval level"),
     *             @OA\Property(property="approval2", type="string", nullable=true, example="TCD0010000", description="Cost center for second approval level"),
     *             @OA\Property(property="approval3", type="string", nullable=true, example=null, description="Cost center for third approval level"),
     *             @OA\Property(property="approval4", type="string", nullable=true, example=null, description="Cost center for fourth approval level"),
     *             @OA\Property(property="approval5", type="string", nullable=true, example=null, description="Cost center for fifth approval level")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(
     *                     property="approval1",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="name", type="string", example="ARGA FAJAR SYAH"),
     *                         @OA\Property(property="title", type="string", example="PLT. INFORMATION TECHNOLOGY GROUP HEAD"),
     *                         @OA\Property(property="email", type="string", example="afajarsyah@tugu.com"),
     *                         @OA\Property(property="bp", type="string", example="1300000092"),
     *                         @OA\Property(property="approval_level", type="integer", example=1),
     *                         @OA\Property(property="cost_center", type="string", example="TCD0010000")
     *                     )
     *                 ),
     *                 @OA\Property(
     *                     property="approval2",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="name", type="string", example="ARGA FAJAR SYAH"),
     *                         @OA\Property(property="title", type="string", example="PLT. INFORMATION TECHNOLOGY GROUP HEAD"),
     *                         @OA\Property(property="email", type="string", example="afajarsyah@tugu.com"),
     *                         @OA\Property(property="bp", type="string", example="1300000092"),
     *                         @OA\Property(property="approval_level", type="integer", example=2),
     *                         @OA\Property(property="cost_center", type="string", example="TCD0010000")
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Validation failed"),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(
     *                     property="approval1",
     *                     type="array",
     *                     @OA\Items(type="string", example="The approval1 field must only contain letters and numbers.")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Data not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Cost center TCD0010200 not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="An unexpected error occurred")
     *         )
     *     )
     * )
     */
    public function getApprovals(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'approval1' => 'nullable|string|max:255|regex:/^[A-Za-z0-9]+$/',
                'approval2' => 'nullable|string|max:255|regex:/^[A-Za-z0-9]+$/',
                'approval3' => 'nullable|string|max:255|regex:/^[A-Za-z0-9]+$/',
                'approval4' => 'nullable|string|max:255|regex:/^[A-Za-z0-9]+$/',
                'approval5' => 'nullable|string|max:255|regex:/^[A-Za-z0-9]+$/',
            ], [
                'regex' => 'The :attribute must only contain letters and numbers.',
                'max' => 'The :attribute must not exceed 255 characters.',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Check if at least one approval is provided
            if (!array_filter($request->only(['approval1', 'approval2', 'approval3', 'approval4', 'approval5']))) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'At least one approval must be provided'
                ], 422);
            }

            $result = [];

            for ($i = 1; $i <= 5; $i++) {
                $approvalKey = "approval{$i}";
                $costCenter = $request->input($approvalKey);

                if ($costCenter) {
                    $approvalExists = DotsApproval::where('cost_center', $costCenter)->exists();
                    
                    if (!$approvalExists) {
                        return response()->json([
                            'status' => 'error',
                            'message' => "Cost center {$costCenter} not found"
                        ], 404);
                    }

                    $approvalData = DotsApproval::where('cost_center', $costCenter)
                        ->get()
                        ->map(function ($approval) use ($i, $costCenter) {
                            try {
                                return [
                                    'name' => $approval->employee_name ?? null,
                                    'title' => ($approval->title_name ?? null),
                                    'email' => $approval->email ?? null,
                                    'bp' => $approval->BP ?? null,
                                    'approval_level' => $i,
                                    'cost_center' => $approval->cost_center ?? null,
                                    'cost_center_name' => $approval->cost_center_name ?? null
                                ];
                            } catch (Exception $e) {
                                Log::error('Error processing approval data: ' . $e->getMessage(), [
                                    'BP' => $approval->BP,
                                    'cost_center' => $costCenter
                                ]);

                                return [
                                    'name' => 'Error processing data',
                                    'title' => 'Error processing data',
                                    'email' => 'N/A',
                                    'bp' => 'N/A',
                                    'approval_level' => $i,
                                    'cost_center' => $costCenter
                                ];
                            }
                        })
                        ->toArray();

                    if (!empty($approvalData)) {
                        $result["approval{$i}"] = $approvalData;
                    }
                }
            }

            if (empty($result)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No approval data found for the provided cost centers'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data' => $result
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);

        } catch (QueryException $e) {
            Log::error('Database error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Database error occurred'
            ], 500);

        } catch (Exception $e) {
            Log::error('Unexpected error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected error occurred'
            ], 500);
        }
    }

    
        /**
     * @OA\Post(
     *     path="/api/dots-approval/multiple",
     *     summary="Get approval data for multiple cost centers",
     *     tags={"Views For Employee"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"cost_centers"},
     *             @OA\Property(
     *                 property="cost_centers",
     *                 type="array",
     *                 @OA\Items(type="string", example="CC001")
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
     *                     @OA\Property(property="cost_center_name", type="string", example="Finance Department"),
     *                     @OA\Property(property="cost_center_apv_1", type="string", example="APV1"),
     *                     @OA\Property(property="cost_center_apv_2", type="string", example="APV2"),
     *                     @OA\Property(property="BP", type="string", example="BP001"),
     *                     @OA\Property(property="employee_name", type="string", example="John Doe"),
     *                     @OA\Property(property="role_user", type="string", example="DH"),
     *                     @OA\Property(property="title_name", type="string", example="Finance Manager"),
     *                     @OA\Property(property="email", type="string", example="john.doe@company.com"),
     *                     @OA\Property(property="sex", type="string", example="MALE")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Validation Error"),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     )
     * )
     */
    public function getByMultipleCostCenters(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'cost_centers' => 'required|array',
                'cost_centers.*' => 'required|string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation Error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $costCenters = $request->cost_centers;
            $data = DotsApproval::whereIn('cost_center', $costCenters)->get();

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

    /**
     * @OA\Get(
     *     path="/api/map-employee-title",
     *     summary="Get employee title mapping by BP and cost center",
     *     description="Retrieves employee title mapping data based on the provided BP (Business Partner) number and cost center",
     *     tags={"Views For Employee"},
     *     @OA\Parameter(
     *         name="BP",
     *         in="query",
     *         required=true,
     *         description="Business Partner number",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="cost_center",
     *         in="query",
     *         required=false,
     *         description="Cost Center code",
     *         @OA\Schema(
     *             type="string"
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
     *                     type="object",
     *                     @OA\Property(property="BP", type="string", example="12345"),
     *                     @OA\Property(property="cost_center", type="string", example="CC001"),
     *                     @OA\Property(property="title_id", type="string", example="T001"),
     *                     @OA\Property(property="seq_nbr", type="integer", example=1),
     *                     @OA\Property(property="type", type="string", example="PERMANENT"),
     *                     @OA\Property(property="start_effective_date", type="string", format="date", example="2024-01-01"),
     *                     @OA\Property(property="end_effective_date", type="string", format="date", example="2024-12-31"),
     *                     @OA\Property(property="remark", type="string", example="Some remarks"),
     *                     @OA\Property(property="status_pekerjaan", type="string", example="ACTIVE"),
     *                     @OA\Property(
     *                         property="map_cost_center_hierarchy",
     *                         type="object",
     *                         @OA\Property(property="cost_center", type="string", example="CC001"),
     *                         @OA\Property(property="description", type="string", example="Finance Department")
     *                     ),
     *                     @OA\Property(
     *                         property="m_employee_general_info",
     *                         type="object",
     *                         @OA\Property(property="BP", type="string", example="12345"),
     *                         @OA\Property(property="employee_name", type="string", example="John Doe")
     *                     ),
     *                     @OA\Property(
     *                         property="m_title",
     *                         type="object",
     *                         @OA\Property(property="title_id", type="string", example="T001"),
     *                         @OA\Property(property="title_name", type="string", example="Manager")
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Data not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Data not found for the specified BP and cost center"),
     *             @OA\Property(property="data", type="array", @OA\Items())
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Validation Error"),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(
     *                     property="BP",
     *                     type="array",
     *                     @OA\Items(type="string", example="The BP field is required.")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Internal Server Error"),
     *             @OA\Property(property="error", type="string", example="Error message details")
     *         )
     *     )
     * )
     */
    public function MapEmployeeTitle(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'BP' => 'required|string',
                'cost_center' => 'string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation Error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $BP = $request->BP;
            $query = MapEmployeeTitle::where('BP', $BP);
            
            // Add cost_center filter if provided
            if ($request->has('cost_center')) {
                $query->where('cost_center', $request->cost_center);
            }

            $data = $query->get();

            // Cek apakah data ditemukan
            if ($data->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data not found for the specified BP and cost center',
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