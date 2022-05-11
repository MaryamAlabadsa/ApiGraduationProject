<?php

namespace App\Http\Controllers\Api\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\Order\OrderCollection;
use App\Http\Resources\Order\OrderResource;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Post;
use App\Models\User;
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
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function store(OrderRequest $request)
    {
        $token = Post::where('id', $request->post_id)->first()->first_user_token;
        $order = Order::create([
            'massage' => $request->massage,
            'post_id' => $request->post_id,
            'user_id' => Auth::id(),
        ]);
        if (!$token)
            sendnotification($token, 'تمت اضافة طلب جديد', 'تمت اضافة طلب جديد',$request->post_id);

        Notification::create([
            'post_id' => $request->post_id,
            'sender_id' => Auth::id(),
            'receiver_id' => Post::where('id', $request->post_id)->first()->first_user,
            'type' => 'add_request',
        ]);
        return ['message' => 'added Successfully',
            'data' => OrderResource::make($order),
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Order $order
     * @return array
     */
    public function show(Order $order)
    {
        $second_user = $order->second_user_name;

        return ['message' => 'Successfully',
            'data' => 'قام ' . $second_user . 'باضافة طلب جديد'
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Order $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Order $order
     * @return array
     */
    public function destroy(Order $order)
    {
        if ($order) {

            $order->delete();
            return ['message' => 'You have successfully delete your order.',
            ];
        } else {
            return ['message' => 'this order has been deleted because we did not found it',
            ];
        }
    }

    public function getPostOrders(Request $request)
    {

        $order = Order::where('post_id', $request->id)->get();
        return
//            'status' => Order::where('post_id', $request->id)->first()->post_status,
            new OrderCollection($order);
    }
}
