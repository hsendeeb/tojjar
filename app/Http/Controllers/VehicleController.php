<?php

namespace App\Http\Controllers;

use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\BodyType;
use App\Models\Category;
use App\Models\Vehicle;
use App\Models\Ad;
use App\Traits\CachesDropdowns;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Company;
use App\Models\CarModel;
use App\Models\Gearbox;
use App\Models\FuelType;
use App\Models\Color;
use App\Models\Condition;
use App\Models\EngineSize;
use App\Models\Vehicle_image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\EngineType;
use App\Models\Dealer;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Illuminate\Support\Facades\Log;

class VehicleController extends Controller

{
    use CachesDropdowns;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        $companies = Company::all();
        $model = CarModel::all();
        $dealers = Dealer::with('user')
            ->where('dealers.user_id', '<>', Auth::id())
            ->get();


        $perPage = 10;
        $page = request()->get('page', 1); // Defaults to page 1 if not provided
        $vehicles = Cache::remember('vehicles', now()->addMinutes(30), function () {
            return Vehicle::with([
                'company',
                'body',
                'gearbox',
                'color',
                'fuel',
                'model',
                'category',
                'condition',
                'images',
                'engineType',
                'engineSize',
                'ad',
                'user'

            ])
                ->join('ads', 'ads.vehicle_id', 'vehicles.id')
                ->where('ads.boosted', true)
                ->when(Auth::check(), function ($query) {
                    $query->where("vehicles.user_id", "<>", Auth::id());
                })
                ->orderByDesc('ads.boosted_at')
                ->select('vehicles.*')
                // 👈 Ensures consistent ordering
                ->get();
        });


        $paginatedVehicles = new LengthAwarePaginator(
            $vehicles->forPage($page, $perPage),
            $vehicles->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );



        return view("vehicles.index", compact('paginatedVehicles', 'companies', 'categories', 'model', 'dealers'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = $this->cacheDropdown('companies', 30, fn() => Company::all());
        $bodyType = $this->cacheDropdown('body_types', 30, fn() => BodyType::all());
        $conditions = $this->cacheDropdown('conditions', 30, fn() => Condition::all());
        $colors = $this->cacheDropdown('colors', 30, fn() => Color::all());
        $categories = $this->cacheDropdown('categories', 30, fn() => Category::all());
        $gearbox = $this->cacheDropdown('gearboxes', 30, fn() => Gearbox::all());
        $carModel = $this->cacheDropdown('carModels', 30, fn() => CarModel::all());
        $fuelType = $this->cacheDropdown('fuel_types', 30, fn() => FuelType::all());
        $engineType = $this->cacheDropdown('engineType', 30, fn() => EngineType::all());
        $engineSize = $this->cacheDropdown('engineSize', 30, fn() => EngineSize::all());
        $locations =
            $locations = DB::select('SELECT CONCAT(city,",",country) as location  FROM locations');



        return view("vehicles.addVehicle", compact('locations', 'conditions', 'companies', 'bodyType', 'categories', 'carModel', 'fuelType', 'gearbox', 'colors', 'engineType', 'engineSize'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'company_id' => 'nullable',
            'model_id' => 'nullable',
            'category_id' => 'required',
            'condition_id' => 'nullable',
            'year' => 'required',
            'body_id' => 'required',
            'gearbox_id' => 'required',
            'fuel_id' => 'required',
            'mileage' => 'required|min:0',
            'color_id' => 'required',
            'location' => ['required', 'string', 'max:100'],
            'price' => ['required', 'integer', 'min:0'],
            'description' => 'required',
            'images' => 'required|min:1',
            'engineSize_id' => 'nullable',
            'engineType_id' => 'required',
            'user_id' => [Rule::in([Auth::id()])],

        ]);
        if ($data['company_id'] == "other") {
            $newCompany = $request->input('new-company');
            $newModel = $request->input('new-model');
            $company = Company::create([
                'company_name' => $newCompany
            ]);
            $model = CarModel::Create([
                'model_name' => $newModel,
                'company_id' => $company->id
            ]);
            $data['company_id'] = $company->id;
            $data['model_id'] = $model->id;
        }
        $data['user_id'] = Auth::id();
        $vehicle = Vehicle::create($data);
        foreach ($request->file('images') as $image) {
            $path = $image->store("vehicle_images", "public");

            // optimize the stored image if optimizer is available
            $fullPath = storage_path('app/public/' . $path);
            try {
                OptimizerChainFactory::create()->optimize($fullPath);
            } catch (\Throwable $e) {
                // don't break the upload process if optimizer/binaries aren't available
                Log::warning('Image optimization failed: ' . $e->getMessage());
            }

            Vehicle_image::create([
                'vehicle_id' => $vehicle->id,
                "image_url" => $path,

            ]);
            
        }
        Ad::create([
                'user_id' => Auth::id(),
                'vehicle_id' => $vehicle->id,
                'views' => 0,
                'boosted' => false,
            ]);
        return redirect()->route("dashboard");
    }

    /**
     * Display the specified resource.
     */
    public function show(Vehicle $vehicle)
    {

        return view(
            'vehicles.show',
            compact(
                'vehicle',

            )
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vehicle $vehicle)
    {
        $companies = $this->cacheDropdown('companies', 30, fn() => Company::all());
        $bodyType = $this->cacheDropdown('body_types', 30, fn() => BodyType::all());
        $conditions = $this->cacheDropdown('conditions', 30, fn() => Condition::all());
        $colors = $this->cacheDropdown('colors', 30, fn() => Color::all());
        $categories = $this->cacheDropdown('categories', 30, fn() => Category::all());
        $gearbox = $this->cacheDropdown('gearboxes', 30, fn() => Gearbox::all());
        $carModel = $this->cacheDropdown('carModels', 30, fn() => CarModel::all());
        $fuelType = $this->cacheDropdown('fuel_types', 30, fn() => FuelType::all());
        $engineType = $this->cacheDropdown('engineType', 30, fn() => EngineType::all());
        $engineSize = $this->cacheDropdown('engineSize', 30, fn() => EngineSize::all());
        $locations = Vehicle::where('user_id', Auth::id())->get('location');


        return view('vehicles.edit', compact('locations', 'vehicle', 'conditions', 'companies', 'bodyType', 'categories', 'carModel', 'fuelType', 'gearbox', 'colors', 'engineType', 'engineSize'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        $image_id = $request->input('image_id');
        $data = $request->validate([
            'company_id' => 'required',
            'model_id' => 'required',
            'category_id' => 'required',
            'condition_id' => 'nullable',
            'year' => 'required',
            'body_id' => 'required',
            'gearbox_id' => 'required',
            'fuel_id' => 'required',
            'mileage' => 'required|min:0',
            'color_id' => 'required',
            'location' => ['required', 'string', 'max:100'],
            'price' => ['required', 'integer', 'min:0'],
            'description' => 'required',
            'images' => 'nullable',
            'engineType_id' => 'required',
            'engineSize_id' => 'nullable',
            'user_id' => [Rule::in([Auth::id()])],

        ]);
        $data['user_id'] = Auth::id();

        $vehicle->update($data);
        if ($request->file('images')) {


            foreach ($request->file('images') as $image) {
                $path = $image->store("vehicle_images", "public");
                Vehicle_image::where("vehicle_id", $vehicle->id)
                    ->where('id', $image_id)
                    ->updateOrCreate([
                        "id" => $image_id,
                        "image_url" => $path,
                        "vehicle_id" => $vehicle->id

                    ]);
            }
        }

        return redirect()->route('profile.index', Auth::id());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehicle $vehicle)
    {
        $user_id = $vehicle->user->id;
        if ($user_id == Auth::id()) {
            $images = $vehicle->images;
            foreach ($images as $image) {
                $image->delete();
                Storage::delete($image);
            }
            $vehicle->delete();
            return redirect()->back()->with("deleteMessage", "vehicle deleted");
        } else {
            abort(403, "Unauthorized");
        }
    }
    public function getCompanies(string $id)
    {
        $companies = Vehicle::rightJoin('companies', 'company_id', '=', 'companies.id')
            ->where(function ($query) use ($id) {
                $query->where('vehicles.category_id', $id)
                    ->orWhereNull('companies.id');
            })
            ->select('companies.id', 'company_name', 'vehicles.category_id')
            ->distinct()
            ->get();



        $data = response()->json($companies);
        return $data;
    }


  
    public function filteredSearch(Request $request, ?string $category_name = null)
    {
        if ($category_name) {
            $c_id = Category::where('category', 'LIKE', $category_name)->first()?->id;
        } else {
            $c_id = null;
        }
        $categories = Category::all();
        $companies = Company::all();
        $model = CarModel::all();

        $category_id = $request->input("category_id");
        $company_id = $request->input("company_id") ?? null;
        $model_id = $request->input("model_id") ?? null;
        $vehicles = Vehicle::with(['company', 'body', 'gearbox', 'color', 'fuel', 'model', 'category', 'condition', 'images', 'ad'])
            ->join('ads', 'ads.vehicle_id', 'vehicles.id')
            ->where("vehicles.user_id", "<>", Auth::id())
            ->when($request->input('category_id'), function ($query) use ($category_id) {
                $query->where("category_id", $category_id);
            })

            ->when($request->input('company_id'), function ($query) use ($company_id) {
                $query->where("company_id", $company_id);
            })
            ->when($request->input('model_id'), function ($query) use ($model_id) {
                $query->where("model_id", $model_id);
            })
            ->when(!empty($c_id), function ($query) use ($c_id) {
                $query->where("category_id", $c_id);
            })

            ->orderByDesc('ads.boosted_at')
            ->select('vehicles.*')

            ->get();
        return view('vehicles.filter', compact('vehicles', 'model', 'companies', 'categories'));
    }
    public function markAsSold(string $id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->available = false;
        $vehicle->save();

        // Dispatch deletion job after 1 day
        \App\Jobs\DeleteVehicleJob::dispatch($vehicle->id)
            ->delay(now()->addDays(1));

        return back();
    }
    public function markAsAvailable(string $id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->available = true;
        $vehicle->save();
        return back();
    }
    public function filteredPrice(?int $price = null)
    {
        $categories = Category::all();
        $companies = Company::all();
        $model = CarModel::all();

        $vehicles = Vehicle::where('price', '<=', 2000)->get();


        return view('vehicles.filter', compact('vehicles', 'categories', 'companies', 'model'));
    }
    public function deleteImage(string $id)
    {
        $image = Vehicle_image::findOrFail($id);
        $status = $image->delete();
        return response()->json($status);
    }
}
