<?php
/*
بسم الله الرحمن الرحيم
*/
error_reporting(-1);
ob_start();
$API_KEY = "8663911094:AAEpze9saVy0eegc-XUZ4Z4_fbtLsdkmzz8";
$admin = 8271807701; //ايديك
$c = "@Archived_Posts"; //قناتك
define("API_KEY",$API_KEY);
function bot($YOUSEEF,$Sauodi=[]){
$YOUSEEFURL = "https://api.telegram.org/bot".API_KEY."/".$YOUSEEF;
$curl = curl_init();
curl_setopt($curl,CURLOPT_URL,$YOUSEEFURL);
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl,CURLOPT_POSTFIELDS,$Sauodi);
$NewBotsTele = curl_exec($curl);
if(curl_error($curl)){
var_dump(curl_error($curl));
curl_close($curl);
}else{
curl_close($curl);
return json_decode($NewBotsTele);
}
}
function is_admin(string $from_id = null, string $chat_id = null, string $view=null){
@$groups_json = file_exists('groups_json.json') ? json_decode(file_get_contents('groups_json.json'),true) : fopen("groups_json.json", 'w');
$YOUSEEF_USER = bot('getChatMember',['chat_id'=>$chat_id,'user_id'=>$from_id])->result->status;
if($YOUSEEF_USER == "administrator" || $YOUSEEF_USER == "creator" || in_array($from_id,$groups_json['groups'][$chat_id]['admins'])){
if($view == null){
return true;
}else{
return $YOUSEEF_USER;
}
}
}
function get_info(string $chat_id = null,string $type = "member"){
if($type == "group"){
$YOUSEEF_INFO = bot('getChat',['chat_id'=>$chat_id])->result;
$LABBANLink = !empty ($YOUSEEF_INFO->invite_link) ? $YOUSEEF_INFO->invite_link : bot('exportChatInviteLink',['chat_id'=>$chat_id])->result;
$LABBANTitle = $YOUSEEF_INFO->title; 
$LABBANId = $YOUSEEF_INFO->id;
$YOUSEEF = ['title'=>$LABBANTitle,'link'=>$LABBANLink,'id'=>$LABBANId];
}else if ($type == "member"){
$YOUSEEF_INFO = bot('getChat',['chat_id'=>$chat_id])->result;
$LABBANTitle = $YOUSEEF_INFO->first_name; 
$LABBANId = $YOUSEEF_INFO->id;
$YOUSEEF = ['title'=>$LABBANTitle,'id'=>$LABBANId];
}
return $YOUSEEF;
}
function send(string $TYPE = "send", array $IDS = [], int $MESSAGE = 0, int $ADMIN = 0){
foreach ($IDS as $CHAT){
if($TYPE == "send"){ 
bot('copymessage',[
'chat_id'=>$CHAT,
'from_chat_id'=>$ADMIN,
'message_id'=>$MESSAGE,
]);
}else if($TYPE == "forward"){
bot('forwardmessage',[
'chat_id'=>$CHAT,
'from_chat_id'=>$ADMIN,
'message_id'=>$MESSAGE,
]);
}
unset($IDS[array_search($CHAT,$IDS)]);
}
if(count ($IDS) === 0 ){ 
bot('sendmessage',[
'chat_id'=>$ADMIN,
'text'=>"• عزيزي المطور تم اكتمال عملية الإذاعة بنجاح والحمد لله",
]);
}
}
function id($us_id){
$users_json = file_exists('users_json.json') ? json_decode(file_get_contents('users_json.json'),true) : fopen("users_json.json", 'w');
if(is_numeric($us_id)){
return $us_id;
} else {
return $users_json['users'][str_replace('@','',strtolower($us_id))];
}
}
function DTime ($Time){
if(preg_match('/(.*)ي/',$Time,$rr)){
$_Time = $rr[1]*24*60*60;
}elseif(preg_match('/(.*)س/',$Time,$rr)){
$_Time = $rr[1]*60*60;
}elseif(preg_match('/(.*)د/',$Time,$rr)){
$_Time = $rr[1]*60;
}
return time()+$_Time+0;
}
function T($T){
if(preg_match("/^تقييد (.*) (.*)/",$T)){
preg_match("/^تقييد (.*) (.*)/",$T,$r1);
return $r1;
}else{
preg_match("/^تقييد (.*)/",$T,$r2);
return $r2;
}}
$sudo = [$admin,00,00];
@$update = json_decode(file_get_contents("php://input"));
if(isset($update)){
run(isset($update) ? $update : []);
}
/* 
* @YOUSEEF 
* @NewBotsTele
*/
function run($update){
if(is_object($update)){
extract ($GLOBALS);
if(isset($update->message)){
$message = $update->message;
$message_id = $update->message->message_id;
$username = $message->from->username;
$chat_id = $message->chat->id;
$title = $message->chat->title;
$text = $message->text;
$audio = $message->audio;
$voice = $message->voice;
$sticker = $message->sticker;
$video = $message->video;
$photo = $message->photo;
$animation = $message->animation;
$notice = isset($message->new_chat_member) ? $message->new_chat_member : $message->left_chat_member;
$document = $message->document;
$user = strtolower($message->from->username);
$user2 = "[$user]";
$scam = ['[','*',']','_','(',')','`','َ','ٕ','ُ','ِ','ٓ','ٓ','ٰ','ٖ','ً','ّ','ٌ','ٍ','ْ','ٔ',';'];
$name = str_replace($scam,null,$message->from->first_name." ".$message->from->last_name);
$from_id = $message->from->id;
$tag = "[$name](tg://user?id=$from_id)";
$type = $message->chat->type;
$reply_id = $message->reply_to_message->from->id;
$reply_name = str_replace($scam,null,$message->reply_to_message->from->first_name." ".$message->reply_to_message->from->last_name);
$reply_user = $message->reply_to_message->from->username;
$reply_tag = "[$reply_name](tg://user?id=$reply_id)";
}
else if(isset($update->callback_query)){
$data = $update->callback_query->data;
$scam = ['[','*',']','_','(',')','`','َ','ٕ','ُ','ِ','ٓ','ٓ','ٰ','ٖ','ً','ّ','ٌ','ٍ','ْ','ٔ',';'];
$chat_id = $update->callback_query->message->chat->id;
$title = $update->callback_query->message->chat->title;
$message_id = $update->callback_query->message->message_id;
$name = str_replace($scam,null,$update->callback_query->from->first_name." ".$update->callback_query->from->last_name);
$from_id = $update->callback_query->from->id;
$tag = "[$name](tg://user?id=$from_id)";
$user = $update->callback_query->from->username;
$user2 = "[$user]";
}else if(isset($update->edited_message)){
$message = $update->edited_message;
$message_id = $message->message_id;
$username = $message->from->username;
$from_id = $message->from->id;
$chat_id = $message->chat->id;
$title = $message->chat->title;
$text = $message->text;
$audio = $message->audio;
$voice = $message->voice;
$sticker = $message->sticker;
$video = $message->video;
$photo = $message->photo;
$animation = $message->animation;
}
$edit = $update->edited_message;
$inline = $update->message->via_bot;
$mark = $update->message->entities;
@$members = file_exists('members.txt') ? file_get_contents('members.txt') : fopen("members.txt", 'w');
$ex_members = array_unique(array_filter(explode("\n",$members)));
@$groups_json = file_exists('groups_json.json') ? json_decode(file_get_contents('groups_json.json'),true) : fopen("groups_json.json", 'w');
@$sudo_json = file_exists('sudo_json.json') ? json_decode(file_get_contents('sudo_json.json'),true) : fopen("sudo_json.json", 'w');
if($type !== 'private'){
$groups_json['groups'][$chat_id]['managers'] = empty ($groups_json['groups'][$chat_id]['managers']) ? [] : $groups_json['groups'][$chat_id]['managers'];
$groups_json['groups'][$chat_id]['features'] = empty ($groups_json['groups'][$chat_id]['features']) ? [] : $groups_json['groups'][$chat_id]['features'];
$groups_json['groups'][$chat_id]['silencers'] = empty ($groups_json['groups'][$chat_id]['silencers']) ? [] : $groups_json['groups'][$chat_id]['silencers'];
$groups_json["groups"][$chat_id]["ids"] = empty ($groups_json["groups"][$chat_id]["ids"]) ? [] : $groups_json["groups"][$chat_id]["ids"];
}
if(!$sudo_json['sudo']){
$sudo_json['sudo']['bot'] = "yes";
$sudo_json['sudo']['start'] = "اهلا بك عزيزي : #tag

*في بوت حماية المجموعات ✅*

لتفعيل البوت اضف البوت في مجموعتك وأرسل تفعيل ..";
file_put_contents('sudo_json.json',json_encode($sudo_json,64|128|256));
}
$sudo_json['sudo']['ban'] = empty ($sudo_json['sudo']['ban']) ? [] : $sudo_json['sudo']['ban'];
$sudo_json['sudo']['devs'] = empty ($sudo_json['sudo']['devs']) ? [] : $sudo_json['sudo']['devs'];
@$users_json = file_exists('users_json.json') ? json_decode(file_get_contents('users_json.json'),true) : fopen("users_json.json", 'w');
@$groups_txt = file_exists('groups_txt.txt') ? file_get_contents('groups_txt.txt') : fopen("groups_txt.txt", 'w');
$ex_txt = array_filter(explode("\n",file_get_contents('groups_txt.txt')));
$array_ban = [
'بالحظر',
'بالطرد',
'بالتقييد',
'بالحذف',
'بالحذف والتقييد',
'بالحذف والطرد',
'بالحذف والحظر'
];
$m = date('y/m/d h:i');
$d = date('D');
$ch = "https://t.me/".str_replace('@',null,$c);
$channel = "[قناة السورس]($ch)";
$us = bot('getme',[])->result->username;
if($d == "Sat"){
unset($groups_json["spam"]["Fri"]);
file_put_contents('groups_json.json',json_encode($groups_json,64|128|256));
}
if($d == "Sun"){
unset($groups_json["spam"]["Sat"]);
file_put_contents('groups_json.json',json_encode($groups_json,64|128|256));
}
if($d == "Mon"){
unset($groups_json["spam"]["Sun"]);
file_put_contents('groups_json.json',json_encode($groups_json,64|128|256));
}
if($d == "Tue"){
unset($groups_json["spam"]["Mon"]);
file_put_contents('groups_json.json',json_encode($groups_json,64|128|256));
}
if($d == "Wed"){
unset($groups_json["spam"]["The"]);
file_put_contents('groups_json.json',json_encode($groups_json,64|128|256));
}
if($d == "Thu"){
unset($groups_json["spam"]["Wed"]);
file_put_contents('groups_json.json',json_encode($groups_json,64|128|256));
}
if($d == "Fri"){
unset($groups_json["spam"]["Thu"]);
file_put_contents('groups_json.json',json_encode($groups_json,64|128|256));
}
if(isset($user) && $users_json['users'][$user] !== $from_id){
$users_json['users'][$user] = $from_id;
file_put_contents('users_json.json',json_encode($users_json,64|128|256));
}
if($message && !in_array($from_id,$ex_members) && $type == "private"){
file_put_contents('members.txt',$from_id."\n",FILE_APPEND);
}
if($text == "/start" || $text == "رجوع 🔙"){
if(in_array($from_id,$sudo) && $type == 'private'){
if(isset($sudo_json[$from_id])){
unset($sudo_json[$from_id]);
}
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"
اهلا بك في لوحة تحكم السورس 🔥.
",
'reply_to_message_id'=>$message_id,
'reply_markup'=>json_encode([
'keyboard'=>[
[['text'=>"¦ الإحصائيات"]],
[['text'=>"🇸🇦¦ تعطيل البوت"],
['text'=>"🇸🇦¦ تفعيل البوت"]],
[['text'=>"🇸🇦¦ البوت"]],
[['text'=>"🇸🇦¦ حذف رسالة /start"],
['text'=>"🇸🇦¦ تعيين رسالة /start"]],
[['text'=>"🇸🇦¦ رسالة /start"]],
[['text'=>"🇸🇦¦ تنزيل مطور"],['text'=>"🇸🇦¦ رفع مطور"]],
[['text'=>"🇸🇦¦ قائمة المطورين"]],
[['text'=>"🇸🇦¦ حذف رد عام"],['text'=>"🇸🇦¦ اضف رد عام"]],
[['text'=>"🇸🇦¦ قائمة الردود العامة"]],
[['text'=>"🇸🇦¦ توجيه للمجموعات"],['text'=>"🇸🇦¦ توجيه للخاص"]],
[['text'=>"🇸🇦¦ توجيه للكل"]],
[['text'=>"🇸🇦¦ إذاعة للمجموعات"],['text'=>"🇸🇦¦ إذاعة للخاص"]],
[['text'=>"🇸🇦¦ إذاعة للكل"]],
[['text'=>"🇸🇦¦ الغاء حظر عام"],['text'=>"🇸🇦¦ حظر عام"]],
[['text'=>"🇸🇦¦ قائمة المحظورين عام"]],
],
'resize_keyboard'=>true,
]),
]);
}}
if($text == '/start' && $type == 'private'){
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>str_ireplace(["#id","#tag","#name","#user"],[$from_id,$tag,$name,$user],$sudo_json['sudo']['start']),
'reply_to_message_id'=>$message_id,
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>'أضفني إلى مجموعتك ➕','url'=>"https://t.me/".$us."?startgroup=new"]],
],
]),
]);
}
if($text == "¦ الإحصائيات" && in_array($from_id,$sudo)){
$msg_id = bot('sendmessage',['chat_id'=>$chat_id,'text'=>"• جاري حساب الإحصائيات ",'reply_to_message_id'=>$message_id])->result->message_id;
$count = 0;
foreach($ex_txt as $group){
$get = bot('getChatMemberscount',['chat_id'=>$group]);
$count += $get->result;
if($get->ok){
}else{
$str = str_replace("$group\n",null,$groups_txt);
file_put_contents('groups_txt.txt',$str);
}
}
bot('editmessagetext',[
'chat_id'=>$chat_id,
'message_id'=>$msg_id,
'parse_mode'=>"MarkDown",
'text'=>"
• إحصائيات البوت : 
✅¦ عدد مشتركين البوت : *".
count ($ex_members)."*
✅¦ عدد المجموعات : *".
count ($ex_txt)."*
✅¦ عدد مشتركين المجموعات : *$count*",
]);
return 0;
}
if($text == "🇸🇦¦ تفعيل البوت" && in_array($from_id,$sudo)){
if($sudo_json['sudo']['bot'] !== "yes"){
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"• تم تفعيل البوت بنجاح √",
'reply_to_message_id'=>$message_id,
'reply_markup'=>json_encode([
'keyboard'=>[
[['text'=>"رجوع 🔙"]],
],
'resize_keyboard'=>true,
]),
]);
$sudo_json['sudo']['bot'] = "yes";
file_put_contents('sudo_json.json',json_encode($sudo_json,64|128|256));
return 0; 
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*• تم تفعيل البوت مسبقاً 🇸🇦*",
'reply_to_message_id'=>$message_id,
'reply_markup'=>json_encode([
'keyboard'=>[
[['text'=>"رجوع 🔙"]],
],
'resize_keyboard'=>true,
]),
]);
return 0;
}
}
if($text == "🇸🇦¦ تعطيل البوت" && in_array($from_id,$sudo)){
if($sudo_json['sudo']['bot'] !== "no"){
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"• تم تعطيل البوت بنجاح √",
'reply_to_message_id'=>$message_id,
'reply_markup'=>json_encode([
'keyboard'=>[
[['text'=>"رجوع 🔙"]],
],
'resize_keyboard'=>true,
]),
]);
$sudo_json['sudo']['bot'] = "no";
file_put_contents('sudo_json.json',json_encode($sudo_json,64|128|256));
return 0; 
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*• تم تعطيل البوت مسبقاً 🇸🇦*",
'reply_to_message_id'=>$message_id,
'reply_markup'=>json_encode([
'keyboard'=>[
[['text'=>"رجوع 🔙"]],
],
'resize_keyboard'=>true,
]),
]);
return 0;
}
}
if($text == "🇸🇦¦ البوت" && in_array($from_id,$sudo)){
$bt = str_replace(['yes','no'],['مفعل ✅','معطل ⚠'],$sudo_json['sudo']['bot']);
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*• البوت $bt*",
'reply_to_message_id'=>$message_id,
'reply_markup'=>json_encode([
'keyboard'=>[
[['text'=>"رجوع 🔙"]],
],
'resize_keyboard'=>true,
]),
]);
return 0;
}
if($text == "🇸🇦¦ تعيين رسالة /start" && in_array($from_id,$sudo)){
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"• حسناً قم بإرسال رسالة /start 🇸🇦

*• ● ملاحظة يمكنك استخدام الإختصارات التالية :*

✅¦ `#tag`  لعرض اسم المشترك مع تاك
✅¦ `#name`  لعرض اسم المشترك
✅¦ `#id`  لعرض أيدي المشترك
✅¦ `@#user`  لعرض يوزر المشترك",
'reply_to_message_id'=>$message_id,
'reply_markup'=>json_encode([
'keyboard'=>[
[['text'=>"رجوع 🔙"]],
],
'resize_keyboard'=>true,
]),
]);
$sudo_json[$from_id]['ac'] = "sendstart";
file_put_contents('sudo_json.json',json_encode($sudo_json,64|128|256));
return;
}
if($text && $sudo_json[$from_id]['ac'] == "sendstart"){
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"• تم حفظ رسالة /start بنجاح والحمد لله",
'reply_to_message_id'=>$message_id,
'reply_markup'=>json_encode([
'keyboard'=>[
[['text'=>"رجوع 🔙"]],
],
'resize_keyboard'=>true,
]),
]);
unset($sudo_json[$from_id]['ac']);
$sudo_json['sudo']['start'] = $text; 
file_put_contents('sudo_json.json',json_encode($sudo_json,64|128|256));
return 0;
}
if($text == "🇸🇦¦ حذف رسالة /start" && in_array($from_id,$sudo)){
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"• تم حذف رسالة /start",
'reply_to_message_id'=>$message_id,
'reply_markup'=>json_encode([
'keyboard'=>[
[['text'=>"رجوع 🔙"]],
],
'resize_keyboard'=>true,
]),
]);
unset($sudo_json[$from_id]['start']);
$sudo_json['sudo']['start'] = "اهلا بك عزيزي : #tag

*في بوت حماية المجموعات ✅*

لتفعيل البوت اضف البوت في مجموعتك وأرسل تفعيل ..";
file_put_contents('sudo_json.json',json_encode($sudo_json,64|128|256));
return 0;
}
if($text == "🇸🇦¦ رسالة /start" && in_array($from_id,$sudo)){
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>$sudo_json['sudo']['start'],
'reply_to_message_id'=>$message_id,
'reply_markup'=>json_encode([
'keyboard'=>[
[['text'=>"رجوع 🔙"]],
],
'resize_keyboard'=>true,
]),
]);
return 0;
}
if($text == "🇸🇦¦ رفع مطور" && in_array($from_id,$sudo)){
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>'
• حسناً عزيزي قم بإرسال أيدي أو معرف الشخص الذي تريد رفعه مطور بالبوت ✅',
'reply_to_message_id'=>$message_id,
'reply_markup'=>json_encode([
'keyboard'=>[
[['text'=>"رجوع 🔙"]],
],
'resize_keyboard'=>true,
]),
]);
$sudo_json[$from_id]['ac'] = "sendiddev";
file_put_contents('sudo_json.json',json_encode($sudo_json,64|128|256));
return 0;
}
if(( is_numeric($text) && in_array($from_id,$sudo) && $sudo_json[$from_id]['ac'] == "sendiddev") || (preg_match('/@(.*)/',$text) && in_array($from_id,$sudo) && $sudo_json[$from_id]['ac'] == "sendiddev")){
if(!in_array(id($text),$sudo_json['sudo']['devs'])){
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>'• تم إضافة المطور بنجاح والحمد لله',
'reply_to_message_id'=>$message_id,
'reply_markup'=>json_encode([
'keyboard'=>[
[['text'=>"رجوع 🔙"]],
],
'resize_keyboard'=>true,
]),
]);
unset($sudo_json[$from_id]['ac']);
$sudo_json['sudo']['devs'][] = id($text); file_put_contents('sudo_json.json',json_encode($sudo_json,64|128|256));
return 0;
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>'*• هذا الشخص مرفوع مطور مسبقاً 🇸🇦*',
'reply_to_message_id'=>$message_id,
'reply_markup'=>json_encode([
'keyboard'=>[
[['text'=>"رجوع 🔙"]],
],
'resize_keyboard'=>true,
]),
]);
unset($sudo_json[$from_id]['ac']); file_put_contents('sudo_json.json',json_encode($sudo_json,64|128|256));
return 0;
}}
if($text == "🇸🇦¦ تنزيل مطور" && in_array($from_id,$sudo)){
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>'
• حسناً عزيزي قم بإرسال أيدي أو معرف الشخص الذي تريد حذفه من المطورين',
'reply_to_message_id'=>$message_id,
'reply_markup'=>json_encode([
'keyboard'=>[
[['text'=>"رجوع 🔙"]],
],
'resize_keyboard'=>true,
]),
]);
$sudo_json[$from_id]['ac'] = "deliddev";
file_put_contents('sudo_json.json',json_encode($sudo_json,64|128|256));
return 0;
}
if(( is_numeric($text) && in_array($from_id,$sudo) && $sudo_json[$from_id]['ac'] == "deliddev") || (preg_match('/@(.*)/',$text) && in_array($from_id,$sudo) && $sudo_json[$from_id]['ac'] == "deliddev")){
if(in_array(id($text),$sudo_json['sudo']['devs'])){
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>'• تم حذف المطور بنجاح والحمد لله',
'reply_to_message_id'=>$message_id,
'reply_markup'=>json_encode([
'keyboard'=>[
[['text'=>"رجوع 🔙"]],
],
'resize_keyboard'=>true,
]),
]);
unset($sudo_json[$from_id]['ac']);
unset($sudo_json['sudo']['devs'][array_search(id($text),$sudo_json['sudo']['devs'])]); 
file_put_contents('sudo_json.json',json_encode($sudo_json,64|128|256));
return 0;
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>'*• هذا الشخص غير مرفوع مطور مسبقاً 🇸🇦*',
'reply_to_message_id'=>$message_id,
'reply_markup'=>json_encode([
'keyboard'=>[
[['text'=>"رجوع 🔙"]],
],
'resize_keyboard'=>true,
]),
]);
unset($sudo_json[$from_id]['ac']); file_put_contents('sudo_json.json',json_encode($sudo_json,64|128|256));
return 0;
}}
if($text == "🇸🇦¦ قائمة المطورين"){
if(count($sudo_json['sudo']['devs']) !== 0){
$txt = "• هذه قائمة المطورين التي قمت بإضافتهم : \n".implode ("\n",$sudo_json['sudo']['devs']);
}else{
$txt = "• لم تقم بإضافة أي مطورين !!";
}
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>$txt,
'reply_to_message_id'=>$message_id,
'reply_markup'=>json_encode([
'keyboard'=>[
[['text'=>"رجوع 🔙"]],
],
'resize_keyboard'=>true,
]),
]);
unset($sudo_json[$from_id]['ac']); file_put_contents('sudo_json.json',json_encode($sudo_json,64|128|256));
return 0;
}
if($text == "🇸🇦¦ اضف رد عام"){
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"• أهلاً بك عزيزي المطور : $tag 

• قم بإرسال كلمة الرد الآن 🔥",
'reply_to_message_id'=>$message_id,
'reply_markup'=>json_encode([
'keyboard'=>[
[['text'=>"رجوع 🔙"]],
],
'resize_keyboard'=>true,
]),
]);
$sudo_json[$from_id]['ac'] = "ad-rd";
file_put_contents('sudo_json.json',json_encode($sudo_json,64|128|256));
return 0;
}
if($text && $sudo_json[$from_id]['ac'] == "ad-rd"){
unset($sudo_json[$from_id]['ac']);
$sudo_json[$from_id]['ac'] = "send-reply";
$sudo_json[$from_id]['text-rd'] = $text;
$sudo_json[$from_id]['ac'] = "reply-rd";
file_put_contents('sudo_json.json',json_encode($sudo_json,64|128|256));
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"• أهلاً بك عزيزي المطور : $tag 

• تم حفظ كلمة الرد بنجاح 🔥

• قم بإرسال الرد ",
'reply_to_message_id'=>$message_id,
'reply_markup'=>json_encode([
'keyboard'=>[
[['text'=>"رجوع 🔙"]],
],
'resize_keyboard'=>true,
]),
]);
return 0;
}
if($message && $sudo_json[$from_id]['ac'] == "reply-rd"){
$sudo_json['rdods'][$sudo_json[$from_id]['text-rd']]['rd'] = $message_id;
$sudo_json['rdods'][$sudo_json[$from_id]['text-rd']]['from_chat_id'] = $from_id;
unset($sudo_json[$from_id]);
file_put_contents('sudo_json.json',json_encode($sudo_json,64|128|256));
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"• أهلاً بك عزيزي المطور : $tag 

• تم حفظ الرد بنجاح والحمد لله ",
'reply_to_message_id'=>$message_id,
'reply_markup'=>json_encode([
'keyboard'=>[
[['text'=>"رجوع 🔙"]],
],
'resize_keyboard'=>true,
]),
]);
return 0;
}
if($text == "🇸🇦¦ حذف رد عام"){
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"• حسناً قم بإرسال كلمة الرد الذي تريد حذفه",
'reply_to_message_id'=>$message_id,
'reply_markup'=>json_encode([
'keyboard'=>[
[['text'=>"رجوع 🔙"]],
],
'resize_keyboard'=>true,
]),
]);
$sudo_json[$from_id]['ac'] = "delrd";
file_put_contents('sudo_json.json',json_encode($sudo_json,64|128|256));
return 0;
}
if($text && $sudo_json[$from_id]['ac'] == "delrd" && in_array($from_id,$sudo)){
if(isset($sudo_json['rdods'][$text])){
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"• تم الحذف بنجاح والحمد لله",
'reply_to_message_id'=>$message_id,
'reply_markup'=>json_encode([
'keyboard'=>[
[['text'=>"رجوع 🔙"]],
],
'resize_keyboard'=>true,
]),
]);
unset($sudo_json['rdods'][$text]);
unset($sudo_json[$from_id]);
file_put_contents('sudo_json.json',json_encode($sudo_json,64|128|256));
return 0;
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"
• حدث خطأ ...
• اعد المحاولة بدون أخطاء إملائية.. ",
'reply_to_message_id'=>$message_id,
'reply_markup'=>json_encode([
'keyboard'=>[
[['text'=>"رجوع 🔙"]],
],
'resize_keyboard'=>true,
]),
]);
unset($sudo_json[$from_id]);
file_put_contents('sudo_json.json',json_encode($sudo_json,64|128|256));
return 0;
}}
if($text == "🇸🇦¦ قائمة الردود العامة" && in_array($from_id,$sudo)){
if(count($sudo_json['rdods']) == 0){
$txt = "لم تقم بإضافة أي ردود !!";
}else{
$n = 0;
foreach ($sudo_json['rdods'] as $k => $v){
$n++; 
$rdod = "*$n* - `$k`";
}
$txt = "هذه الردود التي قمت بإضافتها : \n".$rdod; 
}
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>$txt,
'reply_to_message_id'=>$message_id,
'reply_markup'=>json_encode([
'keyboard'=>[
[['text'=>"رجوع 🔙"]],
],
'resize_keyboard'=>true,
]),
]);
return 0;
}
if($text == "🇸🇦¦ توجيه للمجموعات" && in_array($from_id,$sudo)){
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>'
• حسناً قم بإرسال الرسالة التي تريد توجيهها للمجموعات',
'reply_to_message_id'=>$message_id,
'reply_markup'=>json_encode([
'keyboard'=>[
[['text'=>"رجوع 🔙"]],
],
'resize_keyboard'=>true,
]),
]);
$sudo_json[$from_id]['ac'] = "forward_groups";
file_put_contents('sudo_json.json',json_encode($sudo_json,64|128|256));
return 0;
}
if(in_array($from_id,$sudo) && $sudo_json[$from_id]['ac'] == "forward_groups"){
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>'• تم البدء بالإذاعة للمجموعات 
• عند اكتمال الإذاعة سيتم إرسال رسالة إليك إن شاء الله
• لا تقم بإرسال اي رسالة للبوت حتى اكتمال الإذاعة  ',
'reply_to_message_id'=>$message_id,
'reply_markup'=>json_encode([
'keyboard'=>[
[['text'=>"رجوع 🔙"]],
],
'resize_keyboard'=>true,
]),
]);
unset($sudo_json[$from_id]['ac']);
$IDS = $ex_txt; 
send("forward",$IDS,$message_id,$from_id);
file_put_contents('sudo_json.json',json_encode($sudo_json,64|128|256));
return 0;
}

if($text == "🇸🇦¦ توجيه للخاص" && in_array($from_id,$sudo)){
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>'
• حسناً قم بإرسال الرسالة التي تريد توجيهها لجميع مشتركين البوت',
'reply_to_message_id'=>$message_id,
'reply_markup'=>json_encode([
'keyboard'=>[
[['text'=>"رجوع 🔙"]],
],
'resize_keyboard'=>true,
]),
]);
$sudo_json[$from_id]['ac'] = "forward_private";
file_put_contents('sudo_json.json',json_encode($sudo_json,64|128|256));
return 0;
}
if(in_array($from_id,$sudo) && $sudo_json[$from_id]['ac'] == "forward_private"){
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>'• تم البدء بالإذاعة لمشتركين البوت 
• عند اكتمال الإذاعة سيتم إرسال رسالة إليك إن شاء الله
• لا تقم بإرسال اي رسالة للبوت حتى اكتمال الإذاعة  ',
'reply_to_message_id'=>$message_id,
'reply_markup'=>json_encode([
'keyboard'=>[
[['text'=>"رجوع 🔙"]],
],
'resize_keyboard'=>true,
]),
]);
unset($sudo_json[$from_id]['ac']);
$IDS = $ex_members; 
send("forward",$IDS,$message_id,$from_id);
file_put_contents('sudo_json.json',json_encode($sudo_json,64|128|256));
return 0;
}

if($text == "🇸🇦¦ توجيه للكل" && in_array($from_id,$sudo)){
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>'
• حسناً قم بإرسال الرسالة التي تريد توجيهها للكل',
'reply_to_message_id'=>$message_id,
'reply_markup'=>json_encode([
'keyboard'=>[
[['text'=>"رجوع 🔙"]],
],
'resize_keyboard'=>true,
]),
]);
$sudo_json[$from_id]['ac'] = "forward_all";
file_put_contents('sudo_json.json',json_encode($sudo_json,64|128|256));
return 0;
}
if(in_array($from_id,$sudo) && $sudo_json[$from_id]['ac'] == "forward_all"){
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>'• تم البدء بالإذاعة للكل 
• عند اكتمال الإذاعة سيتم إرسال رسالة إليك إن شاء الله
• لا تقم بإرسال اي رسالة للبوت حتى اكتمال الإذاعة  ',
'reply_to_message_id'=>$message_id,
]);
unset($sudo_json[$from_id]['ac']);
$IDS = array_merge($ex_members,$ex_txt); 
send("forward",$IDS,$message_id,$from_id);
file_put_contents('sudo_json.json',json_encode($sudo_json,64|128|256));
return 0;
}
if($text == "🇸🇦¦ إذاعة للمجموعات" && in_array($from_id,$sudo)){
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>'
• حسناً قم بإرسال الرسالة التي تريد إرسالها للمجموعات',
'reply_to_message_id'=>$message_id,
'reply_markup'=>json_encode([
'keyboard'=>[
[['text'=>"رجوع 🔙"]],
],
'resize_keyboard'=>true,
]),
]);
$sudo_json[$from_id]['ac'] = "send_groups";
file_put_contents('sudo_json.json',json_encode($sudo_json,64|128|256));
return 0;
}
if(in_array($from_id,$sudo) && $sudo_json[$from_id]['ac'] == "send_groups"){
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>'• تم البدء بالإذاعة للمجموعات 
• عند اكتمال الإذاعة سيتم إرسال رسالة إليك إن شاء الله
• لا تقم بإرسال اي رسالة للبوت حتى اكتمال الإذاعة  ',
'reply_to_message_id'=>$message_id,
]);
unset($sudo_json[$from_id]['ac']);
$IDS = $ex_txt; 
send("send",$IDS,$message_id,$from_id);
file_put_contents('sudo_json.json',json_encode($sudo_json,64|128|256));
return 0;
}

if($text == "🇸🇦¦ إذاعة للخاص" && in_array($from_id,$sudo)){
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>'
• حسناً قم بإرسال الرسالة التي تريد إرسالها لجميع مشتركين البوت',
'reply_to_message_id'=>$message_id,
'reply_markup'=>json_encode([
'keyboard'=>[
[['text'=>"رجوع 🔙"]],
],
'resize_keyboard'=>true,
]),
]);
$sudo_json[$from_id]['ac'] = "send_private";
file_put_contents('sudo_json.json',json_encode($sudo_json,64|128|256));
return 0;
}
if(in_array($from_id,$sudo) && $sudo_json[$from_id]['ac'] == "send_private"){
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>'• تم البدء بالإذاعة لمشتركين البوت 
• عند اكتمال الإذاعة سيتم إرسال رسالة إليك إن شاء الله
• لا تقم بإرسال اي رسالة للبوت حتى اكتمال الإذاعة  ',
'reply_to_message_id'=>$message_id,
]);
unset($sudo_json[$from_id]['ac']);
$IDS = $ex_members; 
send("send",$IDS,$message_id,$from_id);
file_put_contents('sudo_json.json',json_encode($sudo_json,64|128|256));
return 0;
}

if($text == "🇸🇦¦ إذاعة للكل" && in_array($from_id,$sudo)){
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>'
• حسناً قم بإرسال الرسالة التي تريد إرسالها للكل',
'reply_to_message_id'=>$message_id,
'reply_markup'=>json_encode([
'keyboard'=>[
[['text'=>"رجوع 🔙"]],
],
'resize_keyboard'=>true,
]),
]);
$sudo_json[$from_id]['ac'] = "send_all";
file_put_contents('sudo_json.json',json_encode($sudo_json,64|128|256));
return 0;
}
if(in_array($from_id,$sudo) && $sudo_json[$from_id]['ac'] == "send_all"){
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>'• تم البدء بالإذاعة للكل 
• عند اكتمال الإذاعة سيتم إرسال رسالة إليك إن شاء الله
• لا تقم بإرسال اي رسالة للبوت حتى اكتمال الإذاعة  ',
'reply_to_message_id'=>$message_id,
]);
unset($sudo_json[$from_id]['ac']);
$IDS = array_merge($ex_members,$ex_txt); 
send("send",$IDS,$message_id,$from_id);
file_put_contents('sudo_json.json',json_encode($sudo_json,64|128|256));
return 0;
}
if($text == "🇸🇦¦ حظر عام" && in_array($from_id,$sudo)){
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>'
• حسناً عزيزي قم بإرسال أيدي أو معرف الشخص الذي تريد حظره عام من المجموعات ✅',
'reply_to_message_id'=>$message_id,
'reply_markup'=>json_encode([
'keyboard'=>[
[['text'=>"رجوع 🔙"]],
],
'resize_keyboard'=>true,
]),
]);
$sudo_json[$from_id]['ac'] = "sendidbanm";
file_put_contents('sudo_json.json',json_encode($sudo_json,64|128|256));
return 0;
}
if(( is_numeric($text) && in_array($from_id,$sudo) && $sudo_json[$from_id]['ac'] == "sendidbanm") || (preg_match('/@(.*)/',$text) && in_array($from_id,$sudo) && $sudo_json[$from_id]['ac'] == "sendidbanm")){
if(!in_array(id($text),$sudo_json['sudo']['membans'])){
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>'• تم حظر الشخص بنجاح والحمد لله',
'reply_to_message_id'=>$message_id,
]);
unset($sudo_json[$from_id]['ac']);
$sudo_json['sudo']['membans'][] = id($text); file_put_contents('sudo_json.json',json_encode($sudo_json,64|128|256));
action ("ban",$ex_txt,id($text));
return 0;
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>'*
• هذا الشخص محظور عام مسبقاً 🇸🇦*',
'reply_to_message_id'=>$message_id,
'reply_markup'=>json_encode([
'keyboard'=>[
[['text'=>"رجوع 🔙"]],
],
'resize_keyboard'=>true,
]),
]);
unset($sudo_json[$from_id]['ac']); file_put_contents('sudo_json.json',json_encode($sudo_json,64|128|256));
return 0;
}}
if($text == "🇸🇦¦ الغاء حظر عام" && in_array($from_id,$sudo)){
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>'
• حسناً عزيزي قم بإرسال أيدي أو معرف الشخص الذي تريد الغاء حظره',
'reply_to_message_id'=>$message_id,
'reply_markup'=>json_encode([
'keyboard'=>[
[['text'=>"رجوع 🔙"]],
],
'resize_keyboard'=>true,
]),
]);
$sudo_json[$from_id]['ac'] = "delidbanm";
file_put_contents('sudo_json.json',json_encode($sudo_json,64|128|256));
return 0;
}
if(( is_numeric($text) && in_array($from_id,$sudo) && $sudo_json[$from_id]['ac'] == "delidbanm") || (preg_match('/@(.*)/',$text) && in_array($from_id,$sudo) && $sudo_json[$from_id]['ac'] == "delidbanm")){
if(in_array(id($text),$sudo_json['sudo']['membans'])){
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>'• تم الغاء حظر الشخص بنجاح والحمد لله',
'reply_to_message_id'=>$message_id,
]);
unset($sudo_json[$from_id]['ac']);
unset($sudo_json['sudo']['membans'][array_search(id($text),$sudo_json['sudo']['membans'])]); 
file_put_contents('sudo_json.json',json_encode($sudo_json,64|128|256));
action ("unban",$ex_txt,id($text));
return 0;
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>'*• هذا الشخص غير مرفوع مطور مسبقاً 🇸🇦*',
'reply_to_message_id'=>$message_id,
'reply_markup'=>json_encode([
'keyboard'=>[
[['text'=>"رجوع 🔙"]],
],
'resize_keyboard'=>true,
]),
]);
unset($sudo_json[$from_id]['ac']); file_put_contents('sudo_json.json',json_encode($sudo_json,64|128|256));
return 0;
}}
if($text == "🇸🇦¦ قائمة المحظورين عام"){
if(count($sudo_json['sudo']['membans']) !== 0){
$txt = "• هذه قائمة المحظورين : \n".implode ("\n",$sudo_json['sudo']['membans']);
}else{
$txt = "• لم تقم بحظر أي شخص !!";
}
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>$txt,
'reply_to_message_id'=>$message_id,
'reply_markup'=>json_encode([
'keyboard'=>[
[['text'=>"رجوع 🔙"]],
],
'resize_keyboard'=>true,
]),
]);
unset($sudo_json[$from_id]['ac']); file_put_contents('sudo_json.json',json_encode($sudo_json,64|128|256));
return 0;
}
if($text !== "تفعيل" && $text !== "تفعيل البوت" && $text !== "/start@$us"){
if(!in_array($chat_id,$ex_txt)){
return false; 
}}
if($text == "تفعيل" || $text == "تفعيل البوت" || $text == "/start@$us" && $type !== "private"){
if(is_admin($from_id,$chat_id,"view") == "creator" && $sudo_json['sudo']['bot'] == "no" && !in_array($from_id,$sudo) && !in_array($from_id,$sudo_json['sudo']['devs'])){
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"* يمكن للمطور تفعيل البوت فقط 🇸🇦",
'reply_to_message_id'=>$message_id,
]);
return 0;
}}
if($text == "تفعيل" || $text == "تفعيل البوت" || $text == "/start@$us" && $type !== "private"){
if((is_admin($from_id,$chat_id,"view") == "creator" && $sudo_json['sudo']['bot'] == "yes" ) || ( in_array($from_id,$sudo) || in_array($from_id,$sudo_json['sudo']['devs']) )){
if(!in_array($chat_id,$ex_txt)){
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"أهلاً بك : $tag

* تم تفعيل المجموعة بنجاح ✅*

لمعرفة الاوامر ارسل كلمة `الاوامر`",
'reply_to_message_id'=>$message_id,
]);
file_put_contents('groups_txt.txt',$chat_id."\n",FILE_APPEND);
return false;
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"* المجموعة مفعلة مسبقاً 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"* هذا الأمر يخص المنشى الأساسي أو المطور فقط 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}
if($text == "الغاء التفعيل" || $text == "الغاء تفعيل البوت"){
if(is_admin($from_id,$chat_id,"view") == "creator" || in_array($from_id,$sudo)){
if(in_array($chat_id,$ex_txt)){
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"أهلاً بك : $tag

* تم الغاء تفعيل المجموعة بنجاح ✅*",
'reply_to_message_id'=>$message_id,
]);
$str = str_replace("$chat_id\n",null,$groups_txt);
file_put_contents('groups_txt.txt',$str);
return false;
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"* المجموعة غير مفعلة مسبقاً 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"* هذا الأمر يخص المنشى الأساسي أو المطور فقط 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}
if(preg_match('/(.*) @(.*)/',$text,$tu)){
if(!id($tu[2])){
return false;
}}
if(!is_admin($from_id,$chat_id) && !in_array($from_id,$groups_json['groups'][$chat_id]['managers']) && !in_array($from_id,$groups_json['groups'][$chat_id]['features']) && !in_array($from_id,$sudo) && !in_array($from_id,$sudo_json['sudo']['devs'])){
if(!$notice && $message &&  $groups_json['groups'][$chat_id]['setting']['chat'] == "no"){
bot('deleteMessage',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
]);
}
if($photo &&  $groups_json['groups'][$chat_id]['setting']['photo'] == "no"){
bot('deleteMessage',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
]);
}
if($video &&  $groups_json['groups'][$chat_id]['setting']['video'] == "no"){
bot('deleteMessage',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
]);
}
if($notice &&  $groups_json['groups'][$chat_id]['setting']['notices'] == "no"){
bot('deleteMessage',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
]);
}
if(mb_strlen($text) > 750 &&  $groups_json['groups'][$chat_id]['setting']['texts'] == "no"){
bot('deleteMessage',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
]);
}
if($sticker &&  $groups_json['groups'][$chat_id]['setting']['sticker'] == "no"){
bot('deleteMessage',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
]);
}
if($voice &&  $groups_json['groups'][$chat_id]['setting']['voice'] == "no"){
bot('deleteMessage',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
]);
}
if($animation &&  $groups_json['groups'][$chat_id]['setting']['animation'] == "no"){
bot('deleteMessage',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
]);
}
if($sticker &&  $groups_json['groups'][$chat_id]['setting']['sticker'] == "no"){
bot('deleteMessage',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
]);
}
if($audio &&  $groups_json['groups'][$chat_id]['setting']['audio'] == "no"){
bot('deleteMessage',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
]);
}
if($document &&  $groups_json['groups'][$chat_id]['setting']['document'] == "no"){
bot('deleteMessage',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
]);
}
if($message->forward_from || $message->forward_from_chat){
if($groups_json['groups'][$chat_id]['setting']['forward'] == "no"){
bot('deleteMessage',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
]);
}}
if($mark &&  $groups_json['groups'][$chat_id]['setting']['mark'] == "no"){
bot('deleteMessage',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
]);
}
if($message->new_chat_participant->is_bot && $groups_json['groups'][$chat_id]['setting']['bots'] == "no"){ 
if(!is_admin($from_id,$chat_id) && !in_array($from_id,$groups_json['groups'][$chat_id]['managers']) && !in_array($from_id,$sudo) && !in_array($from_id,$sudo_json['sudo']['devs'])){
bot('KickChatMember',[
'chat_id'=>$chat_id,
'user_id'=>$message->new_chat_participant->id,
]);
}}
if($inline &&  $groups_json['groups'][$chat_id]['setting']['inline'] == "no"){
bot('deleteMessage',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
]);
}
if($text !== "@admin" && preg_match('/@(.*)/',$text) && $groups_json['groups'][$chat_id]['setting']['users'] == "no"){
bot('deleteMessage',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
]);
}
if($update->message->contact &&  $groups_json['groups'][$chat_id]['setting']['contect'] == "no"){
bot('deleteMessage',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
]);
}
if(preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$text) && $groups_json['groups'][$chat_id]['setting']['link'] == "no"){
bot('deleteMessage',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
]);
}
if($message->sender_chat->type == "channel" && $groups_json['groups'][$chat_id]['setting']['channels'] == "no"){
bot('deletemessage',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
]);
bot('banChatSenderChat',[
'chat_id'=>$chat_id,
'sender_chat_id'=>$message->sender_chat->id
]);
}
if($edit &&  $groups_json['groups'][$chat_id]['setting']['edit'] == "no"){
bot('deleteMessage',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
]);
}
}
if($type !== 'private'){
$ar = ['الاشعارات','الصور','الفيديوهات','الصوتيات','المقاطع الصوتية','القنوات','الدردشة','الكل'
,'جهات الاتصال','الملصقات','الروابط','الملفات','المتحركات','التعديل','الانلاين','المعرفات','المارك','التوجيه','المنشورات','البوتات'];
$en = ['notices','photo','video','voice','audio','channels','chat','all','contect','sticker','link','document','animation','edit','inline','users','mark','forward','texts','bots'];
if(!$groups_json['groups'][$chat_id]['setting']){
$groups_json['groups'][$chat_id]['setting']['photo'] = 
$groups_json['groups'][$chat_id]['setting']['video'] = 
$groups_json['groups'][$chat_id]['setting']['bots'] =
$groups_json['groups'][$chat_id]['setting']['contect'] = 
$groups_json['groups'][$chat_id]['setting']['voice'] = 
$groups_json['groups'][$chat_id]['setting']['audio'] = 
$groups_json['groups'][$chat_id]['setting']['channels'] = 
$groups_json['groups'][$chat_id]['setting']['animation']
= $groups_json['groups'][$chat_id]['setting']['chat'] = 
$groups_json['groups'][$chat_id]['setting']['notices'] = 
$groups_json['groups'][$chat_id]['setting']['all'] = 
$groups_json['groups'][$chat_id]['setting']['sticker'] = 
$groups_json['groups'][$chat_id]['setting']['link'] = 
$groups_json['groups'][$chat_id]['setting']['document'] = 
$groups_json['groups'][$chat_id]['setting']['inline'] = 
$groups_json['groups'][$chat_id]['setting']['edit'] = 
$groups_json['groups'][$chat_id]['setting']['mark'] = 
$groups_json['groups'][$chat_id]['setting']['users'] = 
$groups_json['groups'][$chat_id]['setting']['forward'] = 
$groups_json['groups'][$chat_id]['setting']['texts'] = 
"yes";
$groups_json["groups"][$chat_id]["acs"]["spam"] = "10";
$groups_json["groups"][$chat_id]["acs"]["typespam"] = "بالحذف والتقييد";
$groups_json["groups"][$chat_id]["acs"]["idphoto"] == "no";
file_put_contents('groups_json.json',json_encode($groups_json,64|128|256));
}
if(preg_match("/^كتم (.*)/",$text,$matches) && !is_admin(id($matches[1]),$chat_id) && !in_array(id($matches[1]),$groups_json['groups'][$chat_id]['managers']) && !in_array(id($matches[1]),$groups_json['groups'][$chat_id]['admins'])){
if(is_admin($from_id,$chat_id)  || in_array($from_id,$groups_json['groups'][$chat_id]['managers']) || in_array($from_id,$sudo) || in_array($from_id,$sudo_json['sudo']['devs'])){
if(!in_array(id($matches[1]),$groups_json['groups'][$chat_id]['silencers'])){
$geinfo = get_info(id($matches[1]),"member")['title'];
$tg = "tg://user?id=".id($matches[1]);
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>" المستخدم : [$geinfo]($tg)

*تم كتمه بنجاح ✅*

بواسطة : $tag",
'reply_to_message_id'=>$message_id,
]);
$groups_json['groups'][$chat_id]['silencers'][] = id($matches[1]);
file_put_contents('groups_json.json',json_encode($groups_json,64|128|256));
return false;
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"* هذا العضو مكتوم مسبقاً 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"* هذا الأمر مخصص فقط للادمن 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}
if(isset($reply_id) && $text == "كتم" && !is_admin($reply_id,$chat_id) && !in_array($reply_id,$groups_json['groups'][$chat_id]['managers']) && !in_array($reply_id,$groups_json['groups'][$chat_id]['admins'])){
if(is_admin($from_id,$chat_id)  || in_array($from_id,$groups_json['groups'][$chat_id]['managers']) || in_array($from_id,$sudo) || in_array($from_id,$sudo_json['sudo']['devs'])){
if(!in_array($reply_id,$groups_json['groups'][$chat_id]['silencers'])){
$tg = "tg://user?id=".$reply_id;
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>" المستخدم : $reply_tag

*تم كتمه بنجاح ✅*

بواسطة : $tag",
'reply_to_message_id'=>$message_id,
]);
$groups_json['groups'][$chat_id]['silencers'][] = $reply_id;
file_put_contents('groups_json.json',json_encode($groups_json,64|128|256));
return false;
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"* هذا العضو مكتوم مسبقاً 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"* هذا الأمر مخصص فقط للادمن 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}
if($message && in_array($from_id,$groups_json['groups'][$chat_id]['silencers'])){
bot('deletemessage',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
]);
return false;
}
if(preg_match("/^الغاء الكتم (.*)/",$text,$matches) && !is_admin(id($matches[1]),$chat_id) && !in_array(id($matches[1]),$groups_json['groups'][$chat_id]['managers']) && !in_array(id($matches[1]),$groups_json['groups'][$chat_id]['admins'])){
if(is_admin($from_id,$chat_id)  || in_array($from_id,$groups_json['groups'][$chat_id]['managers']) || in_array($from_id,$sudo) || in_array($from_id,$sudo_json['sudo']['devs'])){
if(in_array(id($matches[1]),$groups_json['groups'][$chat_id]['silencers'])){
$geinfo = get_info(id($matches[1]),"member")['title'];
$tg = "tg://user?id=".id($matches[1]);
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>" المستخدم : [$geinfo]($tg)

*تم الغاء كتمه بنجاح ✅*

بواسطة : $tag",
'reply_to_message_id'=>$message_id,
]);
unset($groups_json['groups'][$chat_id]['silencers'][array_search(id($matches[1]),$groups_json['groups'][$chat_id]['silencers'])]);
file_put_contents('groups_json.json',json_encode($groups_json,64|128|256));
return false;
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"* هذا العضو غير مكتوم مسبقاً 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"* هذا الأمر مخصص فقط للادمن 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}
if(isset($reply_id) && $text == "الغاء الكتم"){
if(is_admin($from_id,$chat_id)  || in_array($from_id,$groups_json['groups'][$chat_id]['managers']) || in_array($from_id,$sudo) || in_array($from_id,$sudo_json['sudo']['devs'])){
if(in_array($reply_id,$groups_json['groups'][$chat_id]['silencers'])){
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>" المستخدم : $reply_tag

*تم الغاء كتمه بنجاح ✅*

بواسطة : $tag",
'reply_to_message_id'=>$message_id,
]);
unset($groups_json['groups'][$chat_id]['silencers'][array_search($reply_id,$groups_json['groups'][$chat_id]['silencers'])]);
file_put_contents('groups_json.json',json_encode($groups_json,64|128|256));
return false;
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"* هذا العضو غير مكتوم مسبقاً 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"* هذا الأمر مخصص فقط للادمن 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}

if(preg_match("/^تقييد (.*)/",$text) && empty($reply_id)){
$matches=[];
$matches = T($text);
if(!is_admin(id($matches[1]),$chat_id) && !in_array(id($matches[1]),$groups_json['groups'][$chat_id]['managers']) && !in_array(id($matches[1]),$groups_json['groups'][$chat_id]['admins'])){
if(is_admin($from_id,$chat_id)  || in_array($from_id,$groups_json['groups'][$chat_id]['managers']) || in_array($from_id,$sudo) || in_array($from_id,$sudo_json['sudo']['devs'])){
$TimeD = !empty (str_replace("تقييد $matches[1]",null,$text)) ? str_replace("تقييد $matches[1]",null,$text) : '';
$TimeT = !empty (str_replace("تقييد $matches[1]",null,$text)) ? 'لمدة'.$TimeD : '';
$geinfo = get_info(id($matches[1]),"member")['title'];
$tg = "tg://user?id=".id($matches[1]);
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"المستخدم : [$geinfo]($tg) 

*تم تقييده بنجاح $TimeT ✅*

بواسطة : $tag",
'reply_to_message_id'=>$message_id,
]);
if(!isset($TimeD)){
bot('restrictChatMember',[
'user_id'=>id($matches[1]),   
   'chat_id'=>$chat_id,
  'can_post_messages'=>false,
]);
}else{
bot('restrictChatMember',[
'user_id'=>id($matches[1]),   
   'chat_id'=>$chat_id,
  'can_post_messages'=>false,
'until_date'=>DTime($TimeD),
]);
}
$groups_json['groups'][$chat_id]['enrollers'][] = id($matches[1]);
file_put_contents('groups_json.json',json_encode($groups_json,64|128|256));
return false;
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"* هذا الأمر مخصص فقط للادمن 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}}
if(preg_match("/^تقييد/",$text) && isset($reply_id)){
$matches=[];
if($text == "تقييد"){
$TimeD = $TimeT = null;
}else{
preg_match("/^تقييد (.*)/",$text,$matches);
$TimeD = $matches[1];
$TimeT = "لمدة ".$matches[1];
}
if(!is_admin($reply_id,$chat_id) && !in_array($reply_id,$groups_json['groups'][$chat_id]['managers']) && !in_array($reply_id,$groups_json['groups'][$chat_id]['admins'])){
if(is_admin($from_id,$chat_id)  || in_array($from_id,$groups_json['groups'][$chat_id]['managers']) || in_array($from_id,$sudo) || in_array($from_id,$sudo_json['sudo']['devs'])){
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"المستخدم : $reply_tag

*تم تقييده بنجاح $TimeT ✅*

بواسطة : $tag",
'reply_to_message_id'=>$message_id,
]);
if(!isset($TimeD)){
bot('restrictChatMember',[
'user_id'=>$reply_id,   
   'chat_id'=>$chat_id,
  'can_post_messages'=>false,
]);
}else{
bot('restrictChatMember',[
'user_id'=>$reply_id,   
   'chat_id'=>$chat_id,
  'can_post_messages'=>false,
'until_date'=>DTime($TimeD),
]);
}
$groups_json['groups'][$chat_id]['enrollers'][] = $reply_id;
file_put_contents('groups_json.json',json_encode($groups_json,64|128|256));
return false;
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"* هذا الأمر مخصص فقط للادمن 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}}
if(preg_match("/^الغاء التقييد (.*)/",$text,$matches)){
if(!is_admin(id($matches[1]),$chat_id) && !in_array(id($matches[1]),$groups_json['groups'][$chat_id]['managers']) && !in_array(id($matches[1]),$groups_json['groups'][$chat_id]['admins'])){
if(is_admin($from_id,$chat_id)  || in_array($from_id,$groups_json['groups'][$chat_id]['managers']) || in_array($from_id,$sudo) || in_array($from_id,$sudo_json['sudo']['devs'])){
$geinfo = get_info(id($matches[1]),"member")['title'];
$tg = "tg://user?id=".id($matches[1]);
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"المستخدم : [$geinfo]($tg) 

*تم فك تقييده بنجاح ✅*

بواسطة : $tag",
'reply_to_message_id'=>$message_id,
]);
bot('restrictChatMember',[
'chat_id'=>$chat_id,
'user_id'=>id($matches[1]),
'can_post_messages'=>true,
'can_add_web_page_previews'=>false,
'can_send_other_messages'=>true,
'can_send_media_messages'=>true,
]);
unset($groups_json['groups'][$chat_id]['enrollers'][array_search(id($matches[1]),$groups_json['groups'][$chat_id]['enrollers'])]);
file_put_contents('groups_json.json',json_encode($groups_json,64|128|256));
return false;
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"* هذا الأمر مخصص فقط للادمن 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}}
if($text == "الغاء التقييد" && isset($reply_id)){
if(is_admin($from_id,$chat_id)  || in_array($from_id,$groups_json['groups'][$chat_id]['managers']) || in_array($from_id,$sudo) || in_array($from_id,$sudo_json['sudo']['devs'])){
if(!is_admin($reply_id,$chat_id) && !in_array($reply_id,$groups_json['groups'][$chat_id]['managers']) && !in_array($reply_id,$groups_json['groups'][$chat_id]['admins'])){
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"المستخدم : $reply_tag

*تم فك تقييده بنجاح ✅*

بواسطة : $tag",
'reply_to_message_id'=>$message_id,
]);
bot('restrictChatMember',[
'chat_id'=>$chat_id,
'user_id'=>$reply_id,
'can_post_messages'=>true,
'can_add_web_page_previews'=>false,
'can_send_other_messages'=>true,
'can_send_media_messages'=>true,
]);
unset($groups_json['groups'][$chat_id]['enrollers'][array_search($reply_id,$groups_json['groups'][$chat_id]['enrollers'])]);
file_put_contents('groups_json.json',json_encode($groups_json,64|128|256));
return false;
}}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"* هذا الأمر مخصص فقط للادمن 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}
if($text == "رفع مدير" && isset($reply_id)){
if(is_admin($from_id,$chat_id,"view") == "creator" || in_array($from_id,$sudo) || in_array($from_id,$sudo_json['sudo']['devs'])){
if(!in_array($reply_id,$groups_json['groups'][$chat_id]['managers'])){
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"المستخدم : $reply_tag

*تم رفعه مدير بنجاح ✅*

بواسطة : $tag",
'reply_to_message_id'=>$message_id,
]);
$groups_json['groups'][$chat_id]['managers'][] = $reply_id;
file_put_contents('groups_json.json',json_encode($groups_json,64|128|256));
return false;
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*تم رفع هذا العضو مدير مسبقاً 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*هذا الأمر يخص المنشى الاساسي فقط 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}
if(preg_match("/^رفع مدير (.*)/",$text,$matches)){
if(is_admin($from_id,$chat_id,"view") == "creator" || in_array($from_id,$sudo) || in_array($from_id,$sudo_json['sudo']['devs'])){
if(!in_array(id($matches[1]),$groups_json['groups'][$chat_id]['managers'])){
$geinfo = get_info(id($matches[1]),"member")['title'];
$tg = "tg://user?id=".id($matches[1]);
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"المستخدم : [$geinfo]($tg)

*تم رفعه مدير بنجاح ✅*

بواسطة : $tag",
'reply_to_message_id'=>$message_id,
]);
$groups_json['groups'][$chat_id]['managers'][] = id($matches[1]);
file_put_contents('groups_json.json',json_encode($groups_json,64|128|256));
return false;
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*تم رفع هذا العضو مدير مسبقاً 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*هذا الأمر يخص المنشى الاساسي فقط 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}
if($text == "تنزيل مدير" && isset($reply_id)){
if(is_admin($from_id,$chat_id,"view") == "creator" || in_array($from_id,$sudo) || in_array($from_id,$sudo_json['sudo']['devs'])){
if(in_array($reply_id,$groups_json['groups'][$chat_id]['managers'])){
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"المستخدم : $reply_tag

*تم تنزيله من المدير بنجاح ✅*

بواسطة : $tag",
'reply_to_message_id'=>$message_id,
]);
unset($groups_json['groups'][$chat_id]['managers'][array_search($reply_id,$groups_json['groups'][$chat_id]['managers'])]);
file_put_contents('groups_json.json',json_encode($groups_json,64|128|256));
return false;
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*هذا العضو ليس مدير مسبقاً 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*هذا الأمر يخص المنشى الاساسي فقط 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}
if(preg_match("/^تنزيل مدير (.*)/",$text,$matches)){
if(is_admin($from_id,$chat_id,"view") == "creator" || in_array($from_id,$sudo) || in_array($from_id,$sudo_json['sudo']['devs'])){
if(in_array(id($matches[1]),$groups_json['groups'][$chat_id]['managers'])){
$geinfo = get_info(id($matches[1]),"member")['title'];
$tg = "tg://user?id=".id($matches[1]);
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"المستخدم : [$geinfo]($tg)

*تم تنزيله من المدير بنجاح ✅*

بواسطة : $tag",
'reply_to_message_id'=>$message_id,
]);
unset($groups_json['groups'][$chat_id]['managers'][array_search(id($matches[1]),$groups_json['groups'][$chat_id]['managers'])]);
file_put_contents('groups_json.json',json_encode($groups_json,64|128|256));
return false;
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*هذا العضو ليس مدير مسبقاً 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*هذا الأمر يخص المنشى الاساسي فقط 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}
if($text == "المكتومين"){
if(is_admin($from_id,$chat_id)  || in_array($from_id,$groups_json['groups'][$chat_id]['managers']) || in_array($from_id,$sudo) || in_array($from_id,$sudo_json['sudo']['devs'])){
if(count ($groups_json['groups'][$chat_id]['silencers']) !== 0){
foreach ($groups_json['groups'][$chat_id]['silencers'] as $silencer){
$get_info = get_info($silencer,"member")['title'];
$mem .="[$get_info](tg://user?id=$silencer)\n";
}
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*المكتومين : *
$mem",
'reply_to_message_id'=>$message_id,
]);
return false;
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*لا يوجد مكتومين 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*هذا الأمر يخص المدير أو المنشى الاساسي فقط 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}
if($text == "مسح المكتومين"){
if(is_admin($from_id,$chat_id)  || in_array($from_id,$groups_json['groups'][$chat_id]['managers']) || in_array($from_id,$sudo) || in_array($from_id,$sudo_json['sudo']['devs'])){
if(count ($groups_json['groups'][$chat_id]['silencers']) !== 0){
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*تم مسح المكتومين بنجاح ✅* 

بواسطة : $tag",
'reply_to_message_id'=>$message_id,
]);
unset($groups_json['groups'][$chat_id]['silencers']);
file_put_contents('groups_json.json',json_encode($groups_json,64|128|256));
return false;
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*لا يوجد مكتومين 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*هذا الأمر يخص المدير أو المنشى الاساسي فقط 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}
if($text == "مسح المقيدين"){
if(is_admin($from_id,$chat_id)  || in_array($from_id,$groups_json['groups'][$chat_id]['managers']) || in_array($from_id,$sudo) || in_array($from_id,$sudo_json['sudo']['devs'])){
if(count ($groups_json['groups'][$chat_id]['enrollers']) !== 0){
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*تم مسح المقيدين بنجاح ✅* 

بواسطة : $tag",
'reply_to_message_id'=>$message_id,
]);
foreach ($groups_json['groups'][$chat_id]['enrollers'] as $enroller){
bot('restrictChatMember',[
'chat_id'=>$chat_id,
'user_id'=>$enroller,
'can_post_messages'=>true,
'can_add_web_page_previews'=>false,
'can_send_other_messages'=>true,
'can_send_media_messages'=>true,
]);
}
unset($groups_json['groups'][$chat_id]['enrollers']);
file_put_contents('groups_json.json',json_encode($groups_json,64|128|256));
return false;
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*لا يوجد مقيدين 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*هذا الأمر يخص المدير أو المنشى الاساسي فقط 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}
if($text == "المقيدين"){
if(is_admin($from_id,$chat_id)  || in_array($from_id,$groups_json['groups'][$chat_id]['managers']) || in_array($from_id,$sudo) || in_array($from_id,$sudo_json['sudo']['devs'])){
if(count ($groups_json['groups'][$chat_id]['enrollers']) !== 0){
foreach ($groups_json['groups'][$chat_id]['enrollers'] as $enroller){
$get_info = get_info($enroller,"member")['title'];
$mem .="[$get_info](tg://user?id=$enroller)\n";
}
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*المقيدين : *
$mem",
'reply_to_message_id'=>$message_id,
]);
return false;
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*لا يوجد مقيدين 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*هذا الأمر يخص المدير أو المنشى الاساسي فقط 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}
if(preg_match("/^طرد (.*)/",$text,$matches) && !is_admin(id($matches[1]),$chat_id) && !in_array(id($matches[1]),$groups_json['groups'][$chat_id]['managers']) && !in_array(id($matches[1]),$groups_json['groups'][$chat_id]['admins'])){
if(is_admin($from_id,$chat_id)  || in_array($from_id,$groups_json['groups'][$chat_id]['managers']) || in_array($from_id,$sudo) || in_array($from_id,$sudo_json['sudo']['devs'])){
if(!in_array(id($matches[1]),$groups_json['groups'][$chat_id]['expelleres'])){
$geinfo = get_info(id($matches[1]),"member")['title'];
$tg = "tg://user?id=".id($matches[1]);
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>" المستخدم : [$geinfo]($tg)

*تم طرده بنجاح ✅*

بواسطة : $tag",
'reply_to_message_id'=>$message_id,
]);
$groups_json['groups'][$chat_id]['expelleres'][] = id($matches[1]);
bot('KickChatMember',[
'chat_id'=>$chat_id,
'user_id'=>id($matches[1]),
]);
bot('UnbanChatmember',[
'chat_id'=>$chat_id,
'user_id'=>id($matches[1]),
]);
file_put_contents('groups_json.json',json_encode($groups_json,64|128|256));
return false;
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"* هذا العضو مطرود مسبقاً 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"* هذا الأمر مخصص فقط للادمن 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}
if(isset($reply_id) && $text == "طرد" && !is_admin($reply_id,$chat_id) && !in_array($reply_id,$groups_json['groups'][$chat_id]['managers']) && !in_array($reply_id,$groups_json['groups'][$chat_id]['admins'])){
if(is_admin($from_id,$chat_id)  || in_array($from_id,$groups_json['groups'][$chat_id]['managers']) || in_array($from_id,$sudo) || in_array($from_id,$sudo_json['sudo']['devs'])){
if(!in_array($reply_id,$groups_json['groups'][$chat_id]['expelleres'])){
$tg = "tg://user?id=".$reply_id;
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>" المستخدم : $reply_tag

*تم طرده بنجاح ✅*

بواسطة : $tag",
'reply_to_message_id'=>$message_id,
]);
$groups_json['groups'][$chat_id]['expelleres'][] = $reply_id;
bot('KickChatMember',[
'chat_id'=>$chat_id,
'user_id'=>$reply_id,
]);
bot('UnbanChatmember',[
'chat_id'=>$chat_id,
'user_id'=>$reply_id,
]);
file_put_contents('groups_json.json',json_encode($groups_json,64|128|256));
return false;
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"* هذا العضو مطرود مسبقاً 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"* هذا الأمر مخصص فقط للادمن 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}
if($text == "مسح المطرودين"){
if(is_admin($from_id,$chat_id)  || in_array($from_id,$groups_json['groups'][$chat_id]['managers']) || in_array($from_id,$sudo) || in_array($from_id,$sudo_json['sudo']['devs'])){
if(count ($groups_json['groups'][$chat_id]['expelleres']) !== 0){
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*تم مسح المطرودين بنجاح ✅* 

بواسطة : $tag",
'reply_to_message_id'=>$message_id,
]);
unset($groups_json['groups'][$chat_id]['expelleres']);
file_put_contents('groups_json.json',json_encode($groups_json,64|128|256));
return false;
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*لا يوجد مطرودين 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*هذا الأمر يخص المدير أو المنشى الاساسي فقط 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}
if($text == "المطرودين"){
if(is_admin($from_id,$chat_id)  || in_array($from_id,$groups_json['groups'][$chat_id]['managers']) || in_array($from_id,$sudo) || in_array($from_id,$sudo_json['sudo']['devs'])){
if(count ($groups_json['groups'][$chat_id]['expelleres']) !== 0){
foreach ($groups_json['groups'][$chat_id]['expelleres'] as $expeller){
$get_info = get_info($expeller,"member")['title'];
$mem .="[$get_info](tg://user?id=$expeller)\n";
}
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*المطرودين : *
$mem",
'reply_to_message_id'=>$message_id,
]);
return false;
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*لا يوجد مطرودين 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*هذا الأمر يخص المدير أو المنشى الاساسي فقط 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}
if(preg_match("/^حظر (.*)/",$text,$matches) && !is_admin(id($matches[1]),$chat_id) && !in_array(id($matches[1]),$groups_json['groups'][$chat_id]['managers']) && !in_array(id($matches[1]),$groups_json['groups'][$chat_id]['admins'])){
if(is_admin($from_id,$chat_id)  || in_array($from_id,$groups_json['groups'][$chat_id]['managers']) || in_array($from_id,$sudo) || in_array($from_id,$sudo_json['sudo']['devs'])){
if(!in_array(id($matches[1]),$groups_json['groups'][$chat_id]['baners'])){
$geinfo = get_info(id($matches[1]),"member")['title'];
$tg = "tg://user?id=".id($matches[1]);
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>" المستخدم : [$geinfo]($tg)

*تم حظره بنجاح ✅*

بواسطة : $tag",
'reply_to_message_id'=>$message_id,
]);
$groups_json['groups'][$chat_id]['baners'][] = id($matches[1]);
bot('KickChatMember',[
'chat_id'=>$chat_id,
'user_id'=>id($matches[1]),
]);
file_put_contents('groups_json.json',json_encode($groups_json,64|128|256));
return false;
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"* هذا العضو محظور مسبقاً 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"* هذا الأمر مخصص فقط للادمن 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}
if(isset($reply_id) && $text == "حظر" && !is_admin($reply_id,$chat_id) && !in_array($reply_id,$groups_json['groups'][$chat_id]['managers']) && !in_array($reply_id,$groups_json['groups'][$chat_id]['admins'])){
if(is_admin($from_id,$chat_id)  || in_array($from_id,$groups_json['groups'][$chat_id]['managers']) || in_array($from_id,$sudo) || in_array($from_id,$sudo_json['sudo']['devs'])){
if(!in_array($reply_id,$groups_json['groups'][$chat_id]['baners'])){
$tg = "tg://user?id=".$reply_id;
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>" المستخدم : $reply_tag

*تم حظره بنجاح ✅*

بواسطة : $tag",
'reply_to_message_id'=>$message_id,
]);
$groups_json['groups'][$chat_id]['baners'][] = $reply_id;
bot('KickChatMember',[
'chat_id'=>$chat_id,
'user_id'=>$reply_id,
]);
file_put_contents('groups_json.json',json_encode($groups_json,64|128|256));
return false;
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"* هذا العضو محظور مسبقاً 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"* هذا الأمر مخصص فقط للادمن 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}
if($text == "مسح المحظورين"){
if(is_admin($from_id,$chat_id)  || in_array($from_id,$groups_json['groups'][$chat_id]['managers']) || in_array($from_id,$sudo) || in_array($from_id,$sudo_json['sudo']['devs'])){
if(count ($groups_json['groups'][$chat_id]['baners']) !== 0){
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*تم مسح المحظورين بنجاح ✅* 

بواسطة : $tag",
'reply_to_message_id'=>$message_id,
]);
foreach($groups_json['groups'][$chat_id]['baners'] as $baner){
bot('UnbanChatmember',[
'chat_id'=>$chat_id,
'user_id'=>$baner,
]);
}
unset($groups_json['groups'][$chat_id]['baners']);
file_put_contents('groups_json.json',json_encode($groups_json,64|128|256));
return false;
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*لا يوجد محظورين 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*هذا الأمر يخص المدير أو المنشى الاساسي فقط 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}
if(preg_match("/^الغاء الحظر (.*)/",$text,$matches) && !is_admin(id($matches[1]),$chat_id) && !in_array(id($matches[1]),$groups_json['groups'][$chat_id]['managers']) && !in_array(id($matches[1]),$groups_json['groups'][$chat_id]['admins'])){
if(in_array(id($matches[1]),$groups_json['groups'][$chat_id]['baners'])){
if(is_admin($from_id,$chat_id)  || in_array($from_id,$groups_json['groups'][$chat_id]['managers']) || in_array($from_id,$sudo) || in_array($from_id,$sudo_json['sudo']['devs'])){
$geinfo = get_info(id($matches[1]),"member")['title'];
$tg = "tg://user?id=".id($matches[1]);
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>" المستخدم : [$geinfo]($tg)

*تم الغاء حظره بنجاح ✅*

بواسطة : $tag",
'reply_to_message_id'=>$message_id,
]);
unset($groups_json['groups'][$chat_id]['baners'][array_search(id($matches[1]),$groups_json['groups'][$chat_id]['baners'])]);
file_put_contents('groups_json.json',json_encode($groups_json,64|128|256));
return false;
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"* هذا الأمر مخصص فقط للادمن 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"* هذا العضو غير محظور مسبقاً 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}
if(isset($reply_id) && $text == "الغاء الحظر"){
if(is_admin($from_id,$chat_id)  || in_array($from_id,$groups_json['groups'][$chat_id]['managers']) || in_array($from_id,$sudo) || in_array($from_id,$sudo_json['sudo']['devs'])){
if(in_array($reply_id,$groups_json['groups'][$chat_id]['baners'])){
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>" المستخدم : $reply_tag

*تم الغاء حظره بنجاح ✅*

بواسطة : $tag",
'reply_to_message_id'=>$message_id,
]);
unset($groups_json['groups'][$chat_id]['baners'][array_search($reply_id,$groups_json['groups'][$chat_id]['baners'])]);
file_put_contents('groups_json.json',json_encode($groups_json,64|128|256));
return false;
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"* هذا العضو غير محظور مسبقاً 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"* هذا الأمر مخصص فقط للادمن 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}
if($text == "المحظورين"){
if(is_admin($from_id,$chat_id)  || in_array($from_id,$groups_json['groups'][$chat_id]['managers']) || in_array($from_id,$sudo) || in_array($from_id,$sudo_json['sudo']['devs'])){
if(count ($groups_json['groups'][$chat_id]['baners']) !== 0){
foreach ($groups_json['groups'][$chat_id]['baners'] as $baner){
$get_info = get_info($baner,"member")['title'];
$mem .="[$get_info](tg://user?id=$baner)\n";
}
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*المحظورين : *
$mem",
'reply_to_message_id'=>$message_id,
]);
return false;
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*لا يوجد محظورين 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*هذا الأمر يخص المدير أو المنشى الاساسي فقط 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}
if($text == "تاك"){
if(is_admin($from_id,$chat_id)  || in_array($from_id,$groups_json['groups'][$chat_id]['managers']) || in_array($from_id,$sudo) || in_array($from_id,$sudo_json['sudo']['devs'])){
$k = $num = 0;
$r = bot('sendmessage',['chat_id'=>$chat_id,'parse_mode'=>"MarkDown",'text'=>"*جاري عمل تاك ....*",'reply_to_message_id'=>$message_id,])->result->message_id;
foreach ($groups_json['groups'][$chat_id]['ids'] as $id){
$k++;
if($k == 100){
$k = 0;
$num += 1;
}
$geinfo = get_info($id,"member")['title'];
$tg = "tg://user?id=".$id;
if(isset($id) && ! empty ($id)){
$tagall[$num] .= "[$geinfo]($tg)" ."\n";
}
}
bot('deletemessage',[
'chat_id'=>$chat_id,
'message_id'=>$r,
]);
foreach ($tagall as $send){
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>$send,
'reply_to_message_id'=>$message_id,
]);
}
return false;
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*هذا الأمر يخص المدير أو المنشى الاساسي فقط 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}
if($text == "مسح الميديا"){
if(is_admin($from_id,$chat_id)  || in_array($from_id,$groups_json['groups'][$chat_id]['managers']) || in_array($from_id,$sudo) || in_array($from_id,$sudo_json['sudo']['devs'])){
$n = 0;
foreach($groups_json['groups'][$chat_id]['media'] as $med){
$n++;
bot('deletemessage',[
'chat_id'=>$chat_id,
'message_id'=>$med,
]);
unset($groups_json['groups'][$chat_id]['media'][array_search($med,$groups_json['groups'][$chat_id]['media'])]);
file_put_contents('groups_json.json',json_encode($groups_json,64|128|256));
if($n == 100 || count($groups_json['groups'][$chat_id]['media']) == 0){
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*تم مسح الميديا بنجاح ✅*

بواسطة : $tag",
'reply_to_message_id'=>$message_id,
]);
break;
}
}
return false;
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*هذا الأمر يخص المدير أو المنشى الاساسي فقط 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}

if(preg_match('/^قفل (.*)/',$text,$match) && in_array($match[1],$ar)){
$array = array_combine($ar,$en);
if(!$array[$match[1]]) return false;
if(is_admin($from_id,$chat_id) || in_array($from_id,$groups_json['groups'][$chat_id]['managers']) || in_array($from_id,$sudo) || in_array($from_id,$sudo_json['sudo']['devs'])){
if($groups_json['groups'][$chat_id]['setting'][$array[$match[1]]] == "yes"){
$txt = "*تم قفل $match[1] بنجاح ✅*";
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"$txt 

بواسطة : $tag",
'reply_to_message_id'=>$message_id,
]);
if($match[1] == "الكل"){
$groups_json['groups'][$chat_id]['setting']['photo'] = 
$groups_json['groups'][$chat_id]['setting']['video'] = 
$groups_json['groups'][$chat_id]['setting']['contect'] = 
$groups_json['groups'][$chat_id]['setting']['voice'] = 
$groups_json['groups'][$chat_id]['setting']['bots'] =
$groups_json['groups'][$chat_id]['setting']['audio'] = 
$groups_json['groups'][$chat_id]['setting']['channels'] = 
$groups_json['groups'][$chat_id]['setting']['animation']
= $groups_json['groups'][$chat_id]['setting']['chat'] = 
$groups_json['groups'][$chat_id]['setting']['notices'] = 
$groups_json['groups'][$chat_id]['setting']['all'] = 
$groups_json['groups'][$chat_id]['setting']['sticker'] = 
$groups_json['groups'][$chat_id]['setting']['link'] = 
$groups_json['groups'][$chat_id]['setting']['document'] = 
$groups_json['groups'][$chat_id]['setting']['inline'] = 
$groups_json['groups'][$chat_id]['setting']['edit'] = 
$groups_json['groups'][$chat_id]['setting']['mark'] = 
$groups_json['groups'][$chat_id]['setting']['users'] = 
$groups_json['groups'][$chat_id]['setting']['forward'] = 
$groups_json['groups'][$chat_id]['setting']['texts'] = 
"no";
}
$groups_json['groups'][$chat_id]['setting'][$array[$match[1]]] = "no";
file_put_contents('groups_json.json',json_encode($groups_json,64|128|256));
return false;
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*$match[1] مقفولة بالفعل 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"* هذا الأمر مخصص فقط للادمن 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}
if(preg_match('/^فتح (.*)/',$text,$match) && in_array($match[1],$ar)){
$array = array_combine($ar,$en);
if(!$array[$match[1]]) return false;
if(is_admin($from_id,$chat_id) || in_array($from_id,$groups_json['groups'][$chat_id]['managers']) || in_array($from_id,$sudo) || in_array($from_id,$sudo_json['sudo']['devs'])){
if($groups_json['groups'][$chat_id]['setting'][$array[$match[1]]] == "no"){
$txt = "*تم فتح $match[1] بنجاح ✅*";
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"$txt 

بواسطة : $tag",
'reply_to_message_id'=>$message_id,
]);
if($match[1] == "الكل"){
$groups_json['groups'][$chat_id]['setting']['photo'] = 
$groups_json['groups'][$chat_id]['setting']['video'] = 
$groups_json['groups'][$chat_id]['setting']['contect'] = 
$groups_json['groups'][$chat_id]['setting']['voice'] = 
$groups_json['groups'][$chat_id]['setting']['audio'] = 
$groups_json['groups'][$chat_id]['setting']['channels'] = 
$groups_json['groups'][$chat_id]['setting']['animation']
= $groups_json['groups'][$chat_id]['setting']['chat'] = 
$groups_json['groups'][$chat_id]['setting']['notices'] = 
$groups_json['groups'][$chat_id]['setting']['all'] = 
$groups_json['groups'][$chat_id]['setting']['bots'] =
$groups_json['groups'][$chat_id]['setting']['sticker'] = 
$groups_json['groups'][$chat_id]['setting']['link'] = 
$groups_json['groups'][$chat_id]['setting']['document'] = 
$groups_json['groups'][$chat_id]['setting']['inline'] = 
$groups_json['groups'][$chat_id]['setting']['edit'] = 
$groups_json['groups'][$chat_id]['setting']['mark'] = 
$groups_json['groups'][$chat_id]['setting']['users'] = 
$groups_json['groups'][$chat_id]['setting']['forward'] = 
$groups_json['groups'][$chat_id]['setting']['texts'] = 
"yes";
}
$groups_json['groups'][$chat_id]['setting'][$array[$match[1]]] = "yes";
file_put_contents('groups_json.json',json_encode($groups_json,64|128|256));
return false;
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*$match[1] مفتوحة بالفعل 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"* هذا الأمر مخصص فقط للادمن 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}

if($text == "اضف رد"){
if(is_admin($from_id,$chat_id)  || in_array($from_id,$groups_json['groups'][$chat_id]['managers']) || in_array($from_id,$sudo) || in_array($from_id,$sudo_json['sudo']['devs'])){
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"
عزيزي : $tag ⭐

*حسناً قم بإرسال كلمة الرد ✅*",
'reply_to_message_id'=>$message_id,
]);
$groups_json['chats'][$chat_id][$from_id]['ac'] = "send-text";
file_put_contents('groups_json.json',json_encode($groups_json,64|128|256));
return false;
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*هذا الأمر يخص المدير أو المنشى الاساسي فقط 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}
if($text && $groups_json['chats'][$chat_id][$from_id]['ac'] == "send-text"){
if(is_admin($from_id,$chat_id)  || in_array($from_id,$groups_json['groups'][$chat_id]['managers']) || in_array($from_id,$sudo) || in_array($from_id,$sudo_json['sudo']['devs'])){
unset($groups_json['chats'][$chat_id][$from_id]['ac']);
$groups_json['chats'][$chat_id][$from_id]['ac'] = "send-reply";
$groups_json['chats'][$chat_id][$from_id]['send-text'] = $text;
file_put_contents('groups_json.json',json_encode($groups_json,64|128|256));
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"
عزيزي : $tag ⭐

*حسناً قم بإرسال الرد ✅*",
'reply_to_message_id'=>$message_id,
]);
return false;
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*هذا الأمر يخص المدير أو المنشى الاساسي فقط 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}
if($text && $groups_json['chats'][$chat_id][$from_id]['ac'] == "send-reply"){
if(is_admin($from_id,$chat_id)  || in_array($from_id,$groups_json['groups'][$chat_id]['managers']) || in_array($from_id,$sudo) || in_array($from_id,$sudo_json['sudo']['devs'])){
$groups_json['replys'][$chat_id][$groups_json['chats'][$chat_id][$from_id]['send-text']] = $text;
unset($groups_json['chats'][$chat_id][$from_id]);
file_put_contents('groups_json.json',json_encode($groups_json,64|128|256));
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"
عزيزي : $tag ⭐

*تم الحفظ بنجاح ✅*",
'reply_to_message_id'=>$message_id,
]);
return false;
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*هذا الأمر يخص المدير أو المنشى الاساسي فقط 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}
if($text == "حذف رد"){
if(is_admin($from_id,$chat_id)  || in_array($from_id,$groups_json['groups'][$chat_id]['managers']) || in_array($from_id,$sudo) || in_array($from_id,$sudo_json['sudo']['devs'])){
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"
عزيزي : $tag ⭐

*حسناً قم بإرسال كلمة الرد لحذفها ✅*",
'reply_to_message_id'=>$message_id,
]);
$groups_json['chats'][$chat_id][$from_id]['ac'] = "del-text";
file_put_contents('groups_json.json',json_encode($groups_json,64|128|256));
return false;
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*هذا الأمر يخص المدير أو المنشى الاساسي فقط 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}
if($text && $groups_json['chats'][$chat_id][$from_id]['ac'] == "del-text"){
if(is_admin($from_id,$chat_id)  || in_array($from_id,$groups_json['groups'][$chat_id]['managers']) || in_array($from_id,$sudo) || in_array($from_id,$sudo_json['sudo']['devs'])){
unset($groups_json['chats'][$chat_id][$from_id]);
if(isset($groups_json['replys'][$chat_id][$text])){
unset($groups_json['replys'][$chat_id][$text]);
$txt = "*تم الحذف بنجاح ✅*";
}else{
$txt = "*لا يوجد هكذا رد 🇸🇦*";
}
file_put_contents('groups_json.json',json_encode($groups_json,64|128|256));
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"
عزيزي : $tag ⭐

$txt",
'reply_to_message_id'=>$message_id,
]);
return false;
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*هذا الأمر يخص المدير أو المنشى الاساسي فقط 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}
if($text == "رفع ادمن" && isset($reply_id)){
if(is_admin($from_id,$chat_id,"view") == "creator" || in_array($from_id,$groups_json['groups'][$chat_id]['managers']) || in_array($from_id,$sudo) || in_array($from_id,$sudo_json['sudo']['devs'])){
if(!is_admin($reply_id,$chat_id)){
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"المستخدم : $reply_tag

*تم رفعه ادمن بنجاح ✅*

بواسطة : $tag",
'reply_to_message_id'=>$message_id,
]);
$groups_json['groups'][$chat_id]['admins'][] = $reply_id;
file_put_contents('groups_json.json',json_encode($groups_json,64|128|256));
return 0;
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*تم رفع هذا العضو ادمن مسبقاً 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*هذا الأمر يخص المنشى الاساسي والمدير فقط 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}
if(preg_match("/^رفع ادمن (.*)/",$text,$matches)){
if(is_admin($from_id,$chat_id,"view") == "creator" || in_array($from_id,$groups_json['groups'][$chat_id]['managers']) || in_array($from_id,$sudo) || in_array($from_id,$sudo_json['sudo']['devs'])){
if(!is_admin(id($matches[1]),$chat_id)){
$geinfo = get_info(id($matches[1]),"member")['title'];
$tg = "tg://user?id=".id($matches[1]);
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"المستخدم : [$geinfo]($tg)

*تم رفعه ادمن بنجاح ✅*

بواسطة : $tag",
'reply_to_message_id'=>$message_id,
]);
$groups_json['groups'][$chat_id]['admins'][] = id($matches[1]);
file_put_contents('groups_json.json',json_encode($groups_json,64|128|256));
return 0;
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*تم رفع هذا العضو ادمن مسبقاً 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*هذا الأمر يخص المنشى الاساسي والمدير فقط 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}
if($text == "تنزيل ادمن" && isset($reply_id)){
if(is_admin($from_id,$chat_id,"view") == "creator" || in_array($from_id,$groups_json['groups'][$chat_id]['managers']) || in_array($from_id,$sudo) || in_array($from_id,$sudo_json['sudo']['devs'])){
if(is_admin($reply_id,$chat_id)){
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"المستخدم : $reply_tag

*تم تنزيله من الادمن بنجاح ✅*

بواسطة : $tag",
'reply_to_message_id'=>$message_id,
]);
unset($groups_json['groups'][$chat_id]['admins'][array_search($reply_id,$groups_json['groups'][$chat_id]['admins'])]);
file_put_contents('groups_json.json',json_encode($groups_json,64|128|256));
return 0;
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*هذا العضو ليس ادمن مسبقاً 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*هذا الأمر يخص المنشى الاساسي والمدير فقط 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}
if(preg_match("/^تعيين التكرار (.*)$/",$text)){
preg_match("/^تعيين التكرار (.*)$/",$text,$m);
$nt = $m[1];
if(is_admin($from_id,$chat_id) || in_array($from_id,$groups_json['groups'][$chat_id]['managers']) || in_array($from_id,$sudo) || in_array($from_id,$sudo_json['sudo']['devs'])){
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*تم تعيين عدد مرات التكرار $nt بنجاح ✅*

بواسطة : $tag",
"reply_to_message_id"=>$message_id,
]);
$groups_json["groups"][$chat_id]["acs"]["spam"] = $nt;
file_put_contents("groups_json.json",json_encode($groups_json,64|128|256));
return false;
}else{
bot("sendmessage",[
"chat_id"=>$chat_id,
"parse_mode"=>"MarkDown",
"text"=>"* هذا الأمر مخصص فقط للادمن 🇸🇦*",
"reply_to_message_id"=>$message_id,
]);
return false;
}}
if(preg_match("/^تنزيل ادمن (.*)/",$text,$matches)){
if(is_admin($from_id,$chat_id,"view") == "creator" || in_array($from_id,$groups_json['groups'][$chat_id]['managers']) || in_array($from_id,$sudo) || in_array($from_id,$sudo_json['sudo']['devs'])){
if(is_admin(id($matches[1]),$chat_id)){
$geinfo = get_info(id($matches[1]),"member")['title'];
$tg = "tg://user?id=".id($matches[1]);
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"المستخدم : [$geinfo]($tg)

*تم تنزيله من الادمن بنجاح ✅*

بواسطة : $tag",
'reply_to_message_id'=>$message_id,
]);
unset($groups_json['groups'][$chat_id]['admins'][array_search(id($matches[1]),$groups_json['groups'][$chat_id]['admins'])]);
file_put_contents('groups_json.json',json_encode($groups_json,64|128|256));
return 0;
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*هذا العضو ليس ادمن مسبقاً 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*هذا الأمر يخص المنشى الاساسي والمدير فقط 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}
if($text && isset($groups_json['replys'][$chat_id][$text])){
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>$groups_json['replys'][$chat_id][$text],
'reply_to_message_id'=>$message_id,
]);
}
if(preg_match("/قفل التكرار (.*)/",$text)){
preg_match("/قفل التكرار (.*)/",$text,$m);
if(is_admin($from_id,$chat_id) || in_array($from_id,$groups_json['groups'][$chat_id]['managers']) || in_array($from_id,$sudo) || in_array($from_id,$sudo_json['sudo']['devs'])){
if(in_array($m[1],$array_ban)){
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"
*تم $text بنجاح ✅*

بواسطة : $tag",
"reply_to_message_id"=>$message_id,
]);
unset($groups_json["spam"][$d][$m][$chat_id]);
$groups_json["groups"][$chat_id]["acs"]["typespam"] = $m[1];
file_put_contents("groups_json.json",json_encode($groups_json,64|128|256));
return false;
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"لم يتم العثور على العقوبة *$m[1]* 

تجنب الأخطاء الإملائية ..",
"reply_to_message_id"=>$message_id,
]);
return false;
}
}else{
bot("sendmessage",[
"chat_id"=>$chat_id,
"parse_mode"=>"MarkDown",
"text"=>"* هذا الأمر مخصص فقط للادمن 🇸🇦*",
"reply_to_message_id"=>$message_id,
]);
return false;
}}
if($text == "فتح التكرار"){
if(is_admin($from_id,$chat_id) || in_array($from_id,$groups_json['groups'][$chat_id]['managers']) || in_array($from_id,$sudo) || in_array($from_id,$sudo_json['sudo']['devs'])){
if($groups_json["groups"][$chat_id]["acs"]["typespam"] !== "no"){
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"
*تم فتح التكرار بنجاح ✅*

بواسطة : $tag",
"reply_to_message_id"=>$message_id,
]);
unset($groups_json["spam"][$d][$m][$chat_id]);
$groups_json["groups"][$chat_id]["acs"]["typespam"] = "no";
file_put_contents("groups_json.json",json_encode($groups_json,64|128|256));
return false;
}else{
bot("sendmessage",[
"chat_id"=>$chat_id,
"parse_mode"=>"MarkDown",
"text"=>"*التكرار مفتوح بالفعل 🇸🇦*",
"reply_to_message_id"=>$message_id,
]);
return false;
}}else{
bot("sendmessage",[
"chat_id"=>$chat_id,
"parse_mode"=>"MarkDown",
"text"=>"* هذا الأمر مخصص فقط للادمن 🇸🇦*",
"reply_to_message_id"=>$message_id,
]);
return false;
}}
if($groups_json["spam"][$d][$m][$chat_id][$from_id] >= $groups_json["groups"][$chat_id]["acs"]["spam"]){
if(!is_admin($from_id,$chat_id) && !in_array($from_id,$groups_json['groups'][$chat_id]['managers']) && !in_array($from_id,$groups_json['groups'][$chat_id]['features']) || in_array($from_id,$sudo)){
if(preg_match("/تقييد/",$groups_json["groups"][$chat_id]["acs"]["typespam"])){
bot('restrictChatMember',[
'chat_id'=>$chat_id,
'user_id'=>$from_id,   
'can_post_messages'=>false,
]);
unset($groups_json["spam"][$d][$m][$chat_id][$from_id]);
$groups_json['groups'][$chat_id]['enrollers'][] = $from_id;
file_put_contents('groups_json.json',json_encode($groups_json,64|128|256));
}
if(preg_match("/حذف/",$groups_json["groups"][$chat_id]["acs"]["typespam"])){
bot('deleteMessage',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
]);
}
if(preg_match("/كتم/",$groups_json["groups"][$chat_id]["acs"]["typespam"])){
$groups_json['groups'][$chat_id]['silencers'][] = $from_id;
unset($groups_json["spam"][$d][$m][$chat_id][$from_id]);
file_put_contents('groups_json.json',json_encode($groups_json,64|128|256));
}
if(preg_match("/طرد/",$groups_json["groups"][$chat_id]["acs"]["typespam"])){
bot('KickChatMember',[
'chat_id'=>$chat_id,
'user_id'=>$from_id,
]);
bot('UnbanChatmember',[
'chat_id'=>$chat_id,
'user_id'=>$from_id,
]);
unset($groups_json["spam"][$d][$m][$chat_id][$from_id]);
file_put_contents('groups_json.json',json_encode($groups_json,64|128|256));
}
if(preg_match("/حظر/",$groups_json["groups"][$chat_id]["acs"]["typespam"])){
bot('KickChatMember',[
'chat_id'=>$chat_id,
'user_id'=>$from_id,
]);
unset($groups_json["spam"][$d][$m][$chat_id][$from_id]);
file_put_contents('groups_json.json',json_encode($groups_json,64|128|256));
}
}}
if($text == "رفع مميز" && isset($reply_id)){
if(is_admin($from_id,$chat_id) || in_array($from_id,$groups_json['groups'][$chat_id]['managers']) || in_array($from_id,$sudo) || in_array($from_id,$sudo_json['sudo']['devs'])){
if(!in_array($reply_id,$groups_json['groups'][$chat_id]['features'])){
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"المستخدم : $reply_tag

*تم رفعه مميز بنجاح ✅*

بواسطة : $tag",
'reply_to_message_id'=>$message_id,
]);
$groups_json['groups'][$chat_id]['features'][] = $reply_id;
file_put_contents('groups_json.json',json_encode($groups_json,64|128|256));
return false;
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*تم رفع هذا العضو مميز مسبقاً 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*هذا الأمر يخص الادامن فقط 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}
if(preg_match("/^رفع مميز (.*)/",$text,$matches)){
if(is_admin($from_id,$chat_id) || in_array($from_id,$groups_json['groups'][$chat_id]['managers']) || in_array($from_id,$sudo) || in_array($from_id,$sudo_json['sudo']['devs'])){
if(!in_array(id($matches[1]),$groups_json['groups'][$chat_id]['features'])){
$geinfo = get_info(id($matches[1]),"member")['title'];
$tg = "tg://user?id=".id($matches[1]);
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"المستخدم : [$geinfo]($tg)

*تم رفعه مميز بنجاح ✅*

بواسطة : $tag",
'reply_to_message_id'=>$message_id,
]);
$groups_json['groups'][$chat_id]['features'][] = id($matches[1]);
file_put_contents('groups_json.json',json_encode($groups_json,64|128|256));
return false;
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*تم رفع هذا العضو مميز مسبقاً 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*هذا الأمر يخص الادامن فقط 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}
if($text == "تنزيل مميز" && isset($reply_id)){
if(is_admin($from_id,$chat_id) || in_array($from_id,$groups_json['groups'][$chat_id]['managers']) || in_array($from_id,$sudo) || in_array($from_id,$sudo_json['sudo']['devs'])){
if(in_array($reply_id,$groups_json['groups'][$chat_id]['features'])){
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"المستخدم : $reply_tag

*تم تنزيله من المميز بنجاح ✅*

بواسطة : $tag",
'reply_to_message_id'=>$message_id,
]);
unset($groups_json['groups'][$chat_id]['features'][array_search($reply_id,$groups_json['groups'][$chat_id]['features'])]);
file_put_contents('groups_json.json',json_encode($groups_json,64|128|256));
return false;
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*هذا العضو ليس مميز مسبقاً 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*هذا الأمر يخص الادامن فقط 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}
if($text == "الاوامر" or $text == "م"){
if(is_admin($from_id,$chat_id) || in_array($from_id,$groups_json['groups'][$chat_id]['managers']) || in_array($from_id,$sudo) || in_array($from_id,$sudo_json['sudo']['devs'])){
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"
اهلا بك : $tag
 
*في قائمة الاوامر الاساسية ✅*
•--------------» $channel «--------------•
م1 •⊱ *لعرض اوامر البحث*
م2 •⊱ *لعرض اوامر القفل والفتح*
م3 •⊱ *لعرض اوامر الرفع والتنزيل*
م4 •⊱ *لعرض اوامر الحماية*
م5 •⊱ *لشرح الأوامر ارسل التعليمات أو شرح*

*● ملاحظة: البوت يقوم بحظر اي بوت تتم اضافته اذا اردت اضافة بوت قم باضافته من خانة المشرفين*
•--------------» $channel «--------------•",
'reply_to_message_id'=>$message_id,
'disable_web_page_preview'=>true,
]);
return false;
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*هذا الأمر يخص الادامن فقط 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}
if($text == "م1"){
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"
اهلا بك : $tag
 
*في قائمة اوامر البحث ✅*
*
🇸🇦 ¦ سورة اسم السورة ~ لارسال السورة على شكل ملف mp3
🇸🇦 ¦ اية: ما تذكره من اية ~ للبحث عن آية
🇸🇦 ¦ للبحث الشامل في القرأن ارسل كلمة بحث
🇸🇦 ¦ للبحث في التفاسير ارسل
🇸🇦 ¦ الميسر
🇸🇦 ¦ الجلالين
🇸🇦 ¦ صفحة رقم الصفحة ~ لإرسال صورة الصفحة في القرآن الكريم
🇸🇦 ¦ حديث: ما تذكره من الحديث ~ للبحث عن الحديث
🇸🇦 ¦ أحاديث: وما تذكره من الحديث للبحث في مجموعة الأحاديث
🇸🇦 ¦ وللبحث عن حديث برقم الحديث في الكتب التالية 
🇸🇦 ¦ صحيح البخاري
🇸🇦 ¦ صحيح مسلم
🇸🇦 ¦ مسند أحمد
🇸🇦 ¦ موطأ مالك
🇸🇦 ¦ سنن الترمذي
🇸🇦 ¦ سنن أبو داود
🇸🇦 ¦ سنن الدارمي
🇸🇦 ¦ سنن ابن ماجه
🇸🇦 ¦ سنن النسائي
🇸🇦 ¦الطريقة ك التالي 
🇸🇦 ¦اسم الكتاب + الرقم
🇸🇦 ¦مثال : 
🇸🇦 ¦ صحيح البخاري 100
🇸🇦 ¦ مسند أحمد 100
🇸🇦 ¦ موطأ مالك 100
🇸🇦 ¦ سنن الدارمي 100
🇸🇦 ¦ مقاطع قصيرة ~ لإرسال مقطع قصير
*

",
'reply_to_message_id'=>$message_id,
'disable_web_page_preview'=>true,
]);
return 0;
}
if($text == "فتح الايدي بالصورة"){
if(is_admin($from_id,$chat_id) || in_array($from_id,$groups_json['groups'][$chat_id]['managers']) || in_array($from_id,$sudo) || in_array($from_id,$sudo_json['sudo']['devs'])){
if($groups_json["groups"][$chat_id]["acs"]["idphoto"] !== "yes"){
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"
*تم فتح الايدي بالصورة بنجاح ✅*

بواسطة : $tag",
"reply_to_message_id"=>$message_id,
]);
$groups_json["groups"][$chat_id]["acs"]["idphoto"] = "yes";
file_put_contents("groups_json.json",json_encode($groups_json,64|128|256));
return false;
}else{
bot("sendmessage",[
"chat_id"=>$chat_id,
"parse_mode"=>"MarkDown",
"text"=>"* الايدي بالصورة مفتوح بالفعل🇸🇦*",
"reply_to_message_id"=>$message_id,
]);
return false;
}}else{
bot("sendmessage",[
"chat_id"=>$chat_id,
"parse_mode"=>"MarkDown",
"text"=>"* هذا الأمر مخصص فقط للادمن 🇸🇦*",
"reply_to_message_id"=>$message_id,
]);
return false;
}}
if($text == "قفل الايدي بالصورة"){
if(is_admin($from_id,$chat_id) || in_array($from_id,$groups_json['groups'][$chat_id]['managers']) || in_array($from_id,$sudo) || in_array($from_id,$sudo_json['sudo']['devs'])){
if($groups_json["groups"][$chat_id]["acs"]["idphoto"] !== "no"){
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"
*تم قفل الايدي بالصورة بنجاح ✅*

بواسطة : $tag",
"reply_to_message_id"=>$message_id,
]);
$groups_json["groups"][$chat_id]["acs"]["idphoto"] = "no";
file_put_contents("groups_json.json",json_encode($groups_json,64|128|256));
return false;
}else{
bot("sendmessage",[
"chat_id"=>$chat_id,
"parse_mode"=>"MarkDown",
"text"=>"* الايدي بالصورة مقفول بالفعل🇸🇦*",
"reply_to_message_id"=>$message_id,
]);
return false;
}}else{
bot("sendmessage",[
"chat_id"=>$chat_id,
"parse_mode"=>"MarkDown",
"text"=>"* هذا الأمر مخصص فقط للادمن 🇸🇦*",
"reply_to_message_id"=>$message_id,
]);
return false;
}}

if($text == "الاعدادات"){
if(is_admin($from_id,$chat_id) || in_array($from_id,$groups_json['groups'][$chat_id]['managers']) || in_array($from_id,$sudo) || in_array($from_id,$sudo_json['sudo']['devs'])){
$arr = array_combine($en,$ar);
$ok['yes'] = '✔';
$ok['no'] = '✖';
foreach ($groups_json['groups'][$chat_id]['setting'] as $k => $v){
$res .= "*".$arr[$k]."* : ".$ok[$v]."\n";
}
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"
اهلا بك : $tag

 ✔ :: تعني مسموح 
✖ :: تعني غير مسموح 

•--------------» $channel «--------------•
$res •--------------» $channel «--------------•",
'reply_to_message_id'=>$message_id,
'disable_web_page_preview'=>true,
]);
return false;
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*هذا الأمر يخص الادامن فقط 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}
if($text == "المميزين"){
if(is_admin($from_id,$chat_id)  || in_array($from_id,$groups_json['groups'][$chat_id]['managers']) || in_array($from_id,$sudo) || in_array($from_id,$sudo_json['sudo']['devs'])){
if(count ($groups_json['groups'][$chat_id]['features']) !== 0){
foreach ($groups_json['groups'][$chat_id]['features'] as $feature){
$get_info = get_info($feature,"member")['title'];
$mem .="[$get_info](tg://user?id=$feature)\n";
}
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*المميزين : *
$mem",
'reply_to_message_id'=>$message_id,
]);
return false;
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*لا يوجد مميزين 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*هذا الأمر لا يخصك 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}
if($text == "مسح المميزين"){
if(is_admin($from_id,$chat_id) || in_array($from_id,$groups_json['groups'][$chat_id]['managers']) || in_array($from_id,$sudo) || in_array($from_id,$sudo_json['sudo']['devs'])){
if(count ($groups_json['groups'][$chat_id]['features']) !== 0){
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*تم مسح المميزين بنجاح ✅* 

بواسطة : $tag",
'reply_to_message_id'=>$message_id,
]);
unset($groups_json['groups'][$chat_id]['features']);
file_put_contents('groups_json.json',json_encode($groups_json,64|128|256));
return false;
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*لا يوجد مميزين 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*هذا الأمر لا يخصك 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}
if($text == "المدراء"){
if(is_admin($from_id,$chat_id)  || in_array($from_id,$groups_json['groups'][$chat_id]['managers']) || in_array($from_id,$sudo) || in_array($from_id,$sudo_json['sudo']['devs'])){
if(count ($groups_json['groups'][$chat_id]['managers']) !== 0){
foreach ($groups_json['groups'][$chat_id]['managers'] as $manager){
$get_info = get_info($manager,"member")['title'];
$mem .="[$get_info](tg://user?id=$manager)\n";
}
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*المدراء : *
$mem",
'reply_to_message_id'=>$message_id,
]);
return false;
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*لا يوجد مدراء 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*هذا الأمر لا يخصك 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}
if($text == "مسح المدراء"){
if(is_admin($from_id,$chat_id,"view") == "creator" || in_array($from_id,$sudo) || in_array($from_id,$sudo_json['sudo']['devs'])){
if(count ($groups_json['groups'][$chat_id]['managers']) !== 0){
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*تم مسح المدراء بنجاح ✅* 

بواسطة : $tag",
'reply_to_message_id'=>$message_id,
]);
unset($groups_json['groups'][$chat_id]['managers']);
file_put_contents('groups_json.json',json_encode($groups_json,64|128|256));
return false;
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*لا يوجد مدراء 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*هذا الأمر لا يخصك 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}
if($text == "الادامن" || $text == "الادمنيه" || $text == "@admin"){
if(is_admin($from_id,$chat_id)  || in_array($from_id,$groups_json['groups'][$chat_id]['managers']) || in_array($from_id,$sudo) || in_array($from_id,$sudo_json['sudo']['devs'])){
if(count ($groups_json['groups'][$chat_id]['admins']) !== 0){
foreach ($groups_json['groups'][$chat_id]['admins'] as $ad){
$get_info = get_info($ad,"member")['title'];
$mem .="[$get_info](tg://user?id=$ad)\n";
}
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*الادامن : *
$mem",
'reply_to_message_id'=>$message_id,
]);
return false;
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*لا يوجد ادامن 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*هذا الأمر لا يخصك 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}
if($text == "مسح الادامن"){
if(is_admin($from_id,$chat_id,"view") == "creator" || in_array($from_id,$groups_json['groups'][$chat_id]['managers']) || in_array($from_id,$sudo) || in_array($from_id,$sudo_json['sudo']['devs'])){
if(count ($groups_json['groups'][$chat_id]['admins']) !== 0){
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*تم مسح الادمنيه بنجاح ✅* 

بواسطة : $tag",
'reply_to_message_id'=>$message_id,
]);
unset($groups_json['groups'][$chat_id]['admins']);
file_put_contents('groups_json.json',json_encode($groups_json,64|128|256));
return false;
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*لا يوجد ادامن 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*هذا الأمر لا يخصك 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}
if($text == "م2"){
if(is_admin($from_id,$chat_id) || in_array($from_id,$groups_json['groups'][$chat_id]['managers']) || in_array($from_id,$sudo) || in_array($from_id,$sudo_json['sudo']['devs'])){
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"
اهلا بك : $tag
 
*في قائمة القفل والفتح ✅*
•--------------» $channel «--------------•
🇸🇦¦ قفل ~ فتح •⊱ *الكل* 
🇸🇦¦ قفل ~ فتح •⊱ *الدردشة* 
🇸🇦¦ قفل ~ فتح •⊱ *الصوتيات* 
🇸🇦¦ قفل ~ فتح •⊱ *الفيديوهات* 
🇸🇦¦ قفل ~ فتح •⊱ *الصور* 
🇸🇦¦ قفل ~ فتح •⊱ *الملصقات* 
🇸🇦¦ قفل ~ فتح •⊱ *المتحركات* 
🇸🇦¦ قفل ~ فتح •⊱ *الملفات* 
🇸🇦¦ قفل ~ فتح •⊱ *الروابط* 
🇸🇦¦ قفل ~ فتح •⊱ *القنوات* 
🇸🇦¦ قفل ~ فتح •⊱ *المارك* 
🇸🇦¦ قفل ~ فتح •⊱ *المعرفات* 
🇸🇦¦ قفل ~ فتح •⊱ *التعديل* 
🇸🇦¦ قفل ~ فتح •⊱ *الانلاين* 
🇸🇦¦ قفل ~ فتح •⊱ *التوجيه* 
🇸🇦¦ قفل ~ فتح •⊱ *المنشورات* 
🇸🇦¦ قفل ~ فتح •⊱ *الاشعارات* 
•--------------» $channel «--------------•",
'reply_to_message_id'=>$message_id,
'disable_web_page_preview'=>true,
]);
return false;
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*هذا الأمر يخص الادامن فقط 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}
if($text == "م3"){
if(is_admin($from_id,$chat_id) || in_array($from_id,$groups_json['groups'][$chat_id]['managers']) || in_array($from_id,$sudo) || in_array($from_id,$sudo_json['sudo']['devs'])){
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"
اهلا بك : $tag
 
*إليك قائمة الرتب*
•--------------» $channel «--------------•
الرفع والتنزيل يكون بالرد
🇸🇦¦ رفع ~ تنزيل •⊱ *مدير* 
🇸🇦¦ رفع ~ تنزيل •⊱ *ادمن* 
🇸🇦¦ رفع ~ تنزيل •⊱ *مميز* 
•--------------» $channel «--------------•",
'reply_to_message_id'=>$message_id,
'disable_web_page_preview'=>true,
]);
return false;
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*هذا الأمر يخص الادامن فقط 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}
if($text == "م4"){
if(is_admin($from_id,$chat_id) || in_array($from_id,$groups_json['groups'][$chat_id]['managers']) || in_array($from_id,$sudo) || in_array($from_id,$sudo_json['sudo']['devs'])){
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"
اهلا بك : $tag
 
*في قائمة الحماية ✅*
•--------------» $channel «--------------•
🇸🇦¦ `تقييد` ~ الغاء التقييد 
🇸🇦¦ `كتم` ~ `الغاء الكتم` 
🇸🇦¦ `حظر` ~ `الغاء الحظر` 
🇸🇦¦ `طرد` ~ *لا يوجد الغاء طرد* 
•--------------» $channel «--------------•
🇸🇦¦ `المقيدين` •⊱ *لعرض المقيدين *
🇸🇦¦ `المكتومين` •⊱ *لعرض المكتومين *
🇸🇦¦ `المطرودين` •⊱ *لعرض المطردوين *
🇸🇦¦ `المحظورين` •⊱ *لعرض المطردوين *
•--------------» $channel «--------------•
🇸🇦¦ `مسح المقيدين` •⊱ *لمسح المقيدين *
🇸🇦¦ `مسح المطرودين` •⊱ *لمسح المطرودين *
🇸🇦¦ `مسح المكتومين` •⊱ *لمسح المطردوين *
🇸🇦¦ `مسح المحظورين` •⊱ *لمسح المطردوين *

•--------------» $channel «--------------•
🇸🇦¦ `تاك` ~ *لعمل تاك للاعضاء المتفاعلين *
🇸🇦¦ `مسح الميديا` ~ *لمسح الميديا في الكروب *
•--------------» $channel «--------------•
*● ملاحظة ::* __يمكنك التقييد لمدة معينة وذلك بإضافة المدة بعد كلمة تقييد__ ،  مثال 👇🏼
`تقييد 5د`
س5
ي5
د تعني دقيقة - س تعني ساعة - ي تعني يوم
•--------------» $channel «--------------•",
'reply_to_message_id'=>$message_id,
'disable_web_page_preview'=>true,
]);
return false;
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*هذا الأمر يخص الادامن فقط 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}
if(preg_match('/^كتاب: (.*)/',$text)){
preg_match('/^كتاب: (.*)/',$text,$matches);
$search = $matches[1];
$books = json_decode(file_get_contents('https://developer-syrian.ml/tests/st.php?s='.urlencode($search)),1);
foreach (array_keys($books) as $book){
preg_match('/https:\/\/t.me\/Jame3_kotob\/(.*)/',$books[$book],$o);
$new = preg_replace('/([Aa-zZ])/','',preg_replace('/\d/','',str_replace('_',' ',preg_replace('/\.(.*)/','',$book))));
$n = $n+1;
$replyy['inline_keyboard'][] = [['text'=>str_ireplace(["z","f"],null,$new),'callback_data'=>"id-".$o[1]]];
if($n == 15) break;
}
$ok = bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"هذه نتائج البحث على : ".$matches[1],
'reply_markup'=>json_encode($replyy,64|128|256),
'reply_to_message_id'=>$message_id,
]);
}
if(preg_match('/^سورة: (.*)$/',$text,$match)){
$words  = array("الفاتحة","البقرة","آل عمران","النساء","المائدة","الأنعام","الأعراف","الأنفال","التوبة","يونس","هود","يوسف","الرعد","ابراهيم","الحجر","النحل","الإسراء","الكهف","مريم","طه","الأنبياء","الحج","المؤمنون","النور","الفرقان","الشعراء","النمل","القصص","العنكبوت","الروم","لقمان","السجدة","الأحزاب","سبإ","فاطر","يس","الصافات","ص","الزمر","غافر","فصلت","الشورى","الزخرف","الدخان","الجاثية","الأحقاف","محمد","الفتح","الحجرات","ق","الذاريات","الطور","النجم","القمر","الرحمن","الواقعة","الحديد","المجادلة","الحشر","الممتحنة","الصف","الجمعة","المنافقون","التغابن","الطلاق","التحريم","الملك","القلم","الحاقة","المعارج","نوح","الجن","المزمل","المدثر","القيامة","الانسان","المرسلات","النبإ","النازعات","عبس","التكوير","الإنفطار","المطففين","الإنشقاق","البروج","الطارق","الأعلى","الغاشية","الفجر","البلد","الشمس","الليل","الضحى","الشرح","التين","العلق","القدر","البينة","الزلزلة","العاديات","القارعة","التكاثر","العصر","الهمزة","الفيل","قريش","الماعون","الكوثر","الكافرون","النصر","المسد","الإخلاص","الفلق","الناس");
$input = $match[1];
$shortest = -1;
foreach ($words as $word) {
    $lev = levenshtein($input, $word);
    if ($lev == 0) {
        $closest = $word;
        $shortest = 0;
        break;
    }
    if ($lev < $shortest || $shortest < 0) {
        $closest  = $word;
        $shortest = $lev;
    }
}
if(!in_array($input,$words)){
if ($shortest == 0) {
$s = "";
$txt = "حدث خطأ!! 
حاول إرسال الكلمة من دون أخطاء املائية ..";
} else {
$s = $closest;
$main = "ok";
}
}else{
$s = $input;
}
$e=array_search($s,$words)+2;
$link = "https://t.me/mshriiafs/".$e;
$tt = isset($s) ? "سورة $s" : $txt;
bot('sendaudio',[
'chat_id'=>$chat_id,
'audio'=>$link,
'caption'=>$tt,
'reply_to_message_id'=>$message_id,
]);
}
if(preg_match('/^حديث: (.*)/',$text,$match)){
$json = json_decode(file_get_contents("https://dorar.net/dorar_api.json?skey=".urlencode($match[1])));
$e = explode('--------------',$json->ahadith->result);
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>str_ireplace("\n    ","\n",trim(strip_tags($e[0]))),
'reply_to_message_id'=>$message_id,
]);
}
function page_quran($count){
 if(10 > $count){
$a = "http://www.aliman-group.com/quran/big_gif/00$count.gif";
}elseif(10 <= $count && 100 > $count){
$a = "http://www.aliman-group.com/quran/big_gif/0$count.gif";
}elseif(100 <= $count){
$a = "http://www.aliman-group.com/quran/big_gif/$count.gif";
}
if($count > 604){
return false;}
return $a;
}
function pagee($count){
 if(10 > $count){
$a = "00$count";
}elseif(10 <= $count && 100 > $count){
$a = "0$count";
}elseif(100 <= $count){
$a = "$count";
}
if($count > 604){
return false;}
return $a;
}
if(preg_match("/صفحة: ([\d]*)/",$text,$count)){
bot('SendPhoto',[
'chat_id'=>$chat_id,
'photo'=>page_quran($count[1]),
'parse_mode'=>"MarkDown",
'caption'=>"صفحة رقم *$count[1]* من القرآن الكريم 🌿",
'reply_to_message_id'=>$message_id,
]);
$pagee = pagee($count[1]);
file_put_contents('../mediaa/'.$pagee.".mp3",file_get_contents("https://ia802309.us.archive.org/32/items/mshary-al3afasy-by-qasr-almonfasel-604-page-quran-mp3-128kb_21/".$pagee.".mp3"));
bot('sendaudio',[
'chat_id'=>$chat_id,
'audio'=>new CURLFILE ('../mediaa/'.$pagee.".mp3"),
'performer'=>"القارئ مشاري عفاسي",
'title'=>"الصفحة : ".$pagee,
'parse_mode'=>"MarkDown",
'caption'=>"صفحة رقم *$count[1]* من القرآن الكريم 🌿",
'reply_to_message_id'=>$message_id,
]);
}
if($text == "مقاطع قصيرة"){
$rand_id = rand(2,100);
$video = "https://t.me/Telawat_Qurani/".$rand_id;
bot('sendvideo',[
'chat_id'=>$chat_id,
'video'=>$video, 
'reply_to_message_id'=>$message->message_id,
]);
} 
if(preg_match('/^اية: (.*)/',$text,$match)){
$get = json_decode(file_get_contents('https://api-quran.cf/quransql/index.php?text='.$match[1]), true);
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>$get['result'][0]."
لنتائج أكثر : @SearcherQuranBot",
'reply_to_message_id'=>$message_id,
]);
}




if(preg_match('/صحيح (.*) (.*)/',$text,$j)){
$ke = str_replace(["مسلم","البخاري","أحمد","مالك","الترمذي","الدارمي"],["muslim","bukhari","ahmed","malik","trmizi","darimi"],$j[1]);
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>json_decode(file_get_contents("https://raw.githubusercontent.com/Mohamed-Nagdy/Quran-App-Data/main/Hadith%20Books%20Json/$ke.json"),1)[$j[2]-1][hadith],
'reply_to_message_id'=>$message_id,
]);
}

if(preg_match('/سنن (.*) (.*)/',$text,$j)){
$ke = str_replace(["أبو داود","الترمذي","الدارمي","النسائي","ابن ماجه"],["abi_daud","trmizi","darimi","nasai","ibn_maja"],$j[1]);
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>json_decode(file_get_contents("https://raw.githubusercontent.com/Mohamed-Nagdy/Quran-App-Data/main/Hadith%20Books%20Json/$ke.json"),1)[$j[2]-1][hadith],
'reply_to_message_id'=>$message_id,
]);
}

if(preg_match('/مسند (.*) (.*)/',$text,$j)){
$ke = str_replace(["أحمد"],["ahmed"],$j[1]);
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>json_decode(file_get_contents("https://raw.githubusercontent.com/Mohamed-Nagdy/Quran-App-Data/main/Hadith%20Books%20Json/$ke.json"),1)[$j[2]-1][hadith],
'reply_to_message_id'=>$message_id,
]);
}

if(preg_match('/موطأ (.*) (.*)/',$text,$j)){
$ke = str_replace(["مالك"],["malik"],$j[1]);
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>json_decode(file_get_contents("https://raw.githubusercontent.com/Mohamed-Nagdy/Quran-App-Data/main/Hadith%20Books%20Json/$ke.json"),1)[$j[2]-1][hadith],
'reply_to_message_id'=>$message_id,
]);
}


if(preg_match("/^تنزيل مميز (.*)/",$text,$matches)){
if(is_admin($from_id,$chat_id) || in_array($reply_id,$groups_json['groups'][$chat_id]['managers'])){
if(in_array(id($matches[1]),$groups_json['groups'][$chat_id]['features'])){
$geinfo = get_info(id($matches[1]),"member")['title'];
$tg = "tg://user?id=".id($matches[1]);
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"المستخدم : [$geinfo]($tg)

*تم تنزيله من المميز بنجاح ✅*

بواسطة : $tag",
'reply_to_message_id'=>$message_id,
]);
unset($groups_json['groups'][$chat_id]['features'][array_search(id($matches[1]),$groups_json['groups'][$chat_id]['features'])]);
file_put_contents('groups_json.json',json_encode($groups_json,64|128|256));
return false;
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*هذا العضو ليس مميز مسبقاً 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"*هذا الأمر يخص الادامن فقط 🇸🇦*",
'reply_to_message_id'=>$message_id,
]);
return false;
}}
if($text == "ايدي"){
if(is_admin($from_id,$chat_id,"view") == "creator"){
$r .= "مالك ";
}
if(is_admin($from_id,$chat_id) and is_admin($from_id,$chat_id,"view") !== "creator"){
$r .= "ادمن ";
}
if(in_array($from_id,$groups_json['groups'][$chat_id]['managers'])){
$r .= "مدير ";
}
if(in_array($from_id,$groups_json['groups'][$chat_id]['features'])){
$r .= "مميز ";
}
if(isset(explode(' ',$r)[1])){
$r = empty ($r) ? "عضو" : str_replace(" "," , ",$r);
}else{
$r = empty ($r) ? "عضو" : $r;
}
$token = API_KEY;
if($groups_json["groups"][$chat_id]["acs"]["idphoto"] == "yes"){
$send = json_decode(file_get_contents("https://api.telegram.org/bot$token/GetUserProfilePhotos?user_id=".$from_id),true);
$s = bot('sendphoto',[
'chat_id'=>$chat_id,
'photo'=>$send['result']['photos'][0][0]['file_id'],
'parse_mode'=>"MarkDown",
'caption'=>"
✅¦ اسمك •⊱ *$name*
✅¦ ايديك •⊱ `$from_id`
✅¦ رتبتك •⊱ *$r*",
'reply_to_message_id'=>$message_id,
]);
if($s->ok !== true){
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"
✅¦ اسمك •⊱ *$name*
✅¦ ايديك •⊱ `$from_id`
✅¦ رتبتك •⊱ *$r*",
'reply_to_message_id'=>$message_id,
]);
return 0;
}
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"
✅¦ اسمك •⊱ $name
✅¦ ايديك •⊱ `$from_id`
✅¦ رتبتك •⊱ *$r*",
'reply_to_message_id'=>$message_id,
]);
return 0;
}
}
if($text == "كشف" && $reply_user !== $us && isset($reply_id)){
if(is_admin($reply_id,$chat_id,"view") == "creator"){
$r .= "مالك ";
}
if(is_admin($reply_id,$chat_id) and is_admin($reply_id,$chat_id,"view") !== "creator"){
$r .= "ادمن ";
}
if(in_array($reply_id,$groups_json['groups'][$chat_id]['managers'])){
$r .= "مدير ";
}
if(in_array($reply_id,$groups_json['groups'][$chat_id]['features'])){
$r .= "مميز ";
}
if(isset(explode(' ',$r)[1])){
$r = empty ($r) ? "عضو" : str_replace(" "," , ",$r);
}else{
$r = empty ($r) ? "عضو" : $r;
}
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"
✅¦ اسمه •⊱ $reply_tag
✅¦ ايديه •⊱ `$reply_id`
✅¦ رتبته •⊱ *$r*",
'reply_to_message_id'=>$message_id,
]);
return 0;
}
if($text == "رتبتي"){
if(in_array($from_id,$sudo) || in_array($from_id,$sudo_json['sudo']['devs'])){
$r .= "مطور ";
}
if(is_admin($from_id,$chat_id,"view") == "creator"){
$r .= "مالك ";
}
if(is_admin($from_id,$chat_id) and is_admin($from_id,$chat_id,"view") !== "creator"){
$r .= "ادمن ";
}
if(in_array($from_id,$groups_json['groups'][$chat_id]['managers'])){
$r .= "مدير ";
}
if(in_array($from_id,$groups_json['groups'][$chat_id]['features'])){
$r .= "مميز ";
}
if(isset(explode(' ',$r)[1])){
$r = empty ($r) ? "عضو" : str_replace(" "," , ",$r);
}else{
$r = empty ($r) ? "عضو" : $r;
}
bot('sendmessage',[
'chat_id'=>$chat_id,
'parse_mode'=>"MarkDown",
'text'=>"❇| رتبتك : *$r*",
'reply_to_message_id'=>$message_id,
]);
}
if($message && !$text){
$groups_json["groups"][$chat_id]["media"][] = $message_id;
file_put_contents("groups_json.json",json_encode($groups_json,64|128|256));
}
if($message && !in_array($from_id,$groups_json["groups"][$chat_id]["ids"])){
$groups_json["groups"][$chat_id]["ids"][] = $from_id;
file_put_contents("groups_json.json",json_encode($groups_json,64|128|256));
}
if($message){
$groups_json["spam"][$d][$m][$chat_id][$from_id] += 1;
file_put_contents("groups_json.json",json_encode($groups_json,64|128|256));
}

if($text == "التعليمات" or $text == "شرح" or $text == "م5"){
  Bot('SendMessage',[
   'chat_id'=>$chat_id,
  'parse_mode'=>"MarkDown",
  'text'=>"
  *
  🇸🇦 ¦ قفل الدردشة تعني لا يمكن لأحد أن يرسل شي في القروب غير المميزين والادامن

  🇸🇦 ¦ قفل الصوتيات تعني لا يمكن إرسال رسالة صوتية مسجلة

  🇸🇦 ¦ قفل الصوت تعني منع ارسال مقطع صوتي

  🇸🇦 ¦ قفل الفيديو تعني منع ارسال الفيديوهات

  🇸🇦 ¦ قفل الصور تعني منع ارسال الصوت

  🇸🇦 ¦ قفل الملصقات تعني ممنوع ارسال ملصقات على شكل صور

  🇸🇦 ¦ قفل المتحركات تعني ممنوع ارسال صور متحركة

  🇸🇦 ¦ قفل الملفات تعني ممنوع ارسال الملفات مثل ملف pdf 

  🇸🇦 ¦ قفل الروابط تعني ممنوع ارسال رابط في المجموعة

  🇸🇦 ¦ قفل القنوات تعني ان البوت سوف يحظر اي قناة ترسل رسالة
  
  🇸🇦 ¦ قفل المارك تعني قفل المربعات التي بداخلها روابط

  🇸🇦 ¦ قفل الايدي بالصورة تعني اذا كتب شخص ايدي لا تظهر صورته

  🇸🇦 ¦ قفل المعرفات تعني منع ارسال هذا الرمز@

  🇸🇦 ¦ قفل التعديل تعني ان الشخص بعد ما يرسل رسالته لا يستطيع التعديل عليها 

  🇸🇦 ¦ قفل الانلاين تعني من البوتات من البحث في مواقع الويب

  🇸🇦 ¦ قفل التوجيه تعني ممنوع تحويل الرسائل للمجموعة من المجموعات الاخرى وخلافه

  🇸🇦 ¦ قفل المنشورات تعني ممنوع ارسال رسائل طويلة

  🇸🇦 ¦ قفل الاشعارات تعني ان البوت يمسح فلان دخل فلان غادر من شاشة الدردشة
  
  🇸🇦 ¦ قفل التكرار تعني ان البوت سوف يمسح الرسالة بعدما تتجاوز عدد التكرار المسموح
  *
  "
]);
}

if($text == "المطور" or $text == "مطور" or $text == "سورس" or $text == "سورس" or $text == "مطور السورس" or $text == "السورس"){
$admin = $message->from->username;
$photo = "http://telegram.me/yousef_labban";
bot('SendPhoto',[
'chat_id'=>$chat_id,
'photo'=>$photo,
'parse_mode'=>"MarkDown",
'caption'=>"


🇸🇦 ┇ [حساب المطور YL](http://telegram.me/yousef_labban)
🇸🇦 ┇ [قناة المطور](http://telegram.me/yousef_labban1)
🇸🇦 ┇ [مجموعتي](https://t.me/menhaj1alsonnah)
🇸🇦 ┇ [قناة اليوتيوب](https://youtube.com/channel/UCTjdBpWvEdgiorvWSeB3VwA)
",
]);
} 

require("qoran/qoran.php");
require("ha/ha.php");


$newbots = $update->message->new_chat_member->username;
$newid = $update->message->new_chat_member->id;
if(preg_match('/^(.*)([Bb][Oo][Tt])/s',$newbots)){
bot('kickChatMember',['chat_id'=>$chat_id,'user_id'=>$newid]);
bot('kickChatMember',['chat_id'=>$chat_id,'user_id'=>$from_id]);}




}
}
}
