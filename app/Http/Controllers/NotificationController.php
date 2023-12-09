<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class NotificationController extends Controller
{
    public function read(Request $request)
    {
        $id = $request->get('id');
        $notification = Notification::findOrFail($id);
        $this->authorize('read', $notification);

        try {
            $notification->read = true;
            $notification->save();

            return response('Notification read');
        } catch (ModelNotFoundException $e) {
            return response('Notification not found');
        }
    }
}
