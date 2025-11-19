<?php

namespace App\Http\Controllers;

use App\Mail\RejectedSubscription;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Encoders\JpegEncoder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SubscriptionEmail;
use App\Mail\RenewSubscription;
use App\Models\User;
use App\Models\Dealer;
use App\Models\Vehicle;
use App\Models\Company;
use App\Models\Ad;
use App\Models\Admin;
use App\Models\PaymentRequest;
use App\Models\Subscription;
use phpDocumentor\Reflection\PseudoTypes\True_;
use function Pest\Laravel\instance;
use Illuminate\Validation\Rules;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;



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
        $paymentRequests=PaymentRequest::with('user')
        ->where('status','LIKE','pending')
        ->get();
        $premiumUsers=Subscription::with('user')
        ->where('is_active',true)
        ->get();
        $boostedAds=Ad::with('vehicle','user','likes')
        ->where('boosted',true)
        ->get();
        return view('admin.dashboard',compact('users','vehicles','companies','dealers','paymentRequests','premiumUsers','boostedAds'));
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
            'username'=>['unique:users','required','string','max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => [
        'required',
        'string',
        'regex:/^(?:\+961|961|0)?(3|70|71|76|78|79|81|82|83|84|85|88|89)\d{6}$/',
        'unique:users,phone',
    ],
    'account_type'=>'nullable',


            'password' => ['required', Rules\Password::defaults()],
        ]);
        $data['account_type']='admin';
        $user=User::create($data  );
                      
     
        
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
                'engineSize',
                'ad',
                'ad.likes'
            ])->get();
            return view('admin.showVehicles',compact('records','companies'));
    }
    public function block(string $id){
        $user=User::findOrFail($id);
        $user->status="blocked";
        $user->blocked_at=Carbon::now();
        DB::table('sessions')->where('user_id', $user->id)->delete();

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
  public function showPaymentRequests() {
        $records=PaymentRequest::with('user')
        ->orderByDesc('created_at')
        ->get();
        
        $companies=Company::all();
        return view('admin.showPaymentRequests',compact('records','companies'));
}
public function showPremiumUsers() {
     $companies=Company::all();
     $records=Subscription::with('user')
        ->where('is_active',true)
        ->get();
        return view('admin.showPremiumUsers',compact('records','companies'));
}
public function payment(Request $request) {
    $user=Auth::user();
    $request->validate([
        'proof'=>'required|image'
    ]);
    try {
                        $filename = uniqid() . '.jpg';
                        $imageInstance = Image::read($request->file('proof'));
                        // Resize to desired output size (e.g. 600x800)
                        $imageInstance = $imageInstance->scale(600,800);
                        // Encode and save
                        $optimized = $imageInstance->encode(new JpegEncoder(quality: 80));
                        Storage::disk('public')->put("invoices/{$filename}", (string) $optimized);
    } catch(\Throwable $e) {
        Log::warning('Image optimization failed: ' . $e->getMessage());
    }
  
    PaymentRequest::create([
        'user_id'=>$user->id,
        'plan'=>'premium',
        'amount'=>20.00,
        'invoice_image'=>"invoices/{$filename}",
        'status'=>'pending'
    ]);
    return redirect()->back()->with('success','payment request submitted.');

}
public function accept(string $id,string $user_id){
    $user=User::findOrFail($user_id);
    
    // Find existing subscription (active or inactive)
    $existingSubscription = Subscription::where('user_id', $user->id)
        ->latest('ends_at')
        ->first();

    if ($existingSubscription) {
        if ($existingSubscription->is_active) {
            // If subscription is still active, extend it
            $subscribed = $existingSubscription->update([
                'ends_at' => Carbon::parse($existingSubscription->ends_at)->addMonth(),
                'is_active' => true
            ]);
              Mail::to($user->email)->send(new RenewSubscription($user));
        } else {
            // If subscription exists but is inactive, start new period from now
            $subscribed = $existingSubscription->update([
                'starts_at' => now(),
                'ends_at' => now()->addMonth(),
                'is_active' => true
            ]);
              Mail::to($user->email)->send(new SubscriptionEmail($user));
           
        }
    } else {
        // If user never had a subscription, create new one
        $subscribed = Subscription::create([
            'user_id' => $user->id,
            'plan' => 'premium',
            'starts_at' => now(),
            'ends_at' => now()->addMonth(),
            'is_active' => true
        ]);
        Mail::to($user->email)->send(new SubscriptionEmail($user));
      
        
    }

    if($subscribed) {
        $paymentRequest = PaymentRequest::findOrFail($id);
        $paymentRequest->update(['status' => 'approved']);
        $user->update(['premium' => true]);
          
    }
    return redirect()->back();
 
}
public function reject(string $id) {
    $paymentRequest=PaymentRequest::findOrFail($id);
    $paymentRequest->update(['status'=>'rejected']);
    Mail::to($paymentRequest->user->email)->send(new RejectedSubscription($paymentRequest->user));
    return redirect()->back();
}
public function showBoostedAds(){
    $companies=Company::all();
     $records=Ad::with('vehicle','user','likes')
        ->where('boosted',true)
        ->orderByDesc('boosted_at')
        ->get();
        return view('admin.showBoostedAds',compact('records','companies'));
}
}