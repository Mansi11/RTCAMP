<?php
        session_start();
        require_once("autoload.php");
        require_once('src/TwitterOAuth.php');
        require_once('credentials.php');
        use Abraham\TwitterOAuth\TwitterOAuth;

        $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_SECRET);

        $profiles = array();
        $ids = $connection->get('followers/list');
        $list= json_encode($ids);
        $list=$list['users'];

        echo "$list";
?>
