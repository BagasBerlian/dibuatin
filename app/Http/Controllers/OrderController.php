<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Package;
use App\Models\BenefitPackage;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function show(Request $request)
    {
        $products = Product::all(); // Get all products
        $benefits = BenefitPackage::all(); // Get all benefits
        
        $productTypeId = $request->input('product_type', 1); // Get selected product_type
        $packages = Package::with('product')->where('product_id', $productTypeId) ->get();
        
        if ($request->ajax()) {
            return view('partials.packages', compact('packages', 'benefits'));
        }
            
        return view('order', compact('products', 'packages', 'benefits'));
    }
    public function store(Request $request): RedirectResponse {
        $request->validate([
            'package_id' => 'required|integer',
            'requestInput' => 'nullable|string',
            'orientation' => 'required|string',
        ]);
        $order = Order::create([
            'user_id' => Auth::user()->id,
            'package_id' => (int) $request->package_id,
            'request' => $request->requestInput,
            'orientation' => $request->orientation,
        ]);
        session()->put('order_id', $order->id);
        return redirect()->route('payment');
    }
}
