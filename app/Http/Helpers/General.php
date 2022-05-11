<?php
function sendnotification($to, $title, $message,$postId,$datapayload=[]){
 $msg = urlencode($message);
    $data = array(
        'title'=>$title,
        'post_id'=>$postId,
        'sound' => "default",
        'msg'=>$msg,
        'data'=>$datapayload,
        'body'=>$message,
        'color' => "#79bc64"
    );
    $fields = array(
        'to'=>$to,
        'notification'=>$data,
//        'data'=>$datapayload,
        "priority" => "high",
    );
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
    curl_close( $ch );
//    return $result;
}
