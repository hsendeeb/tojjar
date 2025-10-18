<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
          $company_name=$request->input('company_name');
        Company::create([
            'company_name'=>$company_name
        ]);
        return redirect()->back()->with('created','created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request,?string $Cname=null)
    {
        $page = request()->get('page', 1);
       $name = $request->input("company_name") ?: $Cname;
       $cacheKey="company.search.{$page}".md5($name);

$vehicles = Cache::remember( $cacheKey,"2800",function () use($page,$name) {
    
     return Vehicle::with(['company', 'body', 'gearbox', 'color', 'fuel', 'model', 'category', 'condition', 'image'])
    ->where("user_id", "<>", Auth::id())
    ->whereHas('company', function ($query) use ($name) {
        $query->where('company_name', 'LIKE', '%' . $name . '%');
    })
    ->paginate(20, ['*'], 'page', $page);
});
        if ($vehicles->isNotEmpty()) {
            return view('vehicles.company.show', ['vehicles' => $vehicles]);
        } else {
            return redirect()->back()->with("notFound","No results");
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function suggest($input)
    {
        $suggestion = Company::where("company_name", "like", $input . "%")->get();

        return response()->json($suggestion);
    }
  
}
