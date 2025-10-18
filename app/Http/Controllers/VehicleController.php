<?php

namespace App\Http\Controllers;

use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\BodyType;
use App\Models\Category;
use App\Models\Vehicle;
use App\Traits\CachesDropdowns;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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


        $perPage = 10;
        $page = request()->get('page', 1); // Defaults to page 1 if not provided
        $vehicles = Cache::remember('vehicles', now()->addMinutes(10), function () {
            return Vehicle::with([
                'company',
                'body',
                'gearbox',
                'color',
                'fuel',
                'model',
                'category',
                'condition',
                'image',
                'engineType',
                'engineSize'
            ])
                ->when(Auth::check(), function ($query) {
                    $query->where("user_id", "<>", Auth::id());
                })
                ->orderBy('created_at', 'desc') // 👈 Ensures consistent ordering

                ->get();
        });
        
        $paginatedVehicles = new LengthAwarePaginator(
            $vehicles->forPage($page, $perPage),
            $vehicles->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );


        return view("vehicles.index", compact('paginatedVehicles', 'companies', 'categories', 'model'));
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




        return view("vehicles.addVehicle", compact('conditions', 'companies', 'bodyType', 'categories', 'carModel', 'fuelType', 'gearbox', 'colors','engineType','engineSize'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'company_id' => 'required',
            'model_id' => 'required',
            'category_id' => 'required',
            'condition_id' => 'required',
            'year' => 'required',
            'body_id' => 'required',
            'gearbox_id' => 'required',
            'fuel_id' => 'required',
            'mileage' => 'required|min:0',
            'payment' => 'required',
            'color_id' => 'required',
            'location' => ['required', 'string', 'max:100'],
            'price' => ['required', 'integer', 'min:0'],
            'description' => 'required',
            'images' => 'required|min:1',
            'engineSize_id'=>'nullable',
            'engineType_id'=>'required',            
            'user_id' => [Rule::in([Auth::id()])],

        ]);
        $data['user_id'] = Auth::id();
        $vehicle = Vehicle::create($data);
        foreach ($request->file('images') as $image) {
            $path = $image->store("vehicle_images", "public");
            Vehicle_image::create([
                'vehicle_id' => $vehicle->id,
                "image_url" => $path,

            ]);
        }
        return redirect()->route("dashboard");
    }

    /**
     * Display the specified resource.
     */
    public function show(Vehicle $vehicle)
    {
        return view('vehicles.show', compact('vehicle'));
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



        return view('vehicles.edit', compact('vehicle', 'conditions', 'companies', 'bodyType', 'categories', 'carModel', 'fuelType', 'gearbox', 'colors','engineType','engineSize'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        $data = $request->validate([
            'company_id' => 'required',
            'model_id' => 'required',
            'category_id' => 'required',
            'condition_id' => 'required',
            'year' => 'required',
            'body_id' => 'required',
            'gearbox_id' => 'required',
            'fuel_id' => 'required',
            'mileage' => 'required|min:0',
            'payment' => 'required',
            'color_id' => 'required',
            'location' => ['required', 'string', 'max:100'],
            'price' => ['required', 'integer', 'min:0'],
            'description' => 'required',
            'images' => 'required|min:1',
            'engineType_id'=>'required',
            'engineSize_id'=>'nullable', 
            'user_id' => [Rule::in([Auth::id()])],

        ]);
        $data['user_id'] = Auth::id();

        $vehicle->update($data);
        foreach ($request->file('images') as $image) {
            $path = $image->store("vehicle_images", "public");

            Vehicle_image::where("id", $vehicle->id)->update([
                "image_url" => $path,

            ]);
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
            $images = $vehicle->image;
            foreach ($images as $image) {
                $image->delete();
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


    public function detect(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:5120', // max 5MB
        ]);

        $imagePath = $request->file('image')->store('images', 'public');
        $imageUrl = asset('storage/' . $imagePath);

        // Send to Azure Computer Vision API
        $response = Http::withHeaders([
            'Ocp-Apim-Subscription-Key' => env('AZURE_VISION_KEY'),
        ])->post('https://westeurope.api.cognitive.microsoft.com/vision/v3.2/analyze', [
            'url' => $imageUrl,
            'visualFeatures' => 'Tags',
        ]);

        $tags = collect($response->json()['tags'])->pluck('name')->toArray();

        $result = in_array('car', $tags) ? '✅ This image contains a car.' : '❌ No car detected in the image.';

        return back()->with('result', $result);
    }
    public function filteredSearch(Request $request)
    {
        
        $category_id = $request->input("category_id");
        $company_id = $request->input("company_id") ?? null;
        $model_id = $request->input("model_id") ?? null;
        
       
        $vehicles = Vehicle::with(['company', 'body', 'gearbox', 'color', 'fuel', 'model', 'category', 'condition', 'image'])
                ->where("vehicles.user_id", "<>", Auth::id())
               ->when($request->input('category_id'),function($query) use($category_id){
                $query->where("category_id",$category_id);
               })
               ->when($request->input('company_id'),function($query) use($company_id){
                $query->where("company_id",$company_id);
               })
               ->when($request->input('model_id'),function($query) use($model_id){
                $query->where("model_id",$model_id);
               })
                ->get();
              

       
       
            return view('vehicles.company.show', ['vehicles' => $vehicles]);
       
        
    }
}
