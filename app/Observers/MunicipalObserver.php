<?php

namespace App\Observers;

use App\Models\ActivityLog;
use App\Models\Municipal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class MunicipalObserver
{
    public function creating(Municipal $user): void
    {
        $user->id = Str::uuid();
    }

    /**
     * Handle the Municipal "created" event.
     */
    public function created(Municipal $municipal): void
    {
        //
    }

    /**
     * Handle the Municipal "updated" event.
     */
    public function updating(Municipal $municipal): void
    {
        $dirty = $municipal->getDirty();

        if (array_key_exists('head_user_id', $dirty)) {
            if (empty($dirty['head_user_id'])) {
                ActivityLog::log(
                    Auth::id(),
                    ":user resigned :modifier as head of municipal `{$municipal->name}`.",
                    'municipal_head',
                    json_encode($dirty),
                    $municipal->getOriginal('head_user_id'),
                    [
                        "ref_one" => $municipal->id
                    ]
                );
            } else {
                ActivityLog::log(
                    Auth::id(),
                    ":user promoted :modifier as head of municipal `{$municipal->name}`",
                    'municipal_head',
                    json_encode($dirty),
                    $municipal->head_user_id,
                    [
                        "ref_one" => $municipal->id
                    ]
                );
            }
        }
    }

    /**
     * Handle the Municipal "deleted" event.
     */
    public function deleted(Municipal $municipal): void
    {
        //
    }

    /**
     * Handle the Municipal "restored" event.
     */
    public function restored(Municipal $municipal): void
    {
        //
    }

    /**
     * Handle the Municipal "force deleted" event.
     */
    public function forceDeleted(Municipal $municipal): void
    {
        //
    }
}
