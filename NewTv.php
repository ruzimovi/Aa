<?php
ob_start();
error_reporting(0);
date_Default_timezone_set('Asia/Tashkent');

define("ruzimov_fx",'7049659230:AAGa7sYSUFDVNv2ifFXdv__YrHoeVxmIEuA');
$admin = array("6796076162");
$user = "ruzimov_fx";
$bot = bot('getme',['bot'])->result->username;
$soat = date('H:i');
$sana = date("d.m.Y");

require ("sql.php");

function bot($method,$datas=[]){
	$url = "https://api.telegram.org/bot".ruzimov_fx."/".$method;
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
	$res = curl_exec($ch);
	if(curl_error($ch)){
		var_dump(curl_error($ch));
	}else{
		return json_decode($res);
	}
}

$alijonov = json_decode(file_get_contents('php://input'));
$message = $alijonov->message;
$cid = $message->chat->id;
$name = $message->chat->first_name;
$tx = $message->text;
$mid = $message->message_id;
$type = $message->chat->type;
$text = $message->text;
$uid = $message->from->id;
$name = $message->from->first_name;
$familya = $message->from->last_name;
$premium = $message->from->is_premium;
$bio = $message->from->about;
$username = $message->from->username;
$chat_id = $message->chat->id;
$message_id = $message->message_id;
$reply = $message->reply_to_message->text;
$nameru = "<a href='tg://user?id=$uid'>$name $familya</a>";

$caption = $message->caption;
$photo = $message->photo;
$video = $message->video;
$file_id = $video->file_id;
$file_name = $video->file_name;
$file_size = $video->file_size;
$size = $file_size/1000;
$dtype = $video->mime_type;

//inline uchun metodlar
$data = $alijonov->callback_query->data;
$qid = $alijonov->callback_query->id;
$id = $alijonov->inline_query->id;
$query = $alijonov->inline_query->query;
$query_id = $alijonov->inline_query->from->id;
$cid2 = $alijonov->callback_query->message->chat->id;
$mid2 = $alijonov->callback_query->message->message_id;
$callfrid = $alijonov->callback_query->from->id;
$callname = $alijonov->callback_query->from->first_name;
$calluser = $alijonov->callback_query->from->username;
$surname = $alijonov->callback_query->from->last_name;
$about = $alijonov->callback_query->from->about;
$nameuz = "<a href='tg://user?id=$callfrid'>$callname $surname</a>";

$reklama = "@$user <b>bot yaratish xizmati!</b>";
$kanal = "By_Alik";
$kino = "By_Alik";


if(in_array($cid,$admin)){
	$admin = $cid;
}

$res = mysqli_query($connect,"SELECT*FROM user_id WHERE user_id=$cid");
while($a = mysqli_fetch_assoc($res)){
$user_id = $a['user_id'];
$step = $a['step'];
}

if(isset($message)){
	if(!$connect){
		bot('sendMessage',[
		'chat_id'=>$cid,
		'text'=>"⚠️ <b>Xatolik!</b>
		
<i>Baza bilan aloqa mavjud emas!</i>",
		'parse_mode'=>'html',
		]);
		return false;
	}
}

if(isset($message)){
$result = mysqli_query($connect,"SELECT * FROM user_id WHERE user_id = $cid");
$rew = mysqli_fetch_assoc($result);
if($rew){
}else{
mysqli_query($connect,"INSERT INTO user_id(`user_id`,`step`,`sana`) VALUES ('$cid','0','$sana | $soat')");
}
}


if(isset($message)){
$get = bot('GetChatMember',[
'chat_id'=>"@".$kanal."",
'user_id'=>$cid,
]);
$result = $get->result->status;
if($result == "member" or $result == "administrator" or $result == "creator"){
	}else{
		bot('sendMessage',[
		'chat_id'=>$cid,
		'text'=>"🔒 @$kanal <b>ga obuna bo'lmasangiz botdan to'liq foydalana olmaysiz!</b>",
		'parse_mode'=>'html',
		]);
		return false;
	}
}

if($text == "/start"){
	bot('sendMessage',[
	'chat_id'=>$cid,
    'text'=>"👋 <b>Salom $name!</b>

<i>Marhamat, kerakli kodni yuboring:</i>",
	'parse_mode'=>'html',
	'reply_markup'=>json_encode([
	'inline_keyboard'=>[
	[['text'=>"🔎 Kodlarni qidirish",'url'=>"https://t.me/$kino"]]
]
])
]);
mysqli_query($connect, "UPDATE user_id SET step = '0' WHERE user_id = $cid");
exit();
}

if(isset($video)){
if($cid == $admin){
$result = mysqli_query($connect,"SELECT * FROM data WHERE file_name = '$file_name'");
$row = mysqli_fetch_assoc($result);
if(!$row){
$rand = rand(0,9999);
mysqli_query($connect, "INSERT INTO data(`file_name`,`file_id`,`code`) VALUES ('$file_name','$file_id','$rand')");
  $msg = bot('sendMessage',[
      'chat_id'=>"@".$kino."",
      'text'=>"$caption

<b>Kino kodi:</b> <code>$rand</code>

❗️ <b>Diqqat kinoni bot orqali topishingiz mumkin!</b>",
     'parse_mode'=>'html',
     'reply_markup'=>json_encode([
     'inline_keyboard'=>[
[['text'=>"➡️ @$bot",'url'=>"https://t.me/$bot"]]
]
])
])->result->message_id;
bot('sendMessage',[
	'chat_id'=>$cid,
	'text'=>"<b>Bazaga muvaffaqiyatli joylandi!</b> 

<code>$rand</code>",
	'parse_mode'=>'html',
'reply_to_message_id'=>$mid,
     'reply_markup'=>json_encode([
     'inline_keyboard'=>[
[['text'=>"➡️ @$kino",'url'=>"https://t.me/$kino/$msg"]]
]
])
]);
exit();
}else{
		bot('SendMessage',[
	'chat_id'=>$cid,
	'text'=>"$file_name <b>qabul qilinmadi!</b>

Qayta urinib ko'ring:",
'parse_mode'=>'html',
'reply_to_message_id'=>$mid,
]);
exit();
}
}
}

if(isset($text)){
if($text != "/start" and $text != "/stat" and $text != "/send" and $step != "send"){
if((mb_stripos($text, "/delete") !== false) and (mb_stripos($text, "/delete") !== false)){
}else{
if(is_numeric($text) == true){
$res = mysqli_query($connect,"SELECT * FROM data WHERE code = '$text'");
$row = mysqli_fetch_assoc($res);
if(!$row){
	bot('SendMessage',[
	'chat_id'=>$cid,
	'text'=>"$text <b>mavjud emas!</b>

Qayta urinib ko'ring:",
'parse_mode'=>'html',
'reply_to_message_id'=>$mid,
]);
exit();
}else{
$file_name = mysqli_fetch_assoc(mysqli_query($connect,"SELECT*FROM data WHERE code = '$text'"))['file_name'];
$file_id = mysqli_fetch_assoc(mysqli_query($connect,"SELECT*FROM data WHERE code = '$text'"))['file_id'];
      bot('sendVideo',[
      'chat_id'=>$cid,
      'video'=>$file_id,
      'caption'=>"$file_name

$reklama",
     'parse_mode'=>'html',
'reply_to_message_id'=>$mid,
]);
exit();
}
}else{
	bot('SendMessage',[
	'chat_id'=>$cid,
	'text'=>"<b>Faqat raqamlardan foydalaning!</b>",
'parse_mode'=>'html',
'reply_to_message_id'=>$mid,
]);
exit();
}
}
}
}

//<-------- @AlijonovUz ------->//

if($text == "/send" and $cid == $admin){
bot('SendMessage',[
'chat_id'=>$cid,
    'text'=>"*Xabar matnini kiriting:*",
'parse_mode'=>'MarkDown',
'reply_to_message_id'=>$mid,
]);
mysqli_query($connect, "UPDATE user_id SET step = 'send' WHERE user_id = $cid");
exit();
}

if($step == "send"){
if($cid == $admin){
mysqli_query($connect, "UPDATE user_id SET step = '0' WHERE user_id = $cid");
$res = mysqli_query($connect,"SELECT * FROM `user_id`");
bot('sendMessage',[
  'chat_id'=>$chat_id,
  'text'=>"✅ <b>Xabar yuborish boshlandi!</b>",
'parse_mode'=>'html',
  ]);
$x=0;
$y=0;
while($a = mysqli_fetch_assoc($res)){
$id = $a['user_id'];
	$key=$message->reply_markup;
	$keyboard=json_encode($key);
	$ok=bot('copyMessage',[
'from_chat_id'=>$chat_id,
'chat_id'=>$id,
'message_id'=>$mid,
])->ok;
if($ok==true){
}else{
$okk=bot('copyMessage',[
'from_chat_id'=>$chat_id,
'chat_id'=>$id,
'message_id'=>$mid,
])->ok;
}
if($okk==true or $ok==true){
$x=$x+1;
bot('editMessageText',[
  'chat_id'=>$chat_id,
'message_id'=>$mid,
'text'=>"✅ <b>Yuborildi:</b> $x

❌ <b>Yuborilmadi:</b> $y",
'parse_mode'=>'html',
]);
}elseif($okk==false){
mysqli_query($connect, "DELETE FROM `user_id` WHERE user_id = '$id'");
$y=$y+1;
bot('editmessagetext',[
'chat_id'=>$chat_id,
'message_id'=>$mid + 1,
'text'=>"✅ <b>Yuborildi:</b> $x

❌ <b>Yuborilmadi:</b> $y",
'parse_mode'=>'html',
]);
}
}
bot('editmessagetext',[
'chat_id'=>$chat_id,
'message_id'=>$mid + 1,
'text'=>"✅ <b>Yuborildi:</b> $x

❌ <b>Yuborilmadi:</b> $y",
'parse_mode'=>'html',
]);
}
exit();
}

if($text == "/stat"){
$res = mysqli_query($connect, "SELECT * FROM `user_id`");
$us = mysqli_num_rows($res);
$res = mysqli_query($connect, "SELECT * FROM `data`");
$kin = mysqli_num_rows($res);
$start_time = round(microtime(true) * 1000);
bot('SendMessage',[
'chat_id'=>$cid,
'text'=>"",
'parse_mode'=>'html',
]);
$end_time = round(microtime(true) * 1000);
$ping = $end_time - $start_time;
bot('SendMessage',[
'chat_id'=>$cid,
'text'=>"<b>O'rtacha yuklanish:</b> <code>$ping</code>

• <b>Foydalanuvchilar:</b> $us ta
• <b>Yuklangan kinolar:</b> $kin ta",
'parse_mode'=>'html',
'reply_to_message_id'=>$mid,
]);
exit();
}

if(mb_stripos($text, "/delete") !== false){
if($cid == $admin){
$code = explode(" ", $text)[1];
$res = mysqli_query($connect,"SELECT * FROM data WHERE code = '$code'");
$row = mysqli_fetch_assoc($res);
if(!$row){
	bot('SendMessage',[
	'chat_id'=>$cid,
	'text'=>"$code <b>mavjud emas!</b>

Qayta urinib ko'ring:",
'parse_mode'=>'html',
'reply_to_message_id'=>$mid,
]);
exit();
}else{
mysqli_query($connect,"DELETE FROM data WHERE code = $code"); 
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"$code <b>raqamli kino olib tashlandi!</b>",
'parse_mode'=>'html',
'reply_to_message_id'=>$mid,
]);
exit();
}
}
}

?>