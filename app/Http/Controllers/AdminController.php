<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Dealer;
use App\Models\Vehicle;
use App\Models\Company;
use App\Models\Admin;
use function Pest\Laravel\instance;
use Illuminate\Validation\Rules;
use Carbon\Carbon;



class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users=User::all();
        $vehicles=Vehicle::all();
        $companies=Company::all();
        $dealers=Dealer::all();
        return view('admin.dashboard',compact('users','vehicles','companies','dealers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }
    public function blockPage(){
        return view('blockPage');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data=$request->validate([
             'name' => ['required', 'string', 'max:255'],
            'last_name'=>['required','string','max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => [
        'required',
        'string',
        'regex:/^(?:\+961|961|0)?(3|70|71|76|78|79|81|82|83|84|85|88|89)\d{6}$/',
        'unique:users,phone', // Adjust 'users' and 'phone' to your table and column
    ],


            'password' => ['required', Rules\Password::defaults()],
        ]);
        $user=User::create($data);
       Admin::create([
            'user_id'=>$user->id,
        ]);
        return back()->with('created','created successfully');
        
      
    }

    /**
     * Display the specified resource.
     */
    public function showUsers()
    {
        
             $records=User::all();
             $companies=Company::all();
              return view('admin.showUsers',compact('records','companies'));
      
          
            

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
        $admin=Admin::findOrFail($id);
        $admin->delete();
        return back()->with('deleted','Deleted successfully');
    }
    public function showVehicles(){
        $companies=Company::all();
        $records=Vehicle::with([
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
                'engineSize'
            ])->get();
            return view('admin.showVehicles',compact('records','companies'));
    }
    public function block(string $id){
        $user=User::findOrFail($id);
        $user->status="blocked";
        $user->blocked_at=Carbon::now();
        $user->save();
        return redirect()->back();

    }
     public function unBlock(string $id){
        $user=User::findOrFail($id);
        $user->status="active";
        $user->blocked_at=null;
        $user->save();
        return redirect()->back();

    }
    public function showAdmins(){
        $companies=Company::all();
        $admins=Admin::with('user')->get();
        return view('admin.showAdmins',compact('admins','companies'));
    }
     public function showDealers() {
        $dealers=Dealer::with('user')->get();
        $companies=Company::all();
        return view('admin.showDealers',compact('dealers','companies'));
}
}
