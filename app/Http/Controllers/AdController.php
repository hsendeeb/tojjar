<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ad;

class AdController extends Controller
{
    public function like(string $id){
        $user=Auth::user();
        $ad=Ad::findOrFail($id);
        
        $isLiked=$ad->isLikedBy($user);
        if($isLiked){
            $ad->likes()->where('user_id',Auth::id())->delete();
            $isLiked=false;
                
        } else {
            $ad->likes()->create([
                'user_id'=>Auth::id(),
                'ad_id'=>$ad->id,    
            ]);
            $isLiked=true;
        }
        return response()->json([
                'likes'=>$ad->likes()->count(),
                'isLiked'=>$isLiked
            ]);
    }
    
}
