<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRiderLocationRequest;
use App\Http\Requests\StoreRiderRequest;
use App\Models\Restaurant;
use App\Services\RiderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class RiderController extends Controller
{
    public function __construct(private readonly RiderService $riderService)
    {
        //
    }

    /**
     * Store a newly created rider in database.
     */
    public function createRider(StoreRiderRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $req = $request->validated();
            $rider = $this->riderService->createRider($req);

            DB::commit();
            return response()->json([
                'success' => true,
                'data' => $rider,
                'message' => 'Rider created successfully!'
            ])->setStatusCode(ResponseAlias::HTTP_CREATED);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'issue' => $e->getMessage(),
                'message' => 'Something went wrong!'
            ])->setStatusCode(ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a rider location in database.
     */
    public function storeRiderLocation(StoreRiderLocationRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $req = $request->validated();
            $rider = $this->riderService->storeRiderLocation($req);

            DB::commit();
            return response()->json([
                'success' => true,
                'data' => $rider,
                'message' => 'Rider created successfully!'
            ])->setStatusCode(ResponseAlias::HTTP_CREATED);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'issue' => $e->getMessage(),
                'message' => 'Something went wrong!'
            ])->setStatusCode(ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getNearbyRider($restaurantId): JsonResponse
    {
        try {
            $nearbyRider = $this->riderService->nearByRider($restaurantId);

            return response()->json([
                'success' => true,
                'data' => $nearbyRider,
                'message' => 'Nearby rider selected!'
            ])->setStatusCode(ResponseAlias::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'issue' => $e->getMessage(),
                'message' => 'Something went wrong!'
            ])->setStatusCode(ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
