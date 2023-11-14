<?php

namespace App\Services;

use App\Models\Restaurant;
use App\Models\Rider;
use App\Models\RiderLocation;
use Carbon\Carbon;

class RiderService
{
    public function createRider($data)
    {
        return Rider::create($data);
    }

    public function storeRiderLocation($data)
    {
        return RiderLocation::create($data);
    }

    public function nearByRider($restaurantId): array
    {
        $data = [];
        $now = Carbon::now()->format('Y-m-d H:i:s');
        $fiveMinutesBefore = Carbon::now()->subMinutes(5)->format('Y-m-d H:i:s');
        $restaurant = Restaurant::find($restaurantId);
        $ridersOfLastFiveMinutes = RiderLocation::where('capture_time', '<=', $now)
                        ->where('capture_time', '>=', $fiveMinutesBefore)
                        ->get();

        // calculate nearest
        $nearestRider = null;
        $minDistance = PHP_INT_MAX;

        foreach($ridersOfLastFiveMinutes as $rider) {
            // calculate distance of a rider
            $distance = $this->distanceCalculator($restaurant->lat, $rider->lat, $restaurant->long, $rider->long);

            if ($distance < $minDistance) {
                $minDistance = $distance;
                $nearestRider = $rider;
            }
        }

        if ($nearestRider) {
            $data['rider_name'] = $nearestRider->rider->name;
            $data['min_distance'] = $minDistance;
        }


        return $data;

    }

    public function distanceCalculator($latRes, $latRider, $longRes, $longRider): float|int
    {
        //
    }
}
