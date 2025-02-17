<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Models\MapCostCenterHierarchy;
use App\Models\MapEmployeeTitle;
use App\Models\MapTitleCostCenter;
use App\Models\MEmployeeAdditional;
use App\Models\MApplication;
use Carbon\Carbon;
use App\Models\MEmployeeGeneralInfo;
use App\Models\MTitle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use App\Services\ImageService;
use Illuminate\Support\Facades\Cookie;
use App\Services\JwtService;
use App\Queries\EmployeeQueries;
use App\Facades\UserContext;
use App\Http\Requests\CostCenterApprovalRequest;

/**
 * @OA\Info(
 *     title="BPMS API",
 *     version="1.0.0",
 *     description="API documentation for BPMS app",
 * )
 */
class EmployeeController extends Controller
{
    protected $imageService;
    protected $jwtService;

    // Combine both services in a single constructor
    public function __construct(ImageService $imageService, JwtService $jwtService)
    {
        $this->imageService = $imageService;
        $this->jwtService = $jwtService;
    }

    /**
     * @OA\get(
     *     path="/api/bp/email/{email}",
     *     summary="Get all BP by email",
     *     description="Get BP from Table MEmployeeGeneralInfo.",
     *     operationId="Get BP employee",
     *     tags={"Employee General Info"},
     *      @OA\Parameter(
     *         name="email",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string", example="abdullah@tugu.com")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     )
     * )
     */


     public function getBpEmployee($email): JsonResponse
     {
        try {
            $query = DB::table('m_employee_general_info as a')
                ->join('map_employee_title as b', 'a.BP', '=', 'b.BP')
                ->join('m_title as c', 'b.title_id', '=', 'c.title_id')
                ->join('map_cost_center_hierarchy as d', 'b.cost_center', '=', 'd.cost_center')
                ->select([
                    'a.BP',
                    'a.name',
                    'a.email',
                    'b.title_id',
                    'c.title_name',
                    'b.cost_center',
                    'd.cost_center_name',
                    'b.start_effective_date',
                    'b.end_effective_date'
                ])
                ->whereRaw('LOWER(a.email) = ?', [strtolower($email)])
                ->where(function($query) {
                    $query->whereNull('b.end_effective_date')
                          ->orWhere('b.end_effective_date', '>=', now());
                });
     
            // Log query untuk debugging
            $sql = $query->toSql();
            $bindings = $query->getBindings();
            Log::info('SQL Query: ' . Str::replaceArray('?', $bindings, $sql));
     
            $employee = $query->get();
     
            if ($employee->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No employees found'
                ], 404);
            }
     
            return response()->json([
                'status' => 'success',
                'data' => $employee
            ], 200);
     
        } catch (\Exception $e) {
            Log::error('Error in getBpEmployee: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Internal Server Error',
                'detail' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
     }

    /**
     * @OA\Get(
     *     path="/api/role/{email}",
     *     summary="Get an BP role TOA by email",
     *     description="Get BP role TOA from Table map_employee_application, map_cost_center_application.",
     *     operationId="Get BP role TOA",
     *     tags={"Employee General Info"},
     *     @OA\Parameter(
     *         name="email",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string", example="nrsari@tugu.com")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     )
     * )
     */
    public function getRole($email): JsonResponse
    {
        try {
            $query = EmployeeQueries::getRoleToaQuery();

            $employee = DB::select($query, [$email, $email]);

            if (empty($employee)) {
                $query = DB::table('m_employee_general_info as a')
                    ->select(
                        'a.BP as partner',
                        'a.email',
                        'a.name',
                        'a.address',
                        'd.cost_center',
                        'b.title_id',
                        'c.title_name',
                        'd.cost_center_name'
                    )
                    ->join('map_employee_title as b', 'a.BP', '=', 'b.BP')
                    ->join('m_title as c', 'b.title_id', '=', 'c.title_id')
                    ->join('map_cost_center_hierarchy as d', 'b.cost_center', '=', 'd.cost_center')
                    ->where('a.email', '=', $email);
                $employeeData = $query->get();
                $sql = $query->toSql();
                $bindings = $query->getBindings();
                Log::info('SQL Query: ' . Str::replaceArray('?', $bindings, $sql));
                if ($employeeData->isEmpty()) {
                    return response()->json(['message' => 'No employees found'], 404);
                }
                return response()->json(['toa' => $employeeData, 'dots' => null], 200);
            }

            $listApp = array_map(function ($item) {
                return $item->app_name;
            }, $employee);

            $hasDots = in_array('DOTS', $listApp);

            $dots = null;
            $userCcdots = null;
            $userDots = [];

            if ($hasDots) {
                $queryUserCCDots = EmployeeQueries::getRoleUserCcDotsQuery();
                $queryUserDots = EmployeeQueries::getRoleUserDotsQuery();

                $userCcDots = collect(DB::select($queryUserCCDots, [$email]))->first();

                if (!empty($userCcDots)) {
                    $userDots = DB::select($queryUserDots, [$userCcDots->BP]);

                    $userCcdots = $userCcDots;
                }
                $dots = [
                    'user' => $userCcdots,
                    'role' => $userDots,
                ];
            }

            return response()->json(['toa' => $employee, 'dots' => $dots], 200);
        } catch (\Exception $e) {
            Log::error('Error in getRoleToa: ' . $e->getMessage());
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }


    /**
     * @OA\Get(
     *     path="/api/role/all/{email}",
     *     summary="Get an BP role TOA by email",
     *     description="Get BP role TOA from Table map_employee_application, map_cost_center_application.",
     *     operationId="Get All role TOA",
     *     tags={"Employee General Info"},
     *     @OA\Parameter(
     *         name="email",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string", example="nrsari@tugu.com")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     )
     * )
     */
    public function getAllRole($email): JsonResponse
    {
        try {
            $query = EmployeeQueries::getRoleToaQuery();
            $employee = DB::select($query, [$email, $email]);

            if (empty($employee)) {
                $query = DB::table('m_employee_general_info as a')
                    ->join('map_employee_title as b', 'a.BP', '=', 'b.BP')
                    ->join('m_title as c', function ($join) {
                        $join->on('b.title_id', '=', 'c.title_id')
                            ->whereRaw("
                                now() between 
                                coalesce(c.start_effective_date, now() - interval '1 day') and 
                                coalesce(c.start_effective_date, '1999-01-01'::date)
                            ");
                    })
                    ->join('map_cost_center_hierarchy as d', 'b.cost_center', '=', 'd.cost_center')
                    ->whereRaw('LOWER(a.email) = ?', [strtolower($email)])
                    ->where('CURRENT_DATE', '>=', DB::raw('b.start_effective_date'))
                    ->where(function ($q) {
                        $q->where('b.end_effective_date', '>=', DB::raw('CURRENT_DATE'))
                            ->orWhereNull('b.end_effective_date');
                    })
                    ->select([
                        'app_id',
                        'app_name',
                        'app_url',
                        'img_url',
                        'environment',
                        'a.BP',
                        'b.title_id',
                        'b.type',
                        'b.seq_nbr',
                        'b.start_effective_date',
                        'b.end_effective_date',
                        'b.remark',
                        'd.cost_center_name'
                    ]);
    
                $employeeData = $query->get();

                if ($employeeData->isEmpty()) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Employee not found'
                    ], 404);
                }
                return response()->json(['toa' => $employeeData], 200);
            }

            $formattedEmployee = collect($employee)->map(function ($item) {
                return [
                    'app_id' => $item->app_id,
                    'app_name' => $item->app_name,
                    'app_url' => $item->app_url,
                    'img_url' => $item->img_url,
                    'environment' => $item->environment,
                    'BP' => $item->BP,
                    'title_id' => $item->title_id,
                    'type' => $item->type,
                    'seq_nbr' => $item->seq_nbr,
                    'start_effective_date' => $item->start_effective_date,
                    'end_effective_date' => $item->end_effective_date,
                    'remark' => $item->remark,
                    'cost_center_name' => $item->cost_center_name
                ];
            })->toArray();
    
            // Process DOTS application
            $dotsIndex = array_search('DOTS', array_column($formattedEmployee, 'app_name'));
            if ($dotsIndex !== false) {
                $queryUserCCDots = EmployeeQueries::getRoleUserCcDotsQuery();
                $queryUserDots = EmployeeQueries::getRoleUserDotsQuery();

                $userCcDots = collect(DB::select($queryUserCCDots, [$email]))->first();

                if (!empty($userCcDots)) {
                    $userDots = collect(DB::select($queryUserDots, [$userCcDots->BP]))
                        ->map(function ($item) {
                            return [
                                'bp' => $item->BP,
                                'em_cost_center' => $item->em_cost_center,
                                'cost_center' => $item->cost_center,
                                'user_type' => $item->user_type
                            ];
                        })
                        ->toArray();
                    
                    $formattedCostCenterApproval = [
                        'bp' => $userCcDots->BP,
                        'email' => $userCcDots->email,
                        'name' => $userCcDots->name,
                        'cost_center' => $userCcDots->cost_center,
                        'approval1' => $userCcDots->approval1,
                        'approval2' => $userCcDots->approval2,
                        'approval3' => $userCcDots->approval3,
                        'approval4' => $userCcDots->approval4,
                        'approval5' => $userCcDots->approval5
                    ];

                    $formattedEmployee[$dotsIndex]['role'] = $userDots;
                    $formattedEmployee[$dotsIndex]['cost_center_approval'] = $formattedCostCenterApproval;
                }
            }

            return response()->json(['toa' => $formattedEmployee], 200);

        } catch (\Exception $e) {
            Log::error('Error in getRoleToa: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Internal Server Error'
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/list-application/{email}",
     *     summary="Get all application TOA by email",
     *     description="Get BP role TOA from Table map_employee_application, map_cost_center_application.",
     *     operationId="Get All application TOA",
     *     tags={"Employee General Info"},
     *     @OA\Parameter(
     *         name="email",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string", example="nrsari@tugu.com")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     )
     * )
     */

    public function getListApplication($email): JsonResponse
    {
        try {
            $query = EmployeeQueries::getRoleToaQuery();
            $employee = DB::select($query, [$email, $email]);

            if (empty($employee)) {
                return response()->json(['message' => 'No applications found'], 404);
            }

            $listApp = array_unique(array_map(function ($item) {
                return trim($item->app_name);
            }, $employee));

            return response()->json(['listApplication' => array_values($listApp)], 200);
        } catch (\Exception $e) {
            Log::error('Error in getListApplication: ' . $e->getMessage());
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/bp/{cost_center}",
     *     summary="Get an BP by cost center, bp, name",
     *     description="Get BP from Table MEmployeeGeneralInfo.",
     *     operationId="Get BP cost center",
     *     tags={"Employee General Info"},
     *     @OA\Parameter(
     *         name="cost_center",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string", example="TCA0010200")
     *     ),
     *     @OA\Parameter(
     *         name="bp",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="string", example="3464554587")
     *     ),
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="string", example="BU")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     )
     * )
     */
    public function getBpCostCenter($cost_center, Request $request): JsonResponse
    {
        try {
            $bp = $request->query('bp');
            $name = $request->query('name');

            $query = DB::table('m_employee_general_info as a')
                ->join('map_employee_title as b', 'a.BP', '=', 'b.BP')
                ->join('m_title as c', 'b.title_id', '=', 'c.title_id')
                ->where('b.cost_center', '=', $cost_center);

            if (!empty($bp)) {
                $query->where('a.BP', '=', $bp);
            }

            if (!empty($name)) {
                $query->whereRaw('a.name ILIKE ?', ["%{$name}%"]);
            }

            $sql = $query->toSql();
            $bindings = $query->getBindings();

            $employee = $query->get();

            if ($employee->isEmpty()) {
                return response()->json(['message' => 'No employees found'], 404);
            }

            Log::info('SQL Query: ' . Str::replaceArray('?', $bindings, $sql));
            return response()->json($employee, 200);
        } catch (\Exception $e) {
            Log::error('Error in getBpCostCenter: ' . $e->getMessage());
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/bank-info/{bp}",
     *     summary="Get bank info by bp",
     *     description="Get bank info from api SAP.",
     *     operationId="Get bank info",
     *     tags={"Employee General Info"},
     *     @OA\Parameter(
     *         name="bp",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string", example="1300000086")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     )
     * )
     */
    public function getBankInfo($bp): JsonResponse
    {
        try {
            $response = Http::get(env('SAP_BUSINESS_PARTNER') . "/BankInfo?PARTNER={$bp}");
            if ($response->failed()) {
                return response()->json(['message' => 'Failed to fetch data from API SAP Bank Info'], 500);
            }
            $data = $response->json();

            return response()->json($data, 200);
        } catch (\Exception $e) {
            Log::error('Error in getBankInfo: ' . $e->getMessage());
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }
    /**
     * @OA\Get(
     *     path="/api/application",
     *     summary="Get all application",
     *     description="Get all application from table m_application.",
     *     operationId="Get all application",
     *     tags={"Employee General Info"},
     *     @OA\Response(
     *         response=200,
     *         description="Success"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     )
     * )
     */
    public function getAllApplication(): JsonResponse
    {
        try {
            $employees = MApplication::all(); // Fetch all employees

            return response()->json($employees, 200);
        } catch (\Exception $e) {
            Log::error('Error in getAllApplication: ' . $e->getMessage());
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/bp/cost-center/{bp}",
     *     summary="Get Cost Center by Business Partner",
     *     description="Get Cost Center by Business Partner.",
     *     operationId="Get Cost Center by BP",
     *     tags={"Employee General Info"},
     *     @OA\Parameter(
     *         name="bp",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string", example="3464554587")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
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


    public function getCostCenter($bp): JsonResponse
    {
        try {
            $query = DB::table('m_employee_general_info as a')
                ->join('map_employee_title as b', 'a.BP', '=', 'b.BP')
                ->join('m_employee_additional as d', 'a.BP', '=', 'd.BP')
                ->join('map_cost_center_hierarchy as c', 'b.cost_center', '=', 'c.cost_center')
                ->where('a.BP', '=', $bp);

            $sql = $query->toSql();
            $bindings = $query->getBindings();

            $employee = $query->get();

            if ($employee->isEmpty()) {
                return response()->json(['message' => 'No employees found'], 404);
            }

            Log::info('SQL Query: ' . Str::replaceArray('?', $bindings, $sql));
            return response()->json($employee, 200);
        } catch (\Exception $e) {
            Log::error('Error in getCostCenter: ' . $e->getMessage());
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/employee",
     *     summary="Get all employees with filtering options",
     *     description="Retrieves a list of employees with optional filtering by cost center and partner (BP)",
     *     operationId="getAllEmployee",
     *     tags={"Employee General Info"},
     *     @OA\Parameter(
     *         name="cost_center",
     *         in="query",
     *         description="Cost center code to filter employees",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             example="ABC123"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="partner",
     *         in="query",
     *         description="Partner/BP number to filter employees",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             example="1234567890"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="partner", type="string", example="1234567890", description="Employee BP number"),
     *                 @OA\Property(property="name_first", type="string", example="John Doe", description="Employee name"),
     *                 @OA\Property(property="email", type="string", example="john.doe@example.com", description="Employee email"),
     *                 @OA\Property(property="nip", type="string", example="NIP123456", description="Employee NIP"),
     *                 @OA\Property(property="bpext", type="string", example="BPEXT123456", description="Employee external partner number"),
     *                 @OA\Property(property="exp_date", type="string", format="date", example="2024-12-31", description="End effective date"),
     *                 @OA\Property(property="cost_center", type="string", example="ABC123", description="Cost center code"),
     *                 @OA\Property(property="division", type="string", example="IT Division", description="Division/Cost center name")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Internal Server Error")
     *         )
     *     )
     * )
     */
    public function getAllEmployee(Request $request): JsonResponse
    {
        try {
            $cost_center = $request->query('cost_center');
            $partner = $request->query('partner');

            $employees = MEmployeeGeneralInfo::leftJoin('m_employee_additional', 'm_employee_general_info.BP', '=', 'm_employee_additional.BP')
                ->leftJoin('map_employee_title', function($join) {
                    $join->on('m_employee_general_info.BP', '=', 'map_employee_title.BP')
                        ->whereRaw("CURRENT_DATE BETWEEN COALESCE(map_employee_title.start_effective_date, DATE '2023-01-01') AND COALESCE(map_employee_title.end_effective_date, DATE '9999-12-31')");
                })
                ->leftJoin('map_cost_center_hierarchy', 'map_employee_title.cost_center', '=', 'map_cost_center_hierarchy.cost_center')
                ->join('m_cost_center as cc', function($join) {
                    $join->on('cc.cost_ctr', '=', 'map_employee_title.cost_center')
                        ->whereRaw("CURRENT_DATE BETWEEN COALESCE(cc.create_date, DATE '2023-01-01') AND COALESCE(cc.exp_date, DATE '9999-12-31')");
                })
                ->select([
                    'm_employee_general_info.BP as partner',
                    'm_employee_general_info.name as name_first',
                    'm_employee_general_info.email',
                    DB::raw('RIGHT("m_employee_additional"."PARTNEREXTERNAL", 3) as nip'),
                    'm_employee_additional.PARTNEREXTERNAL as bpext',
                    'm_employee_additional.end_effective_date as exp_date',
                    'map_employee_title.cost_center as cost_center',
                    'cc.ct_description as division',
                ])->distinct(['partner', 'name', 'cost_center']);

            if (!is_null($cost_center)) {
                $employees->whereRaw('LOWER("map_employee_title"."cost_center") LIKE ?', ['%' . strtolower($cost_center) . '%']);
            }

            if (!is_null($partner)) {
                $employees->where(function ($query) use ($partner) {
                    $partner = strtolower($partner);
                    $query->whereRaw('LOWER("m_employee_general_info"."BP") LIKE ?', ['%' . $partner . '%'])
                        ->orWhereRaw('LOWER("m_employee_general_info"."name") LIKE ?', ['%' . $partner . '%']);
                });
            }

            $employees = $employees->skip(0)->take(20)->get();

            return response()->json($employees, 200);
        } catch (\Exception $e) {
            Log::error('Error in getAllEmployee: ' . $e->getMessage());
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }


    public function index()
    {

        $payload = UserContext::getPayload();

        $roleData = UserContext::getRoleData();

        $allContext = UserContext::getAllContext();

        Log::error('Payload: ' . json_encode($payload));
        Log::error('Role Data: ' . json_encode($roleData));
        Log::error('All Context: ' . json_encode($allContext));

        if (!isset($payload['partner'])) {
            $payload['name'] = 'Admin';
        }

        $bp = $payload['partner'];
        $imageData = $this->imageService->fetchImageData($bp);

        $employees = MEmployeeGeneralInfo::all();

        return view('employee.index', [
            'namaUser' => $payload['name'],
            'imageData' => $imageData,
            'employees' => $employees
        ]);
    }

    public function getEmployees()
    {
        $employees = MEmployeeGeneralInfo::all(); // Fetch all employees
        return response()->json(['data' => $employees]); // Return as JSON with 'data' key
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
        $titles = MTitle::all();

        $lastBP = MEmployeeGeneralInfo::where('BP', 'like', '99%')->max('BP');

        if ($lastBP) {
            // Extract the numeric part after "99" and increment it
            $numericPart = (int) substr($lastBP, 2); // Get everything after "99"
            $newBP = '99' . str_pad($numericPart + 1, 10 - 2, '0', STR_PAD_LEFT); // Pad to keep 10 characters
        } else {
            // If no records exist, start with 990000000001
            $newBP = '9900000001';
        }

        return view('employee.create', [
            'namaUser' => $payload['name'],
            'imageData' => $imageData,
            'costCenters' => $costCenters,
            'titles' => $titles,
            'newBP' => $newBP,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = Validator::make($request->all(), [
                'email' => 'required|email|max:255',
                'fullName' => 'required|string|max:255',
                'address' => 'required|string|max:1000',
                'partnerExternal' => 'required|string|min:10|max:11',
                'gender' => 'required|in:f,m',
                'tmt' => 'required|date',
                'employeeAdditionalEd' => 'nullable|date',
                'employeeAdditionalRemark' => 'nullable|string|max:1000',
                'costCenterId' => 'required|exists:map_cost_center_hierarchy,cost_center',
                'titleId' => 'required|exists:m_title,title_id',
                'mapEmployeeTitleSd' => 'required|date',
                'mapEmployeeTitleEd' => 'nullable|date',
                'mapEmployeeTitleRemark' => 'nullable|string|max:1000',
                'mapEmployeeTitleType' => 'nullable|string',
                'nip1' => 'nullable|string',
                'nip2' => 'nullable|string',
                'uid' => 'nullable|string|regex:/^[A-Z]{3}$/',
                'religion' => 'nullable|in:ISLAM,KRISTEN,KATOLIK,HINDU,BUDHA,KONGHUCU',
                'lastEducation' => 'nullable|string|regex:/^[A-Z0-9]{2,3}$/',
                'university' => 'nullable',
                'faculty' => 'nullable',
                'workLocation' => 'nullable|string',
                'mapEmployeeTitleWorkStatus' => 'required|in:B&B,DIREKSI,PROBATION,TKJP,PWT,PWTT,PWTT(AP),PWTT(PERSERO)',
                'birthDate' => 'nullable|date',
                'ktp' => 'nullable', // KTP validation
                'npwp' => 'nullable', // NPWP validation

            ]);


            if ($validatedData->fails()) {
                dd($validatedData->errors());
            }
            $validated = $validatedData->validate();

            $employee = MEmployeeGeneralInfo::create([
                'name' => strtoupper($validated['fullName']),
                'address' => $validated['address'],
                'email' => $validated['email'],
                'KTP' => $validated['ktp'],
                'NPWP' => $validated['npwp']

            ]);
            MEmployeeAdditional::create([
                'BP' => $employee->BP,
                'PARTNEREXTERNAL' => $validated['partnerExternal'],
                'is_male' => $validated['gender'] === 'm' ? true : false,
                'end_effective_date' => $validated['employeeAdditionalEd'] ? Carbon::createFromFormat('m/d/Y', $validated['employeeAdditionalEd'])->format('Y-m-d')
                    : null,
                'Remark' => $validated['employeeAdditionalRemark'],
                'NIP' => $validated['nip1'],
                'NIP_2' => $validated['nip2'],
                'agama' => $validated['religion'],
                'UID' => $validated['uid'],
                'tanggal_lahir' => $validated['birthDate'] ? Carbon::createFromFormat('m/d/Y', $validated['birthDate'])->format('Y-m-d') : null,
                'tanggal_masuk' => Carbon::createFromFormat('m/d/Y', $validated['tmt'])->format('Y-m-d'),
                'tmt' => Carbon::createFromFormat('m/d/Y', $validated['tmt'])->format('Y-m-d'),
                'fakultas' => $validated['faculty'],
                'lokasi_pekerjaan' => $validated['workLocation'],
                'pendidikan_terakhir' => $validated['lastEducation'],
                'university' => $validated['university'],

            ]);
            // if not head then mapemployeetitle is definitive
            if (!request()->has('mapEmployeeTitleType')) {
                $validated['mapEmployeeTitleType'] = 'DEFINITIVE';
            }
            // if not head then mapemployeetitle is definitive
            if (!request()->has('mapEmployeeTitleType')) {
                $validated['mapEmployeeTitleType'] = 'DEFINITIVE';
            }
            MapEmployeeTitle::create([
                'BP' => $employee->BP,
                'cost_center' => $validated['costCenterId'],
                'title_id' => $validated['titleId'],
                'type' => $validated['mapEmployeeTitleType'],
                'start_effective_date' => Carbon::createFromFormat('m/d/Y', $validated['mapEmployeeTitleSd'])->format('Y-m-d'),
                'end_effective_date' => $validated['mapEmployeeTitleEd'] ? Carbon::createFromFormat('m/d/Y', $validated['mapEmployeeTitleEd'])->format('Y-m-d')
                    : null,
                'remark' => $validated['mapEmployeeTitleRemark'],
                'status_pekerjaan' => $validated['mapEmployeeTitleWorkStatus'],
                'university' => $validated['university'],

            ]);

            return redirect()->route('employee')->with('success', 'Employee created successfully.');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->route('employee')->with('error', 'Failed to create employee. Error: ' . $e->getMessage());
        }
    }

    public function fetchTitles($costCenter)
    {
        $titles = MapTitleCostCenter::where('cost_center', $costCenter)->with(['mTitle'])->get();



        // Return titles as JSON response

        return response()->json($titles, 200, [], JSON_PRETTY_PRINT);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // WILL BE USE ON API
        // $employee = MEmployeeGeneralInfo::with(['mEmployeeAdditional', 'mapEmployeeTitle' => function ($query) {
        //     $currentDate = Carbon::now(); // Get the current date

        //     $query->where('start_effective_date', '<=', $currentDate)
        //         ->where(function ($query) use ($currentDate) {
        //             $query->where('end_effective_date', '>=', $currentDate)
        //                 ->orWhereNull('end_effective_date');
        //         });
        // }, 'mapEmployeeTitle.mTitle'])->where('BP', $id) // Assuming 'id' is the primary key or relevant column
        //     ->first();

        $payload = UserContext::getPayload();

        $roleData = UserContext::getRoleData();

        $allContext = UserContext::getAllContext();

        $bp = $payload['partner'];
        $imageData = $this->imageService->fetchImageData($bp);


        $employee = MEmployeeGeneralInfo::with(['mEmployeeAdditional', 'mapEmployeeTitle.mTitle', 'mapEmployeeTitle.mapCostCenterHierarchy'])->where('BP', $id)->first();


        return view('employee.show', [
            'namaUser' => $payload['name'],
            'imageData' => $imageData,
            'employee' => $employee,
        ]);
    }

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

        $employee = MEmployeeGeneralInfo::with([
            'mEmployeeAdditional',
            'mapEmployeeTitle' => function ($query) {
                $currentDate = Carbon::now(); // Get the current date

                $query->where(function ($query) use ($currentDate) {
                    $query->where('end_effective_date', '>=', Carbon::parse($currentDate)->addWeek())
                        ->orWhereNull('end_effective_date');
                });
            },
            'mapEmployeeTitle.mTitle',
            'mapEmployeeTitle.mapCostCenterHierarchy'
        ])->where('BP', $id) // Assuming 'id' is the primary key or relevant column
            ->first();

        $unactiveTitles = MapEmployeeTitle::where('BP', $id)
            ->where('end_effective_date', '<', Carbon::now()->addWeek())
            ->with([
                'mTitle',
                'mapCostCenterHierarchy'
            ])
            ->get();



        $costCenters = MapCostCenterHierarchy::all();
        $titles = MTitle::all();



        // $employee = collect($this->employees)->firstWhere('id_number', $id);
        return view('employee.edit', [
            'namaUser' => $payload['name'],
            'imageData' => $imageData,
            'employee' => $employee,
            'unactiveTitles' => $unactiveTitles,
            'costCenters' => $costCenters,
            'titles' => $titles,
        ]);
    }
    public function editEmployeeTitle(string $id, string $costCenterId, string $seqNumber, string $titleId)
    {
        $payload = UserContext::getPayload();

        $roleData = UserContext::getRoleData();

        $allContext = UserContext::getAllContext();

        $bp = $payload['partner'];
        $imageData = $this->imageService->fetchImageData($bp);

        $mapEmployeeTitle = MapEmployeeTitle::where('BP', $id)
            ->where('cost_center', $costCenterId)
            ->where('title_id', $titleId)
            ->where('seq_nbr', $seqNumber)
            ->with([
                'mTitle',
                'mapCostCenterHierarchy'
            ])
            ->firstOrFail();



        // $employee = collect($this->employees)->firstWhere('id_number', $id);
        return view('employee.editEmployeeTitle', [
            'namaUser' => $payload['name'],
            'imageData' => $imageData,
            'mapEmployeeTitle' => $mapEmployeeTitle,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {


            $validatedData = Validator::make($request->all(), [
                'email' => 'required|email|max:255',
                'fullName' => 'required|string|max:100',
                'address' => 'required|string|max:255',
                'partnerExternal' => 'required|string|min:10|max:11',
                'gender' => 'required|in:m,f',
                'tmt' => 'required|date',
                'employeeAdditionalEd' => 'nullable|date',
                'employeeAdditionalRemark' => 'nullable|string|max:255',
                'costCenterId' => 'nullable|exists:map_cost_center_hierarchy,cost_center',
                'titleId' => 'nullable|exists:m_title,title_id',
                'newMapEmployeeTitleType' => 'nullable|string',
                'newMapEmployeeTitleSd' => 'nullable|date',
                'newMapEmployeeTitleEd' => 'nullable|date',
                'newMapEmployeeTitleRemark' => 'nullable|string|max:255',
                'nip1' => 'nullable|string',
                'nip2' => 'nullable|string',
                'uid' => 'nullable|string|regex:/^[A-Z]{3}$/',
                'religion' => 'nullable|in:ISLAM,KRISTEN,KATOLIK,HINDU,BUDHA,KONGHUCU',
                'lastEducation' => 'nullable|string|regex:/^[A-Z0-9]{2,3}$/',
                'faculty' => 'nullable',
                'university' => 'nullable',
                'workLocation' => 'nullable|string',
                'newMapEmployeeTitleWorkStatus' => 'nullable|in:B&B,DIREKSI,PROBATION,TKJP,PWT,PWTT,PWTT(AP),PWTT(PERSERO)',
                'birthDate' => 'nullable|date',
                'ktp' => 'nullable', // KTP validation
                'npwp' => 'nullable', // NPWP validation

            ]);


            if ($validatedData->fails()) {
                dd($validatedData->errors());
            }

            $validated = $validatedData->validate();

            $employeeGeneralInfo = MEmployeeGeneralInfo::where('BP', $id)->firstOrFail();
            $employeeGeneralInfo->update([
                'name' => strtoupper($validated['fullName']),
                'address' => $validated['address'],
                'email' => $validated['email'],
                'KTP' => $validated['ktp'],
                'NPWP' => $validated['npwp']

            ]);

            $employeeAdditionalInfo = MEmployeeAdditional::where('BP', $id)->firstorFail();
            if ($employeeAdditionalInfo !== null) {
                $employeeAdditionalInfo->update([
                    'PARTNEREXTERNAL' => $validated['partnerExternal'],
                    'is_male' => $validated['gender'] === 'm' ? true : false,
                    'tmt' => $validated['tmt'],
                    'end_effective_date' => $validated['employeeAdditionalEd'],
                    'Remark' => $validated['employeeAdditionalRemark'],
                    'NIP' => $validated['nip1'],
                    'NIP_2' => $validated['nip2'],
                    'agama' => $validated['religion'],
                    'UID' => $validated['uid'],
                    'tanggal_lahir' => $validated['birthDate'],
                    'tanggal_masuk' => $validated['tmt'],
                    'fakultas' => $validated['faculty'],
                    'lokasi_pekerjaan' => $validated['workLocation'],
                    'status_pekerjaan' => $validated['newMapEmployeeTitleWorkStatus'],
                    'pendidikan_terakhir' => $validated['lastEducation'],
                    'university' => $validated['university'],
                ]);
            } else {
                MEmployeeAdditional::create([
                    'BP' => $id,
                    'PARTNEREXTERNAL' => $validated['partnerExternal'],
                    'is_male' => $validated['gender'] === 'm' ? true : false,
                    'tmt' => $validated['tmt'],
                    'end_effective_date' => $validated['employeeAdditionalEd'],
                    'Remark' => $validated['employeeAdditionalRemark'],
                    'NIP' => $validated['nip1'],
                    'NIP_2' => $validated['nip2'],
                    'agama' => $validated['religion'],
                    'UID' => $validated['uid'],
                    'tanggal_lahir' => $validated['birthDate'],
                    'tanggal_masuk' => $validated['tmt'],
                    'fakultas' => $validated['faculty'],
                    'lokasi_pekerjaan' => $validated['workLocation'],
                    'status_pekerjaan' => $validated['workStatus'],
                    'pendidikan_terakhir' => $validated['lastEducation'],
                    'university' => $validated['university'],
                ]);
            }

            if ($validated['costCenterId'] && $validated['titleId'] && $validated['newMapEmployeeTitleSd']) {
                if (!request()->has('newMapEmployeeTitleType')) {
                    $validated['newMapEmployeeTitleType'] = 'DEFINITIVE';
                }
                if (!request()->has('newMapEmployeeTitleType')) {
                    $validated['newMapEmployeeTitleType'] = 'DEFINITIVE';
                }
                MapEmployeeTitle::create([
                    'BP' => $id,
                    'cost_center' => $validated['costCenterId'],
                    'title_id' => $validated['titleId'],
                    'type' => $validated['newMapEmployeeTitleType'],
                    'start_effective_date' => Carbon::createFromFormat('m/d/Y', $validated['newMapEmployeeTitleSd'])->format('Y-m-d'),
                    'end_effective_date' => $validated['newMapEmployeeTitleEd'] ? Carbon::createFromFormat('m/d/Y', $validated['newMapEmployeeTitleEd'])->format('Y-m-d')
                        : null,
                    'remark' => $validated['newMapEmployeeTitleRemark'],
                    'status_pekerjaan' => $validated['newMapEmployeeTitleWorkStatus'],
                ]);
            }
            return redirect()->back()->with('success', 'Employee updated successfully.');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function updateEmployeeTitle(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'costCenterId' => 'required|exists:map_cost_center_hierarchy,cost_center',
            'titleId' => 'required|exists:m_title,title_id',
            'mapEmployeeTitleEd' => 'nullable|date',
            'remark' => 'nullable|string|max:1000',
            'bp' => 'required|exists:map_employee_title,BP',
            'seqNumber' => 'required|numeric|integer'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $validated = $validator->validate();
        $mapEmployeeTitle = MapEmployeeTitle::where('BP', $validated['bp'])->where('title_id', $validated['titleId'])
            ->where('cost_center', $validated['costCenterId'])
            ->where('seq_nbr', $validated['seqNumber'])->firstOrFail();

        DB::table('map_employee_title')->where('BP', $validated['bp'])->where('cost_center', $validated['costCenterId'])
            ->where('title_id', $validated['titleId'])
            ->where('seq_nbr', $validated['seqNumber'])
            ->update([
                'end_effective_date' => $validated['mapEmployeeTitleEd'],
                'remark' => $validated['remark']
            ]);
        // $mapEmployeeTitle->update([
        //     'end_effective_date' => $validated['mapEmployeeTitleEd'],
        //     // 'remark' => $validated['remark']
        // ]);






        return redirect()->route('employeeEdit', ['id' => $validated['bp']]);
    }


    /**
     * @OA\Post(
     *     path="/api/login",
     *     tags={"Employee Auth"},
     *     summary="Login to the system",
     *     description="This endpoint allows a user to login with an email and tokens (refresh_token and access_token).",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "refresh_token", "access_token"},
     *             @OA\Property(property="email", type="string", example="user@example.com"),
     *             @OA\Property(property="refresh_token", type="string", example="sample_refresh_token"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Login successful"),
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="refresh_token", type="string", example="new_refresh_token")
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid request",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Invalid email or tokens"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Internal server error"),
     *         ),
     *     ),
     * )
     */
    public function login(AuthRequest $request): JsonResponse
    {
        $email = $request->input('email');
        $refreshToken = $request->input('refresh_token');

        $result = $this->jwtService->storeOrUpdateToken($email, $refreshToken);

        return response()->json([
            'message' => 'Login successful',
            'status' => $result['status'],
            'data' => $result['token']
        ], 200);
    }


    public function logout(Request $request): JsonResponse
    {
        $email = $request->query('email');
        if ($this->jwtService->deleteTokenByEmail($email)) {
            $cookie = Cookie::forget('refresh_token');
            Log::error('===========' . $cookie);

            return response()->json([
                'message' => 'Logout successful',
                'should_redirect' => true,
                'redirect_url' => env('URL_LOGIN_TOA', 'http://localhost:3000/login')
            ], 200)->withCookie($cookie);
        }

        return response()->json([
            'message' => 'Token not found for the given email'
        ], 404);
    }


    public function refresh(Request $request): JsonResponse
    {
        try {
            $refreshToken = $request->cookie('refresh_token');

            Log::error('======= JWT Token:', ['token' => $refreshToken]);

            if (!$refreshToken) {
                Log::error('No refresh token provided in cookies');
                return response()->json([
                    'status' => 401,
                    'success' => false,
                    'message' => 'No refresh token provided'
                ], 401);
            }

            $result = $this->jwtService->refresh($refreshToken);

            return response()->json([
                'status' => 200,
                'success' => true,
                'message' => 'Token refreshed.',
                'data' => $result,
                'url' => $request->fullUrl()
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error refreshing token: ' . $e->getMessage());

            return response()->json([
                'status' => $e->getCode() ?: 500,
                'success' => false,
                'message' => $e->getMessage()
            ], $e->getCode() ?: 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/cost-center-approval/{bp}",
     *     summary="Get cost center approval by BP/Partner",
     *     description="Returns cost center approval information for a specific BP/Partner",
     *     operationId="getCostCenterApproval",
     *     tags={"Employee Auth"},
     *     @OA\Parameter(
     *         name="bp",
     *         in="path",
     *         description="BP/Partner identifier",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="cost_center_approval", type="object",
     *                 @OA\Property(property="bp", type="string", example="BP001"),
     *                 @OA\Property(property="email", type="string", example="user@example.com"),
     *                 @OA\Property(property="name", type="string", example="John Doe"),
     *                 @OA\Property(property="cost_center", type="string", example="CC001"),
     *                 @OA\Property(property="approval1", type="string", example="APP001"),
     *                 @OA\Property(property="approval2", type="string", nullable=true, example="APP002"),
     *                 @OA\Property(property="approval3", type="string", nullable=true, example=null),
     *                 @OA\Property(property="approval4", type="string", nullable=true, example=null),
     *                 @OA\Property(property="approval5", type="string", nullable=true, example=null)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cost center approval not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Cost center approval not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Internal Server Error")
     *         )
     *     )
     * )
     */

    public function getCostCenterApproval($bp): JsonResponse
    {
        try {
            $query = "
                SELECT *
                FROM
                    (SELECT b.\"BP\",
                        c.\"email\",
                        c.\"name\",
                        a.cost_center,
                        a.approval1,
                        CASE
                            WHEN NOT a.approval1 = a.approval2 THEN a.approval2
                        END approval2,
                        NULL approval3,
                        NULL approval4,
                        NULL approval5
                    FROM
                        (SELECT a.cost_center,
                            COALESCE(COALESCE(a.cost_center_dh, a.cost_center_gh), a.cost_center) approval1,
                            cost_center_gh approval2
                        FROM map_cost_center_hierarchy a) a
                    INNER JOIN map_employee_title b
                        ON a.cost_center = b.cost_center
                    INNER JOIN m_employee_general_info c
                        ON b.\"BP\" = c.\"BP\"
                    WHERE COALESCE(b.end_effective_date, NOW() + INTERVAL '1 day') > NOW()
                        AND b.start_effective_date < NOW()) a
                WHERE NOT (approval1 IS NULL AND approval2 IS NULL)
                    AND a.\"BP\" = ?;
            ";

            $result = DB::select($query, [$bp]);

            if (empty($result)) {
                return response()->json(['message' => 'Cost center approval not found'], 404);
            }

            $costCenterApproval = collect($result)->first();

            $formattedResponse = [
                'bp' => $costCenterApproval->BP,
                'email' => $costCenterApproval->email,
                'name' => $costCenterApproval->name,
                'cost_center' => $costCenterApproval->cost_center,
                'approval1' => $costCenterApproval->approval1,
                'approval2' => $costCenterApproval->approval2,
                'approval3' => $costCenterApproval->approval3,
                'approval4' => $costCenterApproval->approval4,
                'approval5' => $costCenterApproval->approval5
            ];

            return response()->json(['cost_center_approval' => $formattedResponse], 200);
        } catch (\Exception $e) {
            Log::error('Error in getCostCenterApproval: ' . $e->getMessage());
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Get approvers based on cost center approval data
     * 
     * @OA\Post(
     *     path="/api/approvers",
     *     summary="Get list of approvers based on cost center",
     *     description="Returns approver details for each approval level provided",
     *     operationId="getApprovers",
     *     tags={"Employee Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"bp", "cost_center", "email", "name"},
     *             @OA\Property(property="approval1", type="string", maxLength=10, example="TCD0010200", description="Cost center for first approval level"),
     *             @OA\Property(property="approval2", type="string", maxLength=10, example="TCD0010000", description="Cost center for second approval level"),
     *             @OA\Property(property="approval3", type="string", maxLength=10, nullable=true, example=null, description="Cost center for third approval level"),
     *             @OA\Property(property="approval4", type="string", maxLength=10, nullable=true, example=null, description="Cost center for fourth approval level"),
     *             @OA\Property(property="approval5", type="string", maxLength=10, nullable=true, example=null, description="Cost center for fifth approval level"),
     *             @OA\Property(property="bp", type="string", maxLength=10, example="1300001000", description="Employee BP number"),
     *             @OA\Property(property="cost_center", type="string", maxLength=10, example="TCD0010200", description="Employee cost center"),
     *             @OA\Property(property="email", type="string", format="email", example="employee@tugu.com", description="Employee email"),
     *             @OA\Property(property="name", type="string", example="EMPLOYEE NAME", description="Employee name")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="name", type="string", example="APPROVER NAME"),
     *                     @OA\Property(property="email", type="string", format="email", example="approver@tugu.com"),
     *                     @OA\Property(property="bp", type="string", example="1234567890"),
     *                     @OA\Property(property="approval_level", type="integer", example=1),
     *                     @OA\Property(property="cost_center", type="string", example="TCD0010200")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(property="bp", type="array", @OA\Items(type="string", example="The bp field is required."))
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Internal server error")
     *         )
     *     )
     * )
     */
    public function getApprovers(CostCenterApprovalRequest $request)
    {
        $data = $request->validated();
        $approvers = [];
        
        for ($i = 1; $i <= 5; $i++) {
            $approvalKey = "approval{$i}";
            
            // Skip if approval is null
            if (!isset($data[$approvalKey]) || is_null($data[$approvalKey])) {
                continue;
            }
            
            // Get approver data
            $approverInfo = DB::table('map_employee_title as met')
                ->join('m_employee_general_info as megi', 'met.BP', '=', 'megi.BP')
                ->join('m_title as mt', 'met.title_id', '=', 'mt.title_id')
                ->join('map_cost_center_hierarchy as ch', function($join) {
                    $join->on('ch.cost_center', '=', 'met.cost_center')
                        ->whereRaw("(ch.cost_center = ch.cost_center_dh OR ch.cost_center = ch.cost_center_gh)")
                        ->whereRaw("NOW() BETWEEN COALESCE(ch.start_effective_date, ?::date) AND COALESCE(ch.end_effective_date, ?::date)", 
                            ['2023-01-01', '9999-12-31']);
                })
                ->where('met.cost_center', $data[$approvalKey])
                ->where('mt.is_head', true)
                ->whereRaw("NOW() BETWEEN COALESCE(met.start_effective_date, ?::date) AND COALESCE(met.end_effective_date, ?::date)", 
                            ['2023-01-01', '9999-12-31'])
                ->select([
                    'megi.name',
                    'megi.email',
                    'megi.BP',
                    'mt.title_name',
                    'met.type',
                    DB::raw("CASE 
                        WHEN met.type LIKE '%DEFINITIVE%' THEN mt.title_name 
                        ELSE met.type || '. ' || mt.title_name
                    END as title_desc")
                ])
                ->first();
                
            if ($approverInfo) {
                $approvers[] = [
                    'name' => $approverInfo->name,
                    'title' => $approverInfo->title_desc,
                    'email' => $approverInfo->email,
                    'bp' => $approverInfo->BP,
                    'approval_level' => $i,
                    'cost_center' => $data[$approvalKey]
                ];
            } else {
                $response = Http::withoutVerifying()
                    ->get(env('DOTS_URL', 'https://intraapps.tugu.com/dots-be') . '/api/get-approval-dots', [
                        'cost_center' => $data[$approvalKey],
                    ]);
            
                Log::info('Response from DOTS API:', $response->json());
                
                if ($response->successful()) {
                    $costCenterData = $response->json();
                    foreach($costCenterData['data'] as $c){
                        $results = DB::table('map_employee_title as d')
                            ->select([
                                'd.BP as bp',
                                'e.email',
                                'e.name',
                                DB::raw("STRING_AGG(
                                    CASE 
                                        WHEN type != 'DEFINITIVE' THEN CONCAT(type, '. ', title_name)
                                        ELSE title_name 
                                    END,
                                    ' & '
                                ) as title_name")
                            ])
                            ->join('map_title_cost_center as b', 'b.title_id', '=', 'd.title_id')
                            ->join('m_title as c', function($join) {
                                $join->on('b.title_id', '=', 'c.title_id')
                                    ->where('c.is_head', '=', true);
                            })
                            ->join('m_employee_general_info as e', 'd.BP', '=', 'e.BP')
                            ->whereRaw('NOW() BETWEEN d.start_effective_date AND COALESCE(d.end_effective_date, ?)', ['9999-12-31'])
                            ->where('d.BP', $c['bp'])
                            ->groupBy('d.BP', 'e.name', 'e.email')
                            ->get();
            
                        if ($results->isNotEmpty()) {
                            $titleData = $results->first();
                            $approvers[] = [
                                'name' => $titleData->name,
                                'email' => $titleData->email,
                                'title' => $titleData->title_name,
                                'bp' => $titleData->bp,
                                'approval_level' => $i,
                                'cost_center' => $data[$approvalKey]
                            ];
                        } else {
                            Log::warning('No data found for BP: ' . $c['bp']);
                        }
                    }
                }
            }
        }   
        return response()->json([
            'status' => 'success',
            'data' => $approvers
        ]);
    }

}
