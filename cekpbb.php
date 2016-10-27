<?php

#usage = xxxx.php?input=mukidi&tahun=2015

# biasanya yg diubah ini
$loginURL = "http://pbb-trenggalek.ddns.net/PBB/ote.php";


//1. get nilai 

if (!isset($_GET['input'])) {
    $input = 'MUKIDI BIN S';
} else {
    //$input = trim(strtoupper($_GET['input']));
    $input = trim(strtoupper(alphanumericAndSpace(unsef_url($_GET['input']))));
}

if (!isset($_GET['tahun'])) {
    $tahun = '2015';
} else {
    $tahun = trim(intval($_GET['tahun']));
}


//2. tentukan nama atau nop
if (is_numeric($input)) {
    # nomor OP
    if (strlen($input) <> 18) {
      $r = '<p>Maaf, SPPT yang Anda masukkan kurang benar.</p>';
    } else {

      $addURL = "http://pbb-trenggalek.ddns.net/PBB/p_objek.php";

      $postData = array(
        'prop' => urlencode(substr($input, 0, 2)), 
        'dati' => urlencode(substr($input, 2, 2)), 
        'kec' => urlencode(substr($input, 4, 3)), 
        'kel' => urlencode(substr($input, 7, 3)), 
        'blok' => urlencode(substr($input, 10, 3)), 
        'urut' => urlencode(substr($input, 13, 4)), 
        'jnsop' => urlencode(substr($input, -1, 1))
      );
    }
} else {
    
    $addURL = "http://pbb-trenggalek.ddns.net/PBB/p_search.php";

    # nama
    $postData = array(
      'nama' => urldecode($input), 
      'tahun' => urldecode($tahun)
    );
}


## usage
## access the file   cekpbb.php?nama=mukidi&tahun=2015 


$loginData = array('nama'=>'sapi', 'tahun'=>'2015');


$curl_options = array(
    CURLOPT_RETURNTRANSFER => true,     /* return web page */
    CURLOPT_HEADER         => false,    /* don't return headers */
    CURLOPT_FOLLOWLOCATION => true,     /* follow redirects */
    CURLOPT_ENCODING       => "",       /* handle all encodings */
    CURLOPT_AUTOREFERER    => true,     /* set referer on redirect */
    CURLOPT_CONNECTTIMEOUT => 120,      /* timeout on connect */
    CURLOPT_TIMEOUT        => 120,      /* timeout on response */
    CURLOPT_MAXREDIRS      => 10,       /* stop after 10 redirects */
    CURLOPT_SSL_VERIFYHOST => 0,
    CURLOPT_SSL_VERIFYPEER => 0
);

$cookie = "cookie.txt";
if ( $ch = curl_init() )
{
    curl_setopt_array($ch,$curl_options);
    if ( $cookie )
    {
        curl_setopt($ch,CURLOPT_COOKIEJAR,$cookie);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_URL, $loginURL);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($loginData) );
        $r = curl_exec($ch);
        curl_setopt($ch, CURLOPT_URL, $addURL);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData) );
        $html = curl_exec($ch);

		$pattern = "/<table[^>]*>(.*)<\/table>/s";

		// If a match is found, store the results in $match
		if (preg_match($pattern, $html, $match)) {
		    // Show the captured value
		    echo '<table class="table table-condensed table-striped table-bordered">'.$match[1].'</table>';
		}
    }
     curl_close($ch);
}



function numonly($string) {
    return preg_replace('/[^0-9]/', '', $string);
}
function alphanumericAndSpace($string) {
    return preg_replace('/[^a-zA-Z0-9\s]/', '', $string);
}
function unsef_url($string) {
    $string = str_replace('_', ' ', $string);
    $string = str_replace('+', ' ', $string);
    $string = str_replace('-', ' ', $string);
    return strtolower($string);
}
