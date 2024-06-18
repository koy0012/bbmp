<?php

namespace App\Observers;

use App\Models\Group;
use App\Models\Region;
use Illuminate\Support\Str;

class GroupObserver
{ 

    public function creating(Group $group): void
    {
        $group->id = Str::uuid();
        $group->group_type = Region::class;
    }

    /**
     * Handle the Group "updated" event.
     */
    public function updated(Group $group): void
    {
        //
    }

    /**
     * Handle the Group "deleted" event.
     */
    public function deleted(Group $group): void
    {
        //
    }

    /**
     * Handle the Group "restored" event.
     */
    public function restored(Group $group): void
    {
        //
    }

    /**
     * Handle the Group "force deleted" event.
     */
    public function forceDeleted(Group $group): void
    {
        //
    }
}
