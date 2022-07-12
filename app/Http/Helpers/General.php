<?php

use App\Models\Notification;
use App\Models\Order;
use App\Models\Post;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

function sendnotification($to, $title, $message, $datapayload = [])
{
//    dd($to);
    $fields = array('to' => $to, 'notification' => array('title' => $title, 'body' => $message), 'data' => $datapayload);

    $headers = array(
        'Authorization: key=AAAAuirINo8:APA91bEHZwhkfIMiyV_pZtuWSlQyKJsmkGsXC-TFx_XqVzDtmUaB-eXWKeTVdoLtDJm9LSMY-YFa3SsUKwCWXPgeWV7acknbV5wptcgt5LqrXynN-8r8KI5sJOe6BPy56qakVbbqGozl',
        'Content-Type: application/json'
    );
//    dd(json_encode($fields));
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    curl_close($ch);
//    return $result;
}

function adminToken()
{
    $adminToken = \App\Models\User::where('id', 32)->first()->fcm_token;
    return $adminToken;
}

function adminId()
{
    return 32;
}

function RequestPosts($userId)
{
    $posts = Post::where([['is_donation', '=', 1], ['first_user', '=', $userId]
    ])->get();
    $orders = Order::whereIn('post_id', Post::select('id')->where('is_donation', 0)->get())->where('user_id', $userId)->get();
    $all_data = $orders->merge($posts);
    $all_sorted_data = $all_data->sortByDesc('created_at');
    $data = array();
    foreach ($all_sorted_data as $all_sorted_datum) {
        array_push($data, $all_sorted_datum->get_data);
    }
    return $data;
}

function DonationPosts($userId)
{
    $posts = Post::where([['is_donation', '=', 0]
        , ['first_user', '=', $userId]
    ])->get();
    $orders = Order::whereIn('post_id', Post::select('id')->where('is_donation', 1)->get())->where('user_id', $userId)->get();

//        dd($orders);
    $all_data = $orders->merge($posts);
    $all_sorted_data = $all_data->sortByDesc('created_at');
    $data = array();
    foreach ($all_sorted_data as $all_sorted_datum) {
        array_push($data, $all_sorted_datum->get_data);
    }
    return $data;
}

function getPostOrders($post_id)
{
    $post = Post::where('id', $post_id)->first();
    $orders = Order::where('post_id', $post->id)->get();
    return $orders;
}

function sendNotificationsWhenPostUpdate($post_id)
{
    $post = Post::where('id', $post_id)->first();

    $orders = getPostOrders($post_id);
    foreach ($orders as $order) {
        $user = \App\Models\User::where('id', $order->user_id)->first();
        $token = $user->fcm_token;
        if ($token) {
            sendnotification($token, "update Post", $post->first_user_name . ' update his post ', ['post_id' => $post->id]);
        }
        $notification = Notification::where([['post_id', '=', $post->id], ['type', '=', 'update_Post'], ['receiver_id', '=', $user->id]])->first();
        if ($notification) {
           $notification->update([
               'updated_at'=>now()
           ]);
        } else
            Notification::create([
                'post_id' => $post->id,
                'sender_id' => $post->first_user,
                'receiver_id' => $user->id,
                'type' => 'update_Post',
            ]);


    }
}
function setLang($langg){
    $lang=$langg?$langg:'en';
    App::setLocale($lang);
}
