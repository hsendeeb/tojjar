<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CarModelController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AdController;
use App\Http\Controllers\DealerController;
use App\Models\CarModel;
use App\Http\Middleware\admin;
use App\Http\Middleware\useStatus;
use Illuminate\Support\Facades\Route;


Route::get("/", [VehicleController::class, 'index'])
     ->name('dashboard');

Route::get('/blockPage', [AdminController::class, 'blockPage'])->name('blockPage');

Route::middleware('auth')->group(function () {
     Route::get("/profile/{id}", [ProfileController::class, 'index'])->name('profile.index');
     Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
     Route::get("/placeAd", [VehicleController::class, 'create'])->name('placeAdView');
     Route::post("/placeAd", [VehicleController::class, 'store'])->name('placeAd');
     Route::get("/vehicle/edit/{vehicle}", [VehicleController::class, 'edit'])->name('vehicle.edit');
     Route::delete('/vehicle/{vehicle}', [VehicleController::class, 'destroy'])->name('vehicle.destroy');
     Route::put('/vehicle/{vehicle}', [VehicleController::class, 'update'])->name('vehicle.update');
     Route::put("/sold/{id}", [VehicleController::class, 'markAsSold'])->name('markSold');
     Route::put("/available/{id}", [VehicleController::class, 'markAsAvailable'])->name('markAvailable');
     Route::put("/ad/like/{id}", [AdController::class, 'like'])->name('like');

});
     Route::put('/views/{id}',[AdController::class,'incrementViews'])->name('views');
Route::get("/profile/show/{id}", [ProfileController::class, 'show'])->name('profile.show');
Route::get("/get-companies/{id}", [VehicleController::class, 'getCompanies'])->name('getCompanies');
Route::get("/company/show/{name?}", [CompanyController::class, 'show'])->name('company.show');
Route::get("/get-models/{id}", [CarModelController::class, "getModels"])
     ->name("getModels");
Route::get("/get-suggestions/{input}", [CompanyController::class, 'suggest'])
     ->name("suggestions");
Route::post("/vehicles/filter/{category_name?}", [VehicleController::class, 'filteredSearch'])
     ->name('filteredSearch');
     Route::post("/vehicle/filter/{price?}", [VehicleController::class, 'filteredPrice'])
     ->name('filteredPrice');
Route::post('/detect-car', [VehicleController::class, 'detect'])->name('detect.car');
Route::get("/vehicle/show/{vehicle}", [VehicleController::class, 'show'])->name("vehicle.show");
Route::get('/AboutUs', function () {
     return view('aboutUs');
})->name('aboutUs');
Route::get('/dealers', [DealerController::class, 'index'])->name('dealers.index');

Route::middleware(['auth', 'admin'])->group(function () {
     Route::get("/admin", [AdminController::class, 'index'])->name('admin.dashboard');
     Route::get("/admin/show/users", [AdminController::class, 'showUsers'])->name('admin.showUsers');
     Route::get("/admin/show/vehicles", [AdminController::class, 'showVehicles'])->name('admin.showVehicles');
     Route::post("/admin/company", [CompanyController::class, 'store'])->name('company.store');
     Route::post("/admin/model", [CarModelController::class, 'store'])->name('model.store');
     Route::put('/admin/block/{id}', [AdminController::class, 'block'])->name('admin.block');
     Route::put('/admin/unblock/{id}', [AdminController::class, 'unBlock'])->name('admin.unBlock');
     Route::post('/admin', [AdminController::class, 'store'])->name('admin.store');
     Route::get('/admin/show', [AdminController::class, 'showAdmins'])->name('admin.showAdmins');
     Route::delete('/admin/{id}', [AdminController::class, 'destroy'])->name('admin.delete');
     Route::get('/admin/show/dealers', [AdminController::class, 'showDealers'])->name('showDealers');
});




require __DIR__ . '/auth.php';
