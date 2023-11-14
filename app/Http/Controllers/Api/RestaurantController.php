<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRestaurantRequest;
use App\Services\RestaurantService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class RestaurantController extends Controller
{
    public function __construct(private readonly RestaurantService $restaurantService)
    {
        //
    }

    /**
     * Store a newly created restaurant in database.
     */
    public function createRestaurant(StoreRestaurantRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $req = $request->validated();
            $restaurant = $this->restaurantService->createRestaurant($req);

            DB::commit();
            return response()->json([
                'success' => true,
                'data' => $restaurant,
                'message' => 'Restaurant created successfully!'
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
}

