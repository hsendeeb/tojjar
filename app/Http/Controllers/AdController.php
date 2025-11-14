<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Models\Ad;
use App\Models\User;
use App\Models\Vehicle;

class AdController extends Controller
{
    public function like(string $id)
    {
        DB::listen(function($query) {
            Log::info($query->sql);
        });
        $user = Auth::user();
        $ad = Ad::findOrFail($id);

        $isLiked = $ad->isCurrentUserLike();
       
        
        if ($isLiked) {
            $ad->likes()->where('user_id', Auth::id())->delete();
            $isLiked = false;
        } else {
            $ad->likes()->create([
                'user_id' => Auth::id(),
                'ad_id' => $ad->id,
                'liked_at'=>now()
            ]);
            $isLiked = true;
        }
       Cache::forget('vehicles');
        return response()->json([
            'likes' => $ad->likes()->count(),
            'isLiked' => $isLiked
        ]);
    }
    public function incrementViews(string $id)
    {
        Ad::where('id', $id)->increment('views');
        $ad = Ad::findOrFail($id);
        return response()->json(["views" => $ad->views]);
    }
    public function likedAds(string $id)
    {
        $user = User::findOrFail($id);
        $vehicles = Vehicle::with(
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
        )->whereHas('ad.likes', function ($q) use ($user) {
                $q->where('user_id', $user->id)
                ->orderByDesc('liked_at');
               
        })->get();

        return view('vehicles.likedAds', compact("vehicles"));
    }
    public function boost(string $id)
    {
        $user = Auth::user();
        if ($user->premium) {
            $ad = Ad::findOrFail($id);
            if (!$ad->boosted) {
                $ad->boosted = true;
                $ad->boosted_at=now();
                $ad->save();
                Cache::forget('vehicles');
                Cache::forget('filteredVehicles');
                return response()->json([
                    'boosted' => $ad->boosted,
                    'premium' => $user->premium
                ]);
            } else {
                return response()->json('ad is already boosted');
            }
        }
    }
}
