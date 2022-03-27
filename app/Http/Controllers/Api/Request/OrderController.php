<?php

namespace App\Http\Controllers\Api\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\Order\OrderCollection;
use App\Http\Resources\Order\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return OrderCollection
     */
    public function index()
    {
        return new OrderCollection(Order::all());

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function store(OrderRequest $request)
    {

//        $post = Po
        $order = Order::create([
            'massage' => $request->massage,
            'post_id' => $request->post_id,
            'user_id' => Auth::id(),
        ]);

        return ['message' => 'added Successfully',
            'data' => OrderResource::make($order),
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $request
     * @return array
     */
    public function show(Request $request)
    {
        return ['message' => 'Successfully',
            'data' => OrderRequest::make($request),
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return array
     */
    public function destroy(Order $order)
    {
        if ($order){

            $order->delete();
            return ['message' => 'You have successfully delete your order.',
            ];
        } else{
            return ['message' => 'this order has been deleted because we did not found it',
            ];
        }
    }
}
