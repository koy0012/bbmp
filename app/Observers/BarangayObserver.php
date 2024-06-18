<?php

namespace App\Observers;

use App\Models\ActivityLog;
use App\Models\Barangay;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BarangayObserver
{
    public function creating(Barangay $user): void
    {
        $user->id = Str::uuid();
    }

    /**
     * Handle the Barangay "created" event.
     */
    public function created(Barangay $Barangay): void
    {
        //
    }

    /**
     * Handle the Barangay "updated" event.
     */
    public function updating(Barangay $barangay): void
    {
        $dirty = $barangay->getDirty();

        if (array_key_exists('head_user_id', $dirty)) {
            if (empty($dirty['head_user_id'])) {
                ActivityLog::log(
                    Auth::id(),
                    ":user resigned :modifier as head of barangay `{$barangay->name}`.",
                    'barangay_head',
                    json_encode($dirty),
                    $barangay->getOriginal('head_user_id'),
                    [
                        "ref_one" => $barangay->id
                    ]
                );
            } else {
                ActivityLog::log(
                    Auth::id(),
                    ":user promoted :modifier as head of barangay `{$barangay->name}`",
                    'barangay_head',
                    json_encode($dirty),
                    $barangay->head_user_id,
                    [
                        "ref_one" => $barangay->id
                    ]
                );
            }
        }
    }

    /**
     * Handle the Barangay "deleted" event.
     */
    public function deleted(Barangay $Barangay): void
    {
        //
    }

    /**
     * Handle the Barangay "restored" event.
     */
    public function restored(Barangay $Barangay): void
    {
        //
    }

    /**
     * Handle the Barangay "force deleted" event.
     */
    public function forceDeleted(Barangay $Barangay): void
    {
        //
    }
}
