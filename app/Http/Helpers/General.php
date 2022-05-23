<?php
function sendnotification($to, $title, $message,$datapayload=[]){
    $fields  = array('to' => $to, 'notification' => array('title' => $title, 'body'=> $message),'data'=>$datapayload);

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
function adminToken(){
    $adminToken=\App\Models\User::where('id',32)->first()->fcm_token;
    return $adminToken;
}
function adminId(){
    return 32;
}
