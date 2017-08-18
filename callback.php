<?php
  session_start();
  require_once("./lib/autoload.php");
  use Abraham\TwitterOAuth\TwitterOAuth;

  define('CONSUMER_KEY','gIU0R5o4YY4zpqD0B7qKwdVoE');
  define('CONSUMER_SECRET','scy1USBMcrmz8FUd6t4j9D3ULD2bbJhWqfAPahfSNQf99LYW6c');
  define('ACCESS_TOKEN','895563161339699201-MGubcSGAlLmb8Hriadhmh1PxclyzdoA');
  define('ACCESS_SECRET','3Gdt0fIYTw1fPALbJXYPRojHioIQdCDk0FKgI9AGz71d4');
  define('OAUTH_CALLBACK','https://mansishah3883.000webhostapp.com/callback.php');

  //echo $_REQUEST['oauth_token'];
  if(isset($_REQUEST['oauth_token']))
  {
        $request_token=[];
        $request_token['oauth_token']=$_SESSION['oauth_token'];
        $request_token['oauth_token_secret'] = $_SESSION['oauth_token_secret'];
        $connection=new TwitterOAuth(CONSUMER_KEY,CONSUMER_SECRET,$request_token['oauth_token'],$request_token['oauth_token_secret']);
        $access_token=$connection->oauth("oauth/access_token",array("oauth_verifier"=>$_REQUEST['oauth_verifier']));
        $_SESSION['access_token']=$access_token;
  }
  header('location:home.php');
 ?>
