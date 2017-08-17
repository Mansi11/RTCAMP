<?php
session_start();
require_once("./lib/autoload.php");
use Abraham\TwitterOAuth\TwitterOAuth;


define('CONSUMER_KEY','gIU0R5o4YY4zpqD0B7qKwdVoE');
define('CONSUMER_SECRET','scy1USBMcrmz8FUd6t4j9D3ULD2bbJhWqfAPahfSNQf99LYW6c');
define('ACCESS_TOKEN','895563161339699201-MGubcSGAlLmb8Hriadhmh1PxclyzdoA');
define('ACCESS_SECRET','3Gdt0fIYTw1fPALbJXYPRojHioIQdCDk0FKgI9AGz71d4');

$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_SECRET);

 $id = $_GET['id'];
 $limit=10;
  // Implement
  $arr = $connection->get("users/show",['screen_name'=>$id]);
  $tweets = $connection->get("statuses/user_timeline", array('count' => $limit, 'exclude_replies' => true, 'screen_name' => $id));
  $a = array(
    'name' => $arr->name ,
    'profile' => $arr->profile_image_url,
    'posts'=> $tweets
    );
$user = json_encode($a);
//$posts=json_encode($tweets);
echo $user;
?>
