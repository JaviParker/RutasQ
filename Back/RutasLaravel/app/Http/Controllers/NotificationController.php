<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Notification;
use Carbon\Carbon;

use Illuminate\Support\Facades\Validator;
class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::all();

        return response()->json($notifications);
    }
}
