<?php

use App\Notification;

/**
 * @return list<Notification>
 */
function notifications(): array
{
    return Notification::all();
}
