<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Exception;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class NotificationController extends Controller
{
    public function read(Request $request): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $request->validate([
            'id' => 'required|integer',
        ]);

        $id = $request->input('id');

        try {
            $notification = Notification::findOrFail($id);
            $this->authorize('read', $notification);

            $notification->read = true;
            $notification->save();
        } catch (Exception) {
            return response('Notification could not be read');
        }

        return response('Notification read');
    }
}
