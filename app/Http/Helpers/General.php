<?php

use App\Models\Order;
use App\Models\Post;

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
