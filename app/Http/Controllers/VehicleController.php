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
use App\Models\Like;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\EngineType;
use App\Models\Dealer;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Log;

use Intervention\Image\Encoders\JpegEncoder;

class VehicleController extends Controller

{
    use CachesDropdowns;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Cache::remember('categories', now()->addMinutes(30), fn() =>  Category::all());
        $companies = Cache::remember('companies', now()->addMinutes(30), fn() =>  Company::all());
        $model = Cache::remember('models', now()->addMinutes(30), fn() =>  CarModel::all());
        $dealers = Dealer::with('user')
            ->where('dealers.user_id', '<>', Auth::id())
            ->get();

        $paginatedVehicles = Vehicle::with([
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
                'ad.likes',
                'user'

            ])
                ->join('ads', 'ads.vehicle_id', 'vehicles.id')
                ->where('ads.boosted', true)
                ->when(Auth::check(), function ($query) {
                    $query->where("vehicles.user_id", "<>", Auth::id());
                })
                ->orderByDesc('ads.boosted_at')
                ->select('vehicles.*')
        
                ->paginate(20);
    

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
            'title' => 'nullable',
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
            'images' => 'required|array|min:1|max:10',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:5048',

            'engineSize_id' => 'nullable',
            'engineType_id' => 'required',
            'user_id' => [Rule::in([Auth::id()])],

        ]);
        if ($data['company_id'] == "other") {

            $newCompany = trim(strtolower($request->input('new-company')));
            $newModel = $request->input('new-model');
            $company = Company::UpdateOrCreate(
                ['company_name' => $newCompany],
                ['company_name' => $newCompany]
            );
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
            try {

                $filename = uniqid() . '.jpg';


                $imageInstance = Image::read($image);


                // Resize to desired output size (e.g. 600x800)
                $imageInstance = $imageInstance->scale(600, 800);

                // Encode and save
                $optimized = $imageInstance->encode(new JpegEncoder(quality: 80));
                Storage::disk('public')->put("vehicle_images/{$filename}", (string) $optimized);

                $optimizedSize = Storage::disk('public')->size("vehicle_images/{$filename}");



                Vehicle_image::create([
                    'vehicle_id' => $vehicle->id,
                    'image_url' => "vehicle_images/{$filename}",
                ]);
            } catch (\Throwable $e) {
                Log::warning('Image optimization failed: ' . $e->getMessage());
            }
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
        try {

            $image_id = $request->input('image_id');
            $data = $request->validate([
                'company_id' => 'required',
                'model_id' => 'nullable',
                'title' => 'nullable',
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
                'images' => 'array|min:1|max:10',
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5048',
                'engineType_id' => 'required',
                'engineSize_id' => 'nullable',
                'user_id' => [Rule::in([Auth::id()])],

            ]);
            $data['user_id'] = Auth::id();
            $hasExistingImages = $vehicle->images()->exists(); // assuming a relation like $ad->images()

            if (!$hasExistingImages && !$request->hasFile('images')) {
                return back()->withErrors(['images' => 'At least one image is required.']);
            }


            $vehicle->update($data);
            if ($request->file('images')) {
                foreach ($request->file('images') as $image) {
                    try {
                        $filename = uniqid() . '.jpg';
                        $imageInstance = Image::read($image);
                        // Resize to desired output size (e.g. 600x800)
                        $imageInstance = $imageInstance->scale(600, 800);
                        // Encode and save
                        $optimized = $imageInstance->encode(new JpegEncoder(quality: 80));
                        Storage::disk('public')->put("vehicle_images/{$filename}", (string) $optimized);;
                        $optimizedSize = Storage::disk('public')->size("vehicle_images/{$filename}");


                        $vehicle->images()
                            ->create([
                                "image_url" => "vehicle_images/{$filename}",


                            ]);
                    } catch (\Throwable $e) {
                        Log::warning('Image optimization failed: ' . $e->getMessage());
                    }
                }
            } else {
            }

            return redirect()->route('profile.index', Auth::id());
        } catch (\Illuminate\Http\Exceptions\PostTooLargeException $ex) {
            Log::info($ex->getMessage());
            return redirect()->back()->withErrors([' Something went wrong while uploading the file.']);
        }
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
        $categories = Cache::remember('categories', now()->addMinutes(30), fn() =>  Category::all());
        $companies = Cache::remember('companies', now()->addMinutes(30), fn() =>  Company::all());
        $model = Cache::remember('models', now()->addMinutes(30), fn() =>  CarModel::all());
        $colors = Color::all();
        $locations = DB::select('SELECT CONCAT(city,",",country) as location  FROM locations');

        $category_id = $request->input("category_id");
        $company_id = $request->input("company_id") ?? null;
        $company_name = $request->input("company_name") ?? null;
        $model_id = $request->input("model_id") ?? null;
        $price = $request->input('price') ?? null;
        $fixedPrice = $request->input('fixedPrice') ?? null;
        $yearFrom = $request->input('yearFrom') ?? null;
        $yearTo = $request->input('yearTo') ?? null;
        $color = $request->input('color') ?? null;
        $location = $request->input('location') ?? null;
        $vehicles = Vehicle::with(['company', 'body', 'gearbox', 'color', 'fuel', 'model', 'category', 'condition', 'images', 'ad', 'ad.likes', 'user'])
            ->join('ads', 'ads.vehicle_id', 'vehicles.id')
            ->where("vehicles.user_id", "<>", Auth::id())
            ->when($request->input('category_id'), function ($query) use ($category_id) {
                $query->where("category_id", $category_id);
            })
            ->when($request->input('price'), function ($query) use ($price) {
                $query->where("price", "<=", $price);
            })
            ->when($request->input('fixedPrice'), function ($query) use ($fixedPrice) {
                $query->where("price", "<=", $fixedPrice);
            })

            ->when($request->input('company_id'), function ($query) use ($company_id) {
                $query->where("company_id", $company_id);
            })
            ->when($request->input('company_name'), function ($query) use ($company_name) {
                $query->with("company")
                    ->whereHas('company', function ($q) use ($company_name) {
                        $q->where('company_name', 'LIKE', '%' . $company_name . '%');
                    });
            })
            ->when($request->input('model_id'), function ($query) use ($model_id) {
                $query->where("model_id", $model_id);
            })
            ->when(!empty($c_id), function ($query) use ($c_id) {
                $query->where("category_id", $c_id);
            })
            ->when($yearFrom, function ($query) use ($yearFrom) {
                $query->where("year", '>=', $yearFrom);
            })
            ->when($yearTo, function ($query) use ($yearTo) {
                $query->where("year", '<=', $yearTo);
            })

            ->when($location, function ($query) use ($location) {
                $query->where("location", 'LIKE', $location);
            })
            ->when($color, function ($query) use ($color) {
                $query->with("color")
                    ->whereHas('color', function ($q) use ($color) {
                        $q->where('colors.color', "LIKE", $color);
                    });
            })

            ->orderByDesc('ads.boosted_at')
            ->select('vehicles.*')
            ->paginate(20)->appends($request->query());
        return view('vehicles.filter', compact('vehicles', 'categories', 'colors', 'locations'));
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
    
    public function deleteImage(string $id)
    {
        $image = Vehicle_image::findOrFail($id);
        $status = $image->delete();
        return response()->json($status);
    }
}
