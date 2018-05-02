<?php
error_reporting(0);
echo '<head>
<meta name="viewport" content="user-scalable=no,initial-scale=1,maximum-scale=1" />
<title>Facebook Access Token Checker</title>
</head>
<body align="center">
';
if(!empty($_POST['tokens']) && isset($_POST['ceksemua'])){
$listtokens = explode("\n", $_POST['tokens']);
foreach($listtokens as $token){
if(cektok($token) == 'bener'){
$c = fopen('tokens.txt', 'a');
fwrite($c, '('.getid($token, 'id').') '.$token."\n");
fclose($c);
echo '(<a href="https://www.facebook.com/'.htmlspecialchars(getid($token, 'id')).'" target="_blank">'.htmlspecialchars(getid($token, 'name')).'</a>) '.htmlspecialchars($token).' <font color="blue">=></font> <font color="lime">Alive</font><br/>';
}elseif(cektok($token) == 'mati'){
echo htmlspecialchars($token).' <font color="blue">=></font> <font color="red">Not Alive</font><br/>';
}else{
echo htmlspecialchars($token).' <font color="blue">=></font> <font color="red">Wrong Token</font><br/>';
}
}
echo '<a href='.htmlspecialchars(basename($_SERVER['PHP_SELF'])).'>Go Back</a>';
}else{
echo '<form method="POST">
<h2><font color="blue">Facebook Access Tokens</font></h2>
<p>
<b>Access Tokens</b><br/>
<textarea cols="30" rows="8" name="tokens" placeholder="Token 1
Token 2
Token 3"></textarea>
</p>
<input type="submit" name="ceksemua" value="Check">
</form>';
}
echo '
</body>';

function cektok($akses){
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'https://graph.facebook.com/me?fields=id&access_token='.urlencode($akses));
curl_setopt($curl, CURLOPT_HEADER, 0);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
$ch = curl_exec($curl);
if(eregi('{"id":"', $ch)){
return 'bener';
}elseif(eregi('Error validating access token: The session has been invalidated because the user changed their password or Facebook has changed the session for security reasons.', $ch)){
return 'mati';
}else{
return 'salah';
}
curl_close($curl);
}

function getid($akses, $apa){
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'https://graph.facebook.com/me?fields=id,name&access_token='.urlencode($akses));
curl_setopt($curl, CURLOPT_HEADER, 0);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
$ch = curl_exec($curl);
$s = explode('{"id":"', $ch);
$c = explode('","name":"', $s[1]);
$v = explode('"}', $c[1]);
$id = $c[0];
$nama = $v[0];
if($apa == 'id'){
return $id;
}elseif($apa == 'name'){
return $nama;
}else{
return '';
}
curl_close($curl);
}
?>