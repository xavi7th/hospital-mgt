<?php

namespace App\Modules\Nurse\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class VitalsPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
}
