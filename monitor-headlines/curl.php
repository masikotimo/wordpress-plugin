<?php



function fetchHeadlines($url){
    $ch = curl_init($url);
    
    $fp = fopen("Dailymonitor.txt", "w");
    
    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_exec($ch);
    if(curl_error($ch)) {
        fwrite($fp, curl_error($ch));
    }
    curl_close($ch);
    fclose($fp);
    //getting contents from the file
    $post_content= file_get_contents("Dailymonitor.txt");
    
    preg_match_all('/(<h3>\V|<h3>)<a href="(.*?)">(.*?)<\/a><\/h3>/', $post_content, $headlines);

    foreach ($headlines[0] as $headline => $value) {
        print $value;
    }

    return $headlines[0];

}

 fetchHeadlines("https://www.monitor.co.ug/uganda");



?>

