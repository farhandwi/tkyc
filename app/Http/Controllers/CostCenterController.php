<?php

namespace App\Http\Controllers;

use App\Facades\UserContext;
use App\Models\MapCostCenterHierarchy;
use App\Models\MCostCenter;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Services\ImageService;
use App\Services\JwtService;

class CostCenterController extends Controller
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

        $costCenters = MCostCenter::with(['oldCostCenter', 'mergedCostCenter'])->get();


        return view('costcenter.index', [
            'namaUser' => $payload['name'],
            'imageData' => $imageData,
            'costCenters' => $costCenters,
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

        $costCenters = MCostCenter::all(); //active costCenters

        $newId = MCostCenter::max('id') ? MCostCenter::max('id') + 1 : 1;


        return view('costcenter.create', [
            'namaUser' => $payload['name'],
            'imageData' => $imageData,
            'costCenters' => $costCenters,
            'newId' => $newId,
        ] );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = Validator::make($request->all(), [

                'oldId' => 'nullable|exists:m_cost_center,id', // Ensure the oldId exists in the database
                'mergeId' => 'nullable|exists:m_cost_center,id', // Ensure the mergeId exists in the database
                'prodCtr' => 'required|string|size:4', // Must be exactly 4 characters
                'costCtr' => 'required|string|size:10', // Must be exactly 10 characters
                'profitCtr' => 'required|string|size:10', // Must be exactly 10 characters
                'tmt' => 'required|date', // Valid date and must be before expiredDate
                'expiredDate' => 'nullable|date', // Valid date and after tmt
                'plant' => 'required|string', // Only numbers allowed
                'ctDescription' => 'required|string|max:500', // Maximum 500 characters
                'remark' => 'nullable|string|max:500', // Optional with a maximum of 500 characters
                'skd' => 'nullable|string|max:500', // Optional with a maximum of 500 characters
            ]);

            if ($validatedData->fails()) {
                dd($validatedData->errors());
            }
            $validated = $validatedData->validate();

            MCostCenter::create([


                'prod_ctr' => $validated['prodCtr'],
                'cost_ctr' => $validated['costCtr'],
                'profit_ctr' => $validated['profitCtr'],
                'plant' => $validated['plant'],
                'ct_description' => $validated['ctDescription'],
                'remark' => $validated['remark'],
                'SKD' => $validated['skd'],
                'TMT' => Carbon::createFromFormat('m/d/Y', $validated['tmt'])->format('Y-m-d'),
                'create_by' => " ",
                'old_id' => $validated['oldId'],
                'merge_id' => $validated['mergeId'],
                'exp_date' => $validated['expiredDate'] ? Carbon::createFromFormat('m/d/Y', $validated['expiredDate'])->format('Y-m-d')
                    : null,



            ]);

            return redirect()->route('costCenter')->with('success', 'Cost Center created successfully.');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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

        $data = MCostCenter::where('id', $id)->firstOrFail(); // Get a single cost center

        $costCenters = MCostCenter::all(); // Get all active cost centers

        return view('costcenter.edit', [
            'namaUser' => $payload['name'],
            'imageData' => $imageData,
            'data' => $data,
            'costCenters' => $costCenters,
        ] );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validatedData = Validator::make($request->all(), [
                'oldId' => 'nullable|exists:m_cost_center,id', // Ensure the oldId exists in the database
                'mergeId' => 'nullable|exists:m_cost_center,id', // Ensure the mergeId exists in the database
                'prodCtr' => 'required|string|size:4', // Must be exactly 4 characters
                'costCtr' => 'required|string|size:10', // Must be exactly 10 characters
                'profitCtr' => 'required|string|size:10', // Must be exactly 10 characters
                'tmt' => 'required|date', // Valid date and must be before expiredDate
                'expiredDate' => 'nullable|date', // Valid date and after tmt
                'plant' => 'required|string', // Only numbers allowed
                'ctDescription' => 'required|string|max:500', // Maximum 500 characters
                'remark' => 'nullable|string|max:500', // Optional with a maximum of 500 characters
                'skd' => 'nullable|string|max:500', // Optional with a maximum of 500 characters
            ]);

            if ($validatedData->fails()) {
                dd($validatedData->errors());
            }
            $validated = $validatedData->validate();

            $costCenter = MCostCenter::where('id', $id)->firstOrFail();

            $costCenterHierarchy = MapCostCenterHierarchy::where('cost_center', $costCenter->cost_ctr)->first();
            if ($costCenterHierarchy) {
                $costCenterHierarchy->update([
                    'cost_center' => $validated['costCtr'],
                    'cost_center_name' => $validated['ctDescription'],

                ]);
            }
            $costCenter->update([
                'prod_ctr' => $validated['prodCtr'],
                'cost_ctr' => $validated['costCtr'],
                'profit_ctr' => $validated['profitCtr'],
                'plant' => $validated['plant'],
                'ct_description' => $validated['ctDescription'],
                'remark' => $validated['remark'],
                'SKD' => $validated['skd'],
                'TMT' =>  $validated['tmt'],
                'create_by' => " ",
                'old_id' => $validated['oldId'],
                'merge_id' => $validated['mergeId'],
                'exp_date' =>  $validated['expiredDate']
            ]);


            return redirect()->route('costCenter')->with('success', 'Cost Center Updated successfully.');
        } catch (\Exception $e) {
            dd($e->getMessage());
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
