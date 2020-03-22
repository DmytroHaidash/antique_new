<?php

namespace App\Http\Controllers\Client;


use App\Mail\OrderCreate;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mail;

class OrderController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Product $product
     * @return RedirectResponse
     */
    public function __invoke(Request $request, Product $product): RedirectResponse
    {
        $order = Order::create([
            'product_id' => $product->id,
            'name' => $request->input('name'),
            'contact' =>json_encode($request->input('contact')),
            'message' => $request->input('message'),
            'price' => $product['price'],
        ]);
        Mail::send(new OrderCreate($order));
        return redirect()->route('client.index');
    }
}
