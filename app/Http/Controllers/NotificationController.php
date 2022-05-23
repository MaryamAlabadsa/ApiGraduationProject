<?php

namespace App\Http\Controllers;

use App\Http\Resources\Notifiction\NotifictionResource;
use App\Models\Notification;
use App\Http\Requests\StoreNotificationRequest;
use App\Http\Requests\UpdateNotificationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index()
    {
        $user = Auth::id();
        $notif = Notification::
        where('receiver_id', $user)
//            ->groupBy('post_id')
            ->orderBy('created_at', "desc")->get();
        return
            [
                'message' => 'done',
                'data' => NotifictionResource::collection($notif),
            ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreNotificationRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNotificationRequest $request)
    {
        sendnotification(adminToken()
            , "laravel13", "loarem loarem loarem", ['post_id'=>2]);
         return response()->json(['message' => $request->post_id]);

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Notification $notification
     * @return \Illuminate\Http\Response
     */
    public function show(Notification $notification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Notification $notification
     * @return \Illuminate\Http\Response
     */
    public function edit(Notification $notification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateNotificationRequest $request
     * @param \App\Models\Notification $notification
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNotificationRequest $request, Notification $notification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Notification $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notification $notification)
    {
        //
    }
}
