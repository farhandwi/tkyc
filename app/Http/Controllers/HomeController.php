<?php

namespace App\Http\Controllers;

use App\Services\JwtService;
use Illuminate\Http\Request;
use App\Services\ImageService;
use Illuminate\Support\Facades\Log;
use App\Facades\UserContext;

class HomeController extends Controller
{
    protected $imageService;
    protected $jwtService;

    // Combine both services in a single constructor
    public function __construct(ImageService $imageService, JwtService $jwtService)
    {
        $this->imageService = $imageService;
        $this->jwtService = $jwtService;
    }

    public function dashboard()
    {
        return redirect('/home');
    }

    public function index(Request $request)
    {
        $payload = UserContext::getPayload();

        if (!isset($payload['partner'])) {
            $payload['name'] = 'Admin';
        }

        $bp = $payload['partner'];
        $imageData = $this->imageService->fetchImageData($bp);

        return view('home.home', [
            'namaUser' => $payload['name'],
            'imageData' => $imageData,
        ]);
    }
}
