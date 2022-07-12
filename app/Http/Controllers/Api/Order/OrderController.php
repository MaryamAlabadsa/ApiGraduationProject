<?php

namespace App\Http\Controllers\Api\Order;

use App\Events\AddOrder;
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

        $deleteOrder = Order::onlyTrashed()->where([["deleted_at", '!=', null],
            ['user_id', '=', Auth::id()], ['post_id', '=', $request->post_id]])->first();
        if ($deleteOrder) {
            $deleteOrder->restore();
            $order = $deleteOrder->update(['massage' => $request->massage]);
        } else {
            $order = Order::create([
                'massage' => $request->massage,
                'post_id' => $request->post_id,
                'user_id' => Auth::id(),
            ]);
        }
        $receiver_id = Post::where('id', $request->post_id)->first()->first_user;
        $deleteNotification = Notification::where([["type", '=', "delete_request"],
            ['post_id', '=', $request->post_id], ['receiver_id', '=', $receiver_id]])->first();
        if ($deleteNotification) {
            $deleteNotification->update([
                'type' => 'add_request',
            ]);
        } else {
            Notification::create([
                'post_id' => $request->post_id,
                'sender_id' => Auth::id(),
                'receiver_id' => $receiver_id,
                'type' => 'add_request',
            ]);
        }
        sendnotification($token, 'add new request', Auth::user()->name . ' send you request', ['post_id' => $request->post_id]);

        Notification::create([
            'post_id' => $request->post_id,
            'sender_id' => Auth::id(),
            'receiver_id' => adminId(),
            'type' => 'admin_add_request',
        ]);
        sendnotification(adminToken(), "some one add new order", Auth::user()->name . " add new order ", ['post_id' => $request->post_id]);

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
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Order $order)
    {
        setLang($request->lang);

        $order->update(['massage' => $request->massage]);

        return response()->json(
            [
                'message' => 'updated Successfully',
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Order $order
     * @return array
     */
    public function destroy(Order $order, Request $request)
    {
        setLang($request->lang);

        $user = Auth::id();
        $token = Post::where('id', $order->post_id)->first()->first_user_token;

        if ($order->user_id == $user) {
            $order->delete();
            $notification = Notification::where([['sender_id', '=', $user], ['post_id', '=', $order->post_id]])->first();
            $notification->update([
                'type' => 'delete_request',
            ]);
            sendnotification($token, 'delete request', Auth::user()->name . ' deleted her/his request .', ['post_id' => $order->post_id]);

            return ['message' => 'You have successfully delete your order.',
            ];
        } else
            return ['message' => 'You can not delete this order.',
            ];


    }

    public function restoreOrder($id,Request $request)
    {
        setLang($request->lang);

        $deleteOrder = Order::onlyTrashed()->where([["deleted_at", '!=', null], ['id', '=', $id]])->first();
        if ($deleteOrder) {
            $deleteOrder->restore();
            return ['message' => 'You have successfully restore your post.'];
        }
        return ['message' => 'You can not restore this order.'];

    }

    public function getPostOrders(Request $request)
    {

        $order = Order::where('post_id', $request->id)->get();
        return
//            'status' => Order::where('post_id', $request->id)->first()->post_status,
            new OrderCollection($order);
    }
}
