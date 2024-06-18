<?php

namespace App\Observers;

use App\Models\ActivityLog;
use App\Models\Barangay;
use App\Models\Municipal;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */

    public function creating(User $user): void
    {
        $user->id = Str::uuid();
    }

    public function created(User $user): void
    {
        if (isset($user->role)) {
            $user->syncRoles($user->role);
        }
    }


    public function updating(User $user)
    {
        //you're here to add hash::make, it's automatically hash (both creation and update)
        //and if it's not hashing, you're not updating it properly
        //call it Model::where()->first()->update();
        //and not Model::were()->update();
        //
        //@see: https://www.reddit.com/r/laravel/comments/12d7dz1/laravel_observers_whats_the_rule_of_thumb/

        $dirty = $user->getDirty();

        $state = "";
        $text = "";

        if (array_key_exists('password', $dirty)) {
            $state = "password_change";
        } else if (array_key_exists('state', $dirty)) {
            $state = "state_change";
        } else if (Auth::id() != $user->id) {
            $state = "other_modify";
        }

        if (array_key_exists('municipal_id', $dirty) || array_key_exists('region_id', $dirty) || array_key_exists('barangay_id', $dirty)) {
            $bgry = app(Barangay::class)->getRow($user->barangay_id);
            
            $text .= "Transferred to {$bgry->region}, {$bgry->province}, {$bgry->municipal}, {$bgry->name}.";
        }

        if (array_key_exists('role', $dirty)) {
            $is_promoted = array_search(
                $user->getOriginal('role'),
                config('constants.roles')
            ) < array_search(
                $dirty['role'],
                config('constants.roles')
            );

            if ($is_promoted) {
                $text .= "Promoted to {$dirty['role']} from {$user->getOriginal('role')}.";
            } else {
                $text .= "Demoted to {$dirty['role']} from {$user->getOriginal('role')}.";
            }
        }

        foreach ($user->getHidden() as $row) {
            if (array_key_exists($row, $dirty)) {
                unset($dirty[$row]);
            }
        }

        switch ($state) {
            case "password_changed":
                ActivityLog::log($user->id, 'You updated your password.', 'user_update_password');
                break;
            case "other_modify":
                ActivityLog::log(Auth::id(), "You modified :modifier account. $text", 'user_update_by', json_encode($dirty), $user->id);
                ActivityLog::log($user->id, "Your account has been modified by :modifier. $text", 'user_update_by', json_encode($dirty), Auth::id());
                break;
            case "state_change":
                ActivityLog::log(Auth::id(), "You modified :modifier account state to {$dirty['state']}.", "user_state_{$dirty['state']}", json_encode($dirty), $user->id);
                break;
            default:
                ActivityLog::log($user->id, 'Your account has been updated.', 'user_update_self', json_encode($dirty));
                break;
        }
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        if (isset($user->role)) {
            $user->syncRoles($user->role);
        } else {
            die("it ain't working");
        }
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
