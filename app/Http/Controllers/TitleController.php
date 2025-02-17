<?php

namespace App\Http\Controllers;

use App\Facades\UserContext;
use App\Models\MapCostCenterHierarchy;
use App\Models\MTitle;
use App\Models\MapTitleCostCenter;
use App\Models\MapTitleGrade;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Services\ImageService;
use App\Services\JwtService;

use Illuminate\Support\Facades\DB; // Import DB facade for transactions
use Exception;

use function PHPUnit\Framework\isEmpty;

class TitleController extends Controller
{
    protected $imageService;
    protected $jwtService;

    // Combine both services in a single constructor
    public function __construct(ImageService $imageService, JwtService $jwtService)
    {
        $this->imageService = $imageService;
        $this->jwtService = $jwtService;
    }

    public $grades = [

        "5" => 5,
        "6" => 6,
        "7" => 7,
        "8" => 8,
        "9" => 9,
        "10" => 10,
        "11" => 11,
        "12" => 12,
        "13" => 13,
        "14" => 14,
        "15" => 15,
        "16" => 16,
    ];
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


        $titles = MTitle::with('mapTitleGrade', 'mapTitleCostCenter')->get();

        return view('title.index', [
            'namaUser' => $payload['name'],
            'imageData' => $imageData,
            'titles' => $titles,
        ] );
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


        $lastId = MTitle::max('title_id');

        if ($lastId) {
            // Increment the numeric part of the last ID and keep it 5 digits long
            $newId = str_pad(((int) $lastId + 1), 5, '0', STR_PAD_LEFT);
        } else {
            // If no records exist, start with 00001
            $newId = '00001';
        }
        $costCenters = MapCostCenterHierarchy::all();
        $grades = $this->grades;
        return view('title.create', [
            'namaUser' => $payload['name'],
            'imageData' => $imageData,
            'costCenters' => $costCenters,
            'grades' => $grades,
            'newId' => $newId,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        // Validate the request data
        $validatedData = Validator::make($request->all(), [
            'mTitleName' => 'required|string|max:255',
            'mTitleIsHead' => 'required|boolean',
            'mTitleSd' => 'required|date',
            'mTitleEd' => 'nullable|date',
            'costCenterIds' => 'nullable|array',
            'Titlegrades' => 'nullable|array',
            'Titlegrades.*' => 'nullable',
            'costCenterIds.*' => 'nullable|exists:map_cost_center_hierarchy,cost_center',  // Validate each cost center exists in the m_cost_center table
        ]);
        if ($validatedData->fails()) {
            dd($validatedData->errors());
        }
        $validated = $validatedData->validate();
        // Create a new Title record
        $mTitle = new MTitle();
        $mTitle->title_name = $validated['mTitleName'];
        $mTitle->is_head = $validated['mTitleIsHead'];
        $mTitle->start_effective_date = Carbon::createFromFormat('m/d/Y', $validated['mTitleSd'])->format('Y-m-d');
        $mTitle->end_effective_date = $validated['mTitleEd'] ? Carbon::createFromFormat('m/d/Y', $validated['mTitleEd'])->format('Y-m-d') : null;
        $mTitle->save();

        if ($request->has('costCenterIds')) {
            if (count($validated['costCenterIds']) > 0) {
                // Insert multiple cost center records
                foreach ($validated['costCenterIds'] as $costCenter) {
                    MapTitleCostCenter::create([
                        'title_id' => $mTitle->title_id,   // Use the created mTitle ID
                        'cost_center' => $costCenter,       // The current cost center in the loop

                    ]);
                }
            }
        }
        if ($request->has('Titlegrades')) {
            if (count($validated['Titlegrades']) > 0) {
                // Insert multiple cost center records
                foreach ($validated['Titlegrades'] as $titleGrade) {
                    MapTitleGrade::create([
                        'title_id' => $mTitle->title_id,   // Use the created mTitle ID
                        'grade_id' => $titleGrade,   // The current grade in the loop
                    ]);
                }
            }
        }


        return redirect()->route('title')->with('success', 'Title Created successfully.');  // Redirect to the title listing page or wherever
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

        $title = MTitle::with('mapTitleGrade', 'mapTitleCostCenter.MapCostCenterHierarchy')->findOrFail($id);

        // Pass the title data to the view
        return view('title.show', [
            'namaUser' => $payload['name'],
            'imageData' => $imageData,
            'title' => $title,
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

        $grades = $this->grades;
        $title = MTitle::with('mapTitleGrade', 'mapTitleCostCenter.mapCostCenterHierarchy')->findOrFail($id);
        $costCenters = MapCostCenterHierarchy::all();
        return view('title.edit', [
            'namaUser' => $payload['name'],
            'imageData' => $imageData,
            'title' => $title,
            'costCenters' => $costCenters,
            'grades' => $grades,
        ] );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        try {
            // Validate the incoming data
            $validatedData = Validator::make($request->all(), [

                'mTitleName' => 'required|string|max:255',
                'mTitleEd' => 'nullable|date',
                'costCenterIds' => 'nullable|array',
                'Titlegrades' => 'nullable|array',
                'Titlegrades.*' => 'nullable',
                'costCenterIds.*' => 'nullable|exists:map_cost_center_hierarchy,cost_center',
            ]);


            // If validation fails, return the errors
            if ($validatedData->fails()) {
                return redirect()->back()->withErrors($validatedData)->withInput();
            }
            $validated = $validatedData->validate();


            // Find the title by ID
            $title = MTitle::findOrFail($id);

            // Update title data
            $title->title_name = $validated['mTitleName'];
            $title->end_effective_date =  $validated['mTitleEd'] ?  $validated['mTitleEd'] : null;
            $title->save();



            if (count($title->mapTitleCostCenter) > 0) {
                $oldMapTitleCostCenter = MapTitleCostCenter::titleId($id)->get();

                foreach ($oldMapTitleCostCenter as $mapTitleCostCenter) {
                    DB::table('map_title_cost_center')->where('title_id', $id)->where('cost_center', $mapTitleCostCenter->cost_center)->delete();
                }
            }

            if ($request->has('costCenterIds')) {

                if (count($validated['costCenterIds']) > 0) {
                    foreach ($validated['costCenterIds'] as $costCenter) {
                        if ($costCenter !== null) {
                            MapTitleCostCenter::create([
                                'title_id' => $id,   // Use the created mTitle ID
                                'cost_center' => $costCenter,       // The current cost center in the loop

                            ]);
                        }
                    }
                }
            }


            if (count($title->mapTitleGrade) > 0) {
                $oldMapTitleGrade = MapTitleGrade::titleId($id)->get();

                foreach ($oldMapTitleGrade as $mapTitleGrade) {
                    DB::table('map_title_grade')->where('title_id', $id)->where('grade_id', $mapTitleGrade->grade_id)->delete();
                }
            }

            if ($request->has('Titlegrades')) {


                if (count($validated['Titlegrades']) > 0) {

                    foreach ($validated['Titlegrades'] as $mapTitleGrade) {
                        if ($mapTitleGrade !== null) {
                            MapTitleGrade::create([
                                'title_id' => $title->title_id,   // Use the created mTitle ID
                                'grade_id' => $mapTitleGrade,   // The current grade in the loop
                            ]);
                        }
                    }
                }
            }



            // Redirect or return success message
            return redirect()->route('title')->with('success', 'Title updated successfully.');
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
