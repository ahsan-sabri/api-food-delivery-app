<?php

use App\Http\Controllers\Api\RestaurantController;
use App\Http\Controllers\Api\RiderController;
use Illuminate\Support\Facades\Route;

Route::group(['as' => 'api.'], static function () {
    // create rider
    Route::post('rider', [RiderController::class, 'createRider'])->name('rider.create');
    // create restaurant
    Route::post('restaurant', [RestaurantController::class, 'createRestaurant'])->name('restaurant.create');

    // API to store rider's location
    Route::post('rider/location/store', [RiderController::class, 'storeRiderLocation'])->name('location.store');
    // API to get nearby riders
    Route::get('rider/nearby/restaurant/{restaurant_id}', [RiderController::class, 'getNearbyRider'])->name('rider.nearby');
});
