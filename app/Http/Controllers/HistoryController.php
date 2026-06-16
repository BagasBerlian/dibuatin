<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function show(Request $request)
    {
        $user = Auth::user()->id;
        $orders = Order::with(['package.product', 'transaction', 'project.user'])
                    ->where('user_id', $user)
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);
        
        return view('history', compact('orders'));
    }
}
