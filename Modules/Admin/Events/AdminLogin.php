<?php

namespace Modules\Admin\Events;

use Illuminate\Queue\SerializesModels;

class AdminLogin
{
    use SerializesModels;

    /**
     * The authentication guard name.
     *
     * @var string
     */
    public $guard;

    /**
     * The authenticated user.
     *
     * @var user
     */
    public $user;


    /**
     * Create a new event instance.
     *
     * @param  string  $guard
     * @param  $user
     * @return void
     */
    public function __construct($guard, $user)
    {
        $this->user = $user;
        $this->guard = $guard;
    }

}
