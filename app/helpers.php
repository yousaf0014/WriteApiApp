<?php
function flash($message,$level = 'info'){
    session()->flash('flash_message',$message);
    session()->flash('flash_message_level',$level);
}
//require_once './../../amember/library/Am/Lite.php'; 
function getLogin(){
    return Am_Lite::getInstance()->isLoggedIn();
    //$search = Am_Lite::ANY;
    //$out = Am_Lite::getInstance()->checkAccess($search);
}

function YMD2MDY($date, $join = '/') {
    $dateArr = preg_split("/[-\/ ]/", $date);
    return $dateArr[2] . $join. $dateArr[1] . $join . $dateArr[0];
}
function MDY2YMD($date, $join = '-'){
    $dateArr = preg_split("/[-\/ ]/", $date);
    return $dateArr[2] . $join. $dateArr[0] . $join . $dateArr[1];   
}

function sendApiRequest($type,$url,$data1){
    $data1['_key'] = 'mLri8zwvzRbbyVi6AE6o'; 
    $data = http_build_query($data1);
    $ch = curl_init(); // initialize curl handle 
    if($type == 'POST'){
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch, CURLOPT_POST, 1); // set POST method
    }else{
        $seprator = $getString = '';
        if(!empty($data1)){
            foreach($data1 as $key=>$val){
                $getString .= $seprator.$key.'='.$val;
                $seprator = '&';
            }
            $url .= '?'.$getString;
        }
    }
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 7);
    curl_setopt($ch, CURLOPT_REFERER, 'https://backend.writemeai.com');
    curl_setopt($ch, CURLOPT_URL, 'https://backend.writeme.ai/amember/'.$url); 
    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);// allow redirects
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // return into a variable
    curl_setopt($ch, CURLOPT_TIMEOUT, 50); // times out after 50s
    
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_COOKIEJAR, "my_cookies1.txt");
    curl_setopt($ch, CURLOPT_COOKIEFILE, "my_cookies1.txt"); 
    curl_setopt($ch,CURLOPT_NOPROGRESS,false);
    $content = curl_exec($ch); // run the whole process
    $errors = curl_getinfo($ch);
    // close cURL resource, and free up system resources
    curl_close($ch);
    return $content;
}