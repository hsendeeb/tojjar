<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ad;
use App\Models\User;
use App\Models\Vehicle;

class AdController extends Controller
{
    public function like(string $id)
    {
        $user = Auth::user();
        $ad = Ad::findOrFail($id);

        $isLiked = $ad->isLikedBy($user);
        if ($isLiked) {
            $ad->likes()->where('user_id', Auth::id())->delete();
            $isLiked = false;
        } else {
            $ad->likes()->create([
                'user_id' => Auth::id(),
                'ad_id' => $ad->id,
            ]);
            $isLiked = true;
        }
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
            'engineSize'
        )->whereHas('ad', function ($q) use ($user) {
            $q->whereHas('likes', function ($q2) use ($user) {
                $q2->where('user_id', $user->id);
            });
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
