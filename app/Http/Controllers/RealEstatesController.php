<?php

namespace App\Http\Controllers;

use App\Models\RealEstate;
use App\Repositories\RealEstateRepository;
use App\Services\GoogleMapsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


final class RealEstatesController extends Controller
{
    /**
     * @var RealEstateRepository
     */
    private $realEstateRepository;

    /**
     * RealEstatesController constructor.
     * @param RealEstateRepository $realEstateRepository
     */
    public function __construct(RealEstateRepository $realEstateRepository)
    {
        $this->realEstateRepository = $realEstateRepository;
    }


    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $realEstates = $this->realEstateRepository->getAll();
            $realEstates->map(function (RealEstate $realEstate) {
                $realEstate->assignCoordinates();
            });

            return response()->json($realEstates);

        } catch (\Exception $exception) {
            return $this->respondWithException($exception);
        }

    }

    /**
     * @param int $id
     * @return JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function show(int $id): JsonResponse
    {
        try {
            /** @var RealEstate $realEstate */
            $realEstate = $this->realEstateRepository->findOneAndCheckIfExists($id);
            $realEstate->assignCoordinates();

            return response()->json($realEstate->toArray());
        } catch (\Exception $exception) {
            return $this->respondWithException($exception);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), RealEstate::$rules);
            $this->checkValidation($validator);

            /** @var RealEstate $realEstate */
            $realEstate = $this->realEstateRepository->create($request->all());
            $realEstate->assignCoordinates();

            return response()->json($realEstate->toArray());
        } catch (\Exception $exception) {
            return $this->respondWithException($exception);
        }
    }
}
