<?php

namespace App\Observers;

use App\Models\ActivityLog;
use App\Models\UserInfo;
use Illuminate\Support\Facades\Auth;

class UserInfoObserver
{
    /**
     * Handle the UserInfo "created" event.
     */
    public function created(UserInfo $userInfo): void
    {
        //
    }

    /**
     * Handle the UserInfo "updated" event.
     */
    public function updating(UserInfo $userInfo): void
    {
        $dirty = $userInfo->getDirty();
        $state = "";
        $text = "";

        if (Auth::id() != $userInfo->user_id) {
            $state = "other_modify";
        }

        if(array_key_exists('position',$dirty)){
            if(empty($dirty['dirty'])){
                $text .= "Member position removed/cleared.";
            }else {
                $text .= "Member position was changed to `{$dirty['position']}`.";
            }
            
        }


        switch ($state) {
            case "other_modify":
                ActivityLog::log(Auth::id(), "You modified :modifier personal info. $text", 'user_update_by', json_encode($dirty), $userInfo->user_id);
                ActivityLog::log($userInfo->user_id, "Your personal info has been modified by :modifier. $text", 'user_update_by', json_encode($dirty), Auth::id());
                break;
            default:
                ActivityLog::log($userInfo->user_id, "Your personal info has been updated. $text", 'user_update_self', json_encode($dirty));
                break;
        }
    }

    /**
     * Handle the UserInfo "deleted" event.
     */
    public function deleted(UserInfo $userInfo): void
    {
        //
    }

    /**
     * Handle the UserInfo "restored" event.
     */
    public function restored(UserInfo $userInfo): void
    {
        //
    }

    /**
     * Handle the UserInfo "force deleted" event.
     */
    public function forceDeleted(UserInfo $userInfo): void
    {
        //
    }
}
