<?php

namespace App\Observers;

use App\Models\ActivityLog;
use App\Models\Region;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RegionObserver
{
    public function creating(Region $user): void
    { 
        $user->id = Str::uuid(); 
    }

    /**
     * Handle the Region "created" event.
     */
    public function created(Region $region): void
    {
        //
    }

    /**
     * Handle the Region "updated" event.
     */
    public function updating(Region $region): void
    {
        $dirty = $region->getDirty();

        if(array_key_exists('head_user_id',$dirty)){
            if(empty($dirty['head_user_id'])){
                ActivityLog::log(
                    Auth::id(),
                    ":user resigned :modifier as head of region `{$region->name}`.",
                    'region_head',
                    json_encode($dirty),
                    $region->getOriginal('head_user_id'),
                    [
                        "ref_one" => $region->id
                    ]
                );
            }else {
                ActivityLog::log(
                    Auth::id(),
                    ":user promoted :modifier as head of region `{$region->name}`",
                    'region_head',
                    json_encode($dirty),
                    $region->head_user_id,
                    [
                        "ref_one" => $region->id
                    ]
                );
            } 
        } 
    }

    /**
     * Handle the Region "deleted" event.
     */
    public function deleted(Region $region): void
    {
        //
    }

    /**
     * Handle the Region "restored" event.
     */
    public function restored(Region $region): void
    {
        //
    }

    /**
     * Handle the Region "force deleted" event.
     */
    public function forceDeleted(Region $region): void
    {
        //
    }
}
