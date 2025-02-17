<?php

namespace App\Http\Controllers;

use App\Facades\UserContext;
use App\Models\MapCostCenterHierarchy;
use App\Models\MCostCenter;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\CostCenterService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Services\ImageService;
use App\Services\JwtService;

/**
 * @OA\Tag(
 *     name="Cost Center Hierarchy",
 *     description="From Table MapCostCenterHierarchy"
 * )
 */
class CostCenterHierarchyController extends Controller
{
    protected $imageService;
    protected $jwtService;
    protected $costCenterService;

    // Combine both services in a single constructor
    public function __construct(ImageService $imageService, JwtService $jwtService, CostCenterService $costCenterService)
    {
        $this->imageService = $imageService;
        $this->jwtService = $jwtService;
        $this->costCenterService = $costCenterService;

    }

    /**
     * @OA\Get(
     *     path="/api/cost-center",
     *     summary="Get All Data From Table MapCostCenterHierarchy",
     *     description="Retrieve all data from the MapCostCenterHierarchy table, including relationships.",
     *     operationId="getAllCostCenterHierarchy",
     *     tags={"Cost Center Hierarchy"},
     *     @OA\Parameter(
     *         name="cost_center",
     *         in="query",
     *         required=false,
     *         description="Filter by cost center ID",
     *         @OA\Schema(type="string", example="TCB1000000")
     *     ),
     *     @OA\Parameter(
     *         name="cost_center_name",
     *         in="query",
     *         required=false,
     *         description="Filter by cost center name",
     *         @OA\Schema(type="string", example="SVP MARKETING")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(
     *                     property="cost_center",
     *                     type="string",
     *                     example="AB00000000"
     *                 ),
     *                 @OA\Property(
     *                     property="cost_center_name",
     *                     type="string",
     *                     nullable=true,
     *                     example="Sales Department"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Cost Center not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Internal Server Error")
     *         )
     *     )
     * )
     */

     public function getAllCostCenterHierarchy(Request $request): JsonResponse
     {
         try {
             $cost_center_name = $request->query('cost_center_name');
             $cost_center = $request->query('cost_center');
     
             $costCenter = DB::table('map_cost_center_hierarchy')
                 ->when(!empty($cost_center_name), function ($query) use ($cost_center_name) {
                     // Menggunakan LOWER() untuk SQL Server dan mengganti ilike dengan LIKE
                     return $query->whereRaw('
                         LOWER(cost_center_name) LIKE ? AND 
                         CURRENT_TIMESTAMP BETWEEN COALESCE(start_effective_date, ?) AND COALESCE(end_effective_date, ?)
                         ', ['%' . strtolower($cost_center_name) . '%', '2023-01-01', '9999-12-31']                    
                     );
                 })
                 ->when(!empty($cost_center), function ($query) use ($cost_center) {
                     return $query->where('cost_center', $cost_center);
                 })
                 ->select([
                     'cost_center',
                     'cost_center_name',
                     'cost_center_direct_report',
                     'cost_center_poss',
                     'cost_center_dh',
                     'cost_center_gh',
                     'cost_center_svp',
                     'cost_center_dir',
                     'start_effective_date',
                     'end_effective_date'
                 ])
                 ->limit(10)
                 ->get();
     
             if ($costCenter->isEmpty()) {
                 return response()->json([
                     'status' => 'error',
                     'message' => 'Cost Center not found',
                     'data' => []
                 ], 200);
             }
     
             return response()->json($costCenter, 200);
     
         } catch (\Exception $e) {
             Log::error('Error in getAllCostCenterHierarchy: ' . $e->getMessage());
             return response()->json([
                 'status' => 'error',
                 'message' => 'Internal Server Error',
                 'detail' => config('app.debug') ? $e->getMessage() : null
             ], 500);
         }
     }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payload = UserContext::getPayload();

        $roleData = UserContext::getRoleData();

        $allContext = UserContext::getAllContext();

        $bp = $payload['partner'];
        $imageData = $this->imageService->fetchImageData($bp);

        $costCenters = MapCostCenterHierarchy::with([
            'directReport',
            'poss',
            'dh',
            'gh',
            'svp',
            'dir',
            'mapEmployeeTitle' => function ($query) {
                $query->whereHas('mTitle.mapEmployeeTitle', function ($q) {
                    $q->whereHas('mTitle', function ($q2) {
                        $q2->where('is_head', true);
                    });
                });
            },
            'mapEmployeeTitle.mTitle.mapEmployeeTitle.mEmployeeGeneralInfo'
        ])->get();

        return view('costcenterhierarchy.index', [
            'namaUser' => $payload['name'],
            'imageData' => $imageData,
            'costCenters' => $costCenters
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $payload = UserContext::getPayload();

        $roleData = UserContext::getRoleData();

        $allContext = UserContext::getAllContext();

        $bp = $payload['partner'];
        $imageData = $this->imageService->fetchImageData($bp);

        $costCenters = MapCostCenterHierarchy::all();
        $distinctCostCenters = MCostCenter::select('cost_ctr', 'ct_description')
            ->distinct()
            ->whereNotExists(function ($query) {
                $query->select('cost_center')
                    ->from('map_cost_center_hierarchy')
                    ->whereColumn('map_cost_center_hierarchy.cost_center', 'cost_ctr');
            })
            ->get();
        return view('costcenterhierarchy.create', [
            'namaUser' => $payload['name'],
            'imageData' => $imageData,
            'costCenters' => $costCenters,
            'distinctCostCenters' => $distinctCostCenters
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validatedData = Validator::make($request->all(), [
            'costCenterId' => 'required|string|max:10',
            'costCenterSd' => 'required|date',
            'costCenterEd' => 'nullable|date',
            'costCenterDrId' => 'nullable|string|max:10',
            'costCenterCpId' => 'nullable|string|max:10',
            'costCenterDhId' => 'nullable|string|max:10',
            'costCenterGhId' => 'nullable|string|max:10',
            'costCenterSvpId' => 'nullable|string|max:10',
            'costCenterDirId' => 'nullable|string|max:10',


        ]);

        if ($validatedData->fails()) {
            dd($validatedData->errors());
        }
        $validated = $validatedData->validate();


        $mCostCenter = MCostCenter::where('cost_ctr', $validated['costCenterId'])->first();
        $newCostCenter = MapCostCenterHierarchy::create([
            'cost_center' => $validated['costCenterId'],
            'cost_center_name' => $mCostCenter->ct_description,

            'start_effective_date' => Carbon::createFromFormat('m/d/Y', $validated['costCenterSd'])->format('Y-m-d')

        ]);



        if ((!empty($validated['costCenterDrId']))) {
            if ($this->costCenterService->doesCostCenterExist($validated['costCenterDrId'])) {
                $newCostCenter->cost_center_direct_report = $this->costCenterService->getCostCenterById($validated['costCenterDrId'])->cost_center;
            } elseif ($validated['costCenterDrId'] === "self") {
                $newCostCenter->cost_center_direct_report = $newCostCenter->cost_center;
            }
        }
        if ((!empty($validated['costCenterCpId']))) {
            if ($this->costCenterService->doesCostCenterExist($validated['costCenterCpId'])) {
                $newCostCenter->cost_center_poss = $this->costCenterService->getCostCenterById($validated['costCenterCpId'])->cost_center;
            } elseif ($validated['costCenterCpId'] === "self") {
                $newCostCenter->cost_center_poss = $newCostCenter->cost_center;
            }
        }
        if ((!empty($validated['costCenterDhId']))) {
            if ($this->costCenterService->doesCostCenterExist($validated['costCenterDhId'])) {
                $newCostCenter->cost_center_dh = $this->costCenterService->getCostCenterById($validated['costCenterDhId'])->cost_center;
            } elseif ($validated['costCenterDhId'] === "self") {
                $newCostCenter->cost_center_dh = $newCostCenter->cost_center;
            }
        }
        if ((!empty($validated['costCenterGhId']))) {
            if ($this->costCenterService->doesCostCenterExist($validated['costCenterGhId'])) {
                $newCostCenter->cost_center_gh = $this->costCenterService->getCostCenterById($validated['costCenterGhId'])->cost_center;
            } elseif ($validated['costCenterGhId'] === "self") {
                $newCostCenter->cost_center_gh = $newCostCenter->cost_center;
            }
        }
        if ((!empty($validated['costCenterSvpId']))) {
            if ($this->costCenterService->doesCostCenterExist($validated['costCenterSvpId'])) {
                $newCostCenter->cost_center_svp = $this->costCenterService->getCostCenterById($validated['costCenterSvpId'])->cost_center;
            } elseif ($validated['costCenterSvpId'] === "self") {
                $newCostCenter->cost_center_svp = $newCostCenter->cost_center;
            }
        }
        if ((!empty($validated['costCenterDirId']))) {
            if ($this->costCenterService->doesCostCenterExist($validated['costCenterDirId'])) {
                $newCostCenter->cost_center_dir = $this->costCenterService->getCostCenterById($validated['costCenterDirId'])->cost_center;
            } elseif ($validated['costCenterDirId'] === "self") {
                $newCostCenter->cost_center_dir = $newCostCenter->cost_center;
            }
        }
        if (!empty($validated['costCenterEd'])) {
            $newCostCenter->end_effective_date = Carbon::createFromFormat('m/d/Y', $validated['costCenterEd'])->format('Y-m-d');
        }
        $newCostCenter->save();


        return redirect()->route('costCenterHierarchy')->with('success', 'Cost Center created successfully.');
    }

    // /**
    //  * Display the specified resource.
    //  */
    // public function show(string $id)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $payload = UserContext::getPayload();

        $roleData = UserContext::getRoleData();

        $allContext = UserContext::getAllContext();

        $bp = $payload['partner'];
        $imageData = $this->imageService->fetchImageData($bp);

        $costCenter = MapCostCenterHierarchy::where('cost_center', $id)
            ->with(['directReport', 'poss', 'dh', 'gh', 'svp', 'dir'])
            ->first();


        $costCenters = MapCostCenterHierarchy::with(['directReport', 'poss', 'dh', 'gh', 'svp', 'dir'])->get();
        // Return the correct variable to the view
        return view('costcenterhierarchy.edit', [
            'namaUser' => $payload['name'],
            'imageData' => $imageData,
            'data' => $costCenter,
            'costCenters' => $costCenters
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            // Validasi input
            $validatedData = Validator::make($request->all(), [
                'costCenterSd' => 'required|date',
                'costCenterEd' => 'nullable|date', // Ensure end date is after start date
                'costCenterDrId' => 'nullable|string|max:10',
                'costCenterCpId' => 'nullable|string|max:10',
                'costCenterDhId' => 'nullable|string|max:10',
                'costCenterGhId' => 'nullable|string|max:10',
                'costCenterSvpId' => 'nullable|string|max:10',
                'costCenterDirId' => 'nullable|string|max:10',
            ]);

            if ($validatedData->fails()) {
                dd($validatedData->errors());
                return redirect()->back()->withErrors($validatedData)->withInput();
            }

            $validated = $validatedData->validated();

            // dd($validated);

            // Fetch the cost center by primary key
            $costCenter = MapCostCenterHierarchy::where('cost_center', $id)->first();

            if (!$costCenter) {
                return redirect()->back()->with('error', "Cost Center with ID $id not found.");
            }

            // Update nullable foreign key relationships

            $costCenter->start_effective_date = $validated['costCenterSd'];

            $costCenter->cost_center_direct_report = $this->validateCostCenter($validated['costCenterDrId'] ?? null);
            $costCenter->cost_center_poss = $this->validateCostCenter($validated['costCenterCpId'] ?? null);
            $costCenter->cost_center_dh = $this->validateCostCenter($validated['costCenterDhId'] ?? null);
            $costCenter->cost_center_gh = $this->validateCostCenter($validated['costCenterGhId'] ?? null);
            $costCenter->cost_center_svp = $this->validateCostCenter($validated['costCenterSvpId'] ?? null);
            $costCenter->cost_center_dir = $this->validateCostCenter($validated['costCenterDirId'] ?? null);

            // Update date fields
            if (!empty($validated['costCenterEd'])) {
                $costCenter->end_effective_date = Carbon::parse($validated['costCenterEd'])->format('Y-m-d');
            } else {
                $costCenter->end_effective_date = null;
            }

            // dd($costCenter);

            // Save changes
            $costCenter->save();

            return redirect()->route('costCenterHierarchy')->with('success', 'Cost Center updated successfully.');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    private function validateCostCenter(?string $costCenterId): ?string
    {
        // Check if the cost center exists in the database
        if ($costCenterId && MapCostCenterHierarchy::where('cost_center', $costCenterId)->exists()) {
            return $costCenterId;
        }
        return null;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {


        $costCenterId = $request->input('costCenterId');

        // Find and delete the cost center
        $costCenter = MapCostCenterHierarchy::find($costCenterId);
        if ($costCenter) {
            $costCenter->delete();
            return redirect()->route('costCenterHierarchy')->with('success', 'Cost center deleted successfully.');
        }

        return redirect()->route('costCenterHierarchy')->with('error', 'Cost center not found.');
    }
}
