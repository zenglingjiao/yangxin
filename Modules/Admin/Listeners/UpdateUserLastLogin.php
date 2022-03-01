<?php

namespace Modules\Admin\Listeners;

use Carbon\Carbon;
use Modules\Admin\Events\AdminLogin;
use Modules\Admin\Models\AuthAdmin;
use Modules\Admin\Models\AuthUser;

class UpdateUserLastLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle(AdminLogin $event)
    {
        if ($event->guard === 'auth_admin') {
            AuthAdmin::query()
                ->where('id', $event->user->getAuthIdentifier())
                ->update(['last_login' => Carbon::now()]);
        } elseif ($event->guard === 'store') {
            AuthUser::query()
                ->where('id', $event->user->getAuthIdentifier())
                ->update(['last_login' => Carbon::now()]);
        }
    }
}
