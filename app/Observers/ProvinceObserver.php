<?php

namespace App\Observers;

use App\Models\ActivityLog;
use App\Models\Province;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProvinceObserver
{
    public function creating(Province $user): void
    {
        $user->id = Str::uuid();
    }

    /**
     * Handle the Province "created" event.
     */
    public function updating(Province $province): void
    {
        $dirty = $province->getDirty();

        if (array_key_exists('head_user_id', $dirty)) {
            if (empty($dirty['head_user_id'])) {
                ActivityLog::log(
                    Auth::id(),
                    ":user resigned :modifier as head of province `{$province->name}`.",
                    'province_head',
                    json_encode($dirty), 
                    $province->getOriginal('head_user_id'),
                    [
                        "ref_one" => $province->id
                    ]
                );
            } else {
                ActivityLog::log(
                    Auth::id(),
                    ":user promoted :modifier as head of province `{$province->name}`",
                    'province_head',
                    json_encode($dirty),
                    $province->head_user_id,
                    [
                        "ref_one" => $province->id
                    ]
                );
            }
        }
    }

    /**
     * Handle the Province "updated" event.
     */
    public function updated(Province $Province): void
    {
        //
    }

    /**
     * Handle the Province "deleted" event.
     */
    public function deleted(Province $Province): void
    {
        //
    }

    /**
     * Handle the Province "restored" event.
     */
    public function restored(Province $Province): void
    {
        //
    }

    /**
     * Handle the Province "force deleted" event.
     */
    public function forceDeleted(Province $Province): void
    {
        //
    }
}
