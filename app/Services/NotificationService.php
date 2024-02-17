<?php

namespace App\Services;

use App\Models\Notification;

class NotificationService
{
    public static function Notify($userId, $message, $routeName = null, $routeParams = null)
    {
        Notification::create([
            'user_id'      => $userId,
            'message'      => $message,
            'route_name'   => $routeName,
            'route_param'  => $routeParams,
            'read'         => false,
        ]);
    }
}
