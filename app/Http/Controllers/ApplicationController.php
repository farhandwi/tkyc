<?php

namespace App\Http\Controllers;

use App\Facades\UserContext;
use App\Models\MapCostCenterApplication;
use App\Models\MapCostCenterHierarchy;
use App\Models\MapEmployeeApplication;
use App\Models\MApplication;
use App\Models\MEmployeeGeneralInfo;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB; // Import DB facade for transactions
use App\Services\ImageService;
use App\Services\JwtService;

class ApplicationController extends Controller
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
     * Display a listing of the resource.
     */
    public function index()
    {
        $payload = UserContext::getPayload();

        $roleData = UserContext::getRoleData();

        $allContext = UserContext::getAllContext();

        $bp = $payload['partner'];
        $imageData = $this->imageService->fetchImageData($bp);

        $applications = MApplication::all();

        return view('application.index', [
            'namaUser' => $payload['name'],
            'imageData' => $imageData,
            'applications' => $applications,
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
        $employees = MEmployeeGeneralInfo::all();
        $lastId = MApplication::orderByRaw("CAST(app_id AS INTEGER) DESC")->value('app_id');

        if ($lastId) {
            // Increment the numeric part of the last ID and keep it 5 digits long
            $newId = str_pad(((int) $lastId + 1), 5, '0', STR_PAD_LEFT);
        } else {
            // If no records exist, start with 00001
            $newId = '00001';
        }

        return view('application.create', [
            'namaUser' => $payload['name'],
            'imageData' => $imageData,
            'costCenters' => $costCenters,
            'employees' => $employees,
            'newId' => $newId,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validatedData = Validator::make($request->all(), [

            'appName' => 'required|string|max:255|unique:m_application,app_name', // Required with maximum 255 characters
            'appUrl' => 'required|string|url|max:255', // Must be a valid URL
            'imgUrl' => 'nullable|string|max:255',
            'costCenterIds' => 'nullable|array', // Optional array since N/A is allowed
            'costCenterIds.*' => 'nullable|string|exists:map_cost_center_hierarchy,cost_center', // Each value must exist in cost center table
            'employeeId' => 'nullable|array', // Optional array since N/A is allowed
            'employeeId.*' => 'nullable|string|exists:m_employee_general_info,BP', // Each value must exist in employee table
            'appEnvironment' => 'required|string',
        ]);
        if ($validatedData->fails()) {
            return redirect()->back()->withErrors($validatedData)->withInput();
        }


        $validated = $validatedData->validate();
        if ($validated['imgUrl'] === null || $validated['imgUrl'] === "https://") {
            $validated['imgUrl'] = null;
        }
        $app = MApplication::create([

            'app_name' => $validated['appName'],
            'app_url' => $validated['appUrl'],
            'img_url' => $validated['imgUrl'],
            'environment' => $validated['appEnvironment']
        ]);

        if ($request->has('costCenterIds')) {
            if (count($validated['costCenterIds']) > 0) {

                foreach ($validated['costCenterIds'] as $costCenter) {
                    if ($costCenter !== null) {

                        MapCostCenterApplication::create([
                            'app_id' => $app->app_id,   // Use the created mTitle ID
                            'cost_center' => $costCenter,       // The current cost center in the loop

                        ]);
                    }
                }
            }
        }
        if ($request->has('employeeId')) {
            if (count($validated['employeeId']) > 0) {

                foreach ($validated['employeeId'] as $employeeId) {
                    if ($employeeId !== null) {

                        MapEmployeeApplication::create([
                            'app_id' => $app->app_id,   // Use the created mTitle ID
                            'PARTNER' => $employeeId,       // The current cost center in the loop

                        ]);
                    }
                }
            }
        }
        return redirect()->route('application')->with('success', 'Application created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $payload = UserContext::getPayload();

        $roleData = UserContext::getRoleData();

        $allContext = UserContext::getAllContext();

        $bp = $payload['partner'];
        $imageData = $this->imageService->fetchImageData($bp);

        $application = MApplication::where('app_id', $id)
            ->with([
                'mapCostCenterApplication.costCenterHierarchy',
            ])
            ->firstOrFail();

        $mapEmployeeApplication = MapEmployeeApplication::where('app_id', $id)->with('mEmployeeGeneralInfo')->get();



        return view('application.show', [
            'namaUser' => $payload['name'],
            'imageData' => $imageData,
            'application' => $application,
            'mapEmployeeApplication' => $mapEmployeeApplication,
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

        $application = MApplication::where('app_id', $id)
            ->with([
                'mapCostCenterApplication.costCenterHierarchy',
            ])
            ->firstOrFail();

        $mapEmployeeApplication = MapEmployeeApplication::where('app_id', $id)->with('mEmployeeGeneralInfo')->get();
        $costCenters = MapCostCenterHierarchy::all();
        $employees = MEmployeeGeneralInfo::all();
        return view('application.edit', [
            'namaUser' => $payload['name'],
            'imageData' => $imageData,
            'application' => $application,
            'mapEmployeeApplication' => $mapEmployeeApplication,
            'costCenters' => $costCenters,
            'employees' => $employees,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        try {
            $validatedData = Validator::make($request->all(), [

                'appName' => 'required|string|max:255', // Required with maximum 255 characters
                'appUrl' => 'required|string|url|max:255',
                'imgUrl' => 'nullable|string|max:255', // Must be a valid URL
                'costCenterIds' => 'nullable|array', // Optional array since N/A is allowed
                'costCenterIds.*' => 'nullable|string|exists:map_cost_center_hierarchy,cost_center', // Each value must exist in cost center table
                'employeeId' => 'nullable|array', // Optional array since N/A is allowed
                'employeeId.*' => 'nullable|string|exists:m_employee_general_info,BP', // Each value must exist in employee table
                'appEnvironment' => 'required|string',
            ]);
            if ($validatedData->fails()) {
                return redirect()->back()->withErrors($validatedData)->withInput();
            }
            $validated = $validatedData->validate();
            if ($validated['imgUrl'] === null || $validated['imgUrl'] === "https://") {
                $validated['imgUrl'] = null;
            }
            $application = MApplication::findOrFail($id);
            $application->update([
                'app_name' => $validated['appName'],
                'app_url' => $validated['appUrl'],
                'img_url' => $validated['imgUrl'],
                'environment' => $validated['appEnvironment']
            ]);


            if (count($application->mapCostCenterApplication) > 0) {
                $oldMapCostCenterApplication = MapCostCenterApplication::where('app_id', $id)->get();

                foreach ($oldMapCostCenterApplication as $mapCostCenterApplication) {
                    DB::table('map_cost_center_application')->where('app_id', $id)->where('cost_center', $mapCostCenterApplication->cost_center)->delete();
                }
            }
            if (count($application->mapEmployeeApplication) > 0) {
                $oldMapEmployeeApplication = MapEmployeeApplication::where('app_id', $id)->get();

                foreach ($oldMapEmployeeApplication as $mapEmployeeApplication) {
                    DB::table('map_employee_application')->where('app_id', $id)->where('PARTNER', $mapEmployeeApplication->PARTNER)->delete();
                }
            }

            if ($request->has('costCenterIds')) {
                if (count($validated['costCenterIds']) > 0) {

                    foreach ($validated['costCenterIds'] as $costCenter) {
                        if ($costCenter !== null) {

                            MapCostCenterApplication::create([
                                'app_id' => $id,   // Use the created mTitle ID
                                'cost_center' => $costCenter,       // The current cost center in the loop

                            ]);
                        }
                    }
                }
            }
            if ($request->has('employeeId')) {
                if (count($validated['employeeId']) > 0) {

                    foreach ($validated['employeeId'] as $employeeId) {
                        if ($employeeId !== null) {

                            MapEmployeeApplication::create([
                                'app_id' => $id,   // Use the created mTitle ID
                                'PARTNER' => $employeeId,       // The current cost center in the loop

                            ]);
                        }
                    }
                }
            }
            return redirect()->route('application')->with('success', 'Application Updated successfully.');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
