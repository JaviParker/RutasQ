<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Notification;

use Illuminate\Support\Facades\Validator;
class NotifiController extends Controller
{
    public function index()
    {
        $notifications = Notification::all();

        return response()->json($notifications);
    }
}
