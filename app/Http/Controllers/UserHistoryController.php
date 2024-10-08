<?php
// app/Http/Controllers/UserHistoryController.php

namespace App\Http\Controllers;

use App\Models\UserHistory;

class UserHistoryController extends Controller
{
    public function index()
    {
        $histories = UserHistory::where('user_id', auth()->id())->get();
        return view('user.history.index', compact('history'));
    }
}
