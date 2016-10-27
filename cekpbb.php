<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">


## usage
## access the file   cekpbb.php?nama=mukidi$tahun=2015 

<?php
if (!isset($_GET['nama'])) {
	$nama = 'MUKIDI BIN';
} else {
	$nama = strtoupper($_GET['nama']);
}

if (!isset($_GET['tahun'])) {
	$tahun = '2015';
} else {
	$tahun = $_GET['tahun'];
}


$loginData = array('nama'=>$nama, 'tahun'=>$tahun);
$postData = array('nama'=>$nama, 'tahun'=>$tahun);
$loginURL = "http://pbb-trenggalek.ddns.net/PBB/ote.php";
$addURL = "http://pbb-trenggalek.ddns.net/PBB/p_search.php";

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
