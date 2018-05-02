<?php
error_reporting(0);
echo '<head>
<meta name="viewport" content="user-scalable=no,initial-scale=1,maximum-scale=1" />
<title>Facebook Post Editor</title>
</head>
<body align="center">
';
if(!empty($_POST['token']) && !empty($_POST['id']) && !empty($_POST['message']) && isset($_POST['post'])){
if(lakukan($_POST['token'], $_POST['id'], $_POST['message']) == 'berhasil'){
echo '<a href="https://www.facebook.com/'.htmlspecialchars(getid($_POST['token'], 'id').'_'.$_POST['id']).'" target="_blank">'.htmlspecialchars($_POST['id']).'</a> <font color="blue">=></font> <font color="lime">Success</font><br/>';
}else{
echo '<font color="red">Failed</font><br/>
Error : Wrong Token / No Data / Disabled / Expired<br/>';
}
echo '<a href='.htmlspecialchars(basename($_SERVER['PHP_SELF'])).'>Go Back</a>';
}else{
echo '<form method="POST">
<h2><font color="blue">Facebook Post Editor</font></h2>
<p>
<b>Access Token</b><br/>
<input type="text" placeholder="EAAAA..." name="token">
</p>
<p>
<p>
<b>Post Id</b><br/>
<input type="number" placeholder="371..." name="id">
</p>
<p>
<b>Message</b><br/>
<textarea cols="30" rows="8" name="message" placeholder="Hacked by ..."></textarea>
</p>
<input type="submit" name="post" value="Post">
</form>';
}
echo '
</body>';

function lakukan($akses, $id, $msg){
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'https://graph.facebook.com/'.urlencode(getid($akses, 'id').'_'.$id).'?method=POST&message='.urlencode($msg).'&access_token='.urlencode($akses));
curl_setopt($curl, CURLOPT_HEADER, 0);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
$ch = curl_exec($curl);
if($ch == 'true'){
return 'berhasil';
}else{
return 'gagal';
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