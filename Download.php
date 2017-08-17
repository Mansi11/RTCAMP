<?php

      session_start();
      require_once("./lib/autoload.php");
      require_once("./lib/PHPExcel/PHPExcel.php");
      use Abraham\TwitterOAuth\TwitterOAuth;

      define('CONSUMER_KEY','gIU0R5o4YY4zpqD0B7qKwdVoE');
      define('CONSUMER_SECRET','scy1USBMcrmz8FUd6t4j9D3ULD2bbJhWqfAPahfSNQf99LYW6c');
      define('ACCESS_TOKEN','895563161339699201-MGubcSGAlLmb8Hriadhmh1PxclyzdoA');
      define('ACCESS_SECRET','3Gdt0fIYTw1fPALbJXYPRojHioIQdCDk0FKgI9AGz71d4');


        $access_token = $_SESSION['access_token'];
        $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);

        $user = $connection->get("account/verify_credentials");
        $tweets = $connection->get("statuses/user_timeline",["count" => 200, "exclude_replies" => true,"include_rts"=>true,"screen_name" => $screen_name]);

        $totalTweets[] = $tweets;
        $page = 0;
                for ($count = 200; $count < 3200; $count += 200)
                {
                        $max = count($totalTweets[$page]) - 1;
                        $tweets = $connection->get('statuses/user_timeline', ["count" => 200, "exclude_replies" => true,"include_rts"=>true,"screen_name" => $screen_name, 'max_id' => $totalTweets[$page][$max]->id_str]);
                        $max1 = count($totalTweets[$page]) - 1;
                            if($max == $max1)
                            {
                                    break;
                            }
                        $totalTweets[] = $tweets;
                        $page += 1;
                 }
                $start = 1;
                $index = 0;
                      foreach ($totalTweets as $page)
                      {
                              foreach ($page as $key)
                              {
                                      $user_tweets[$index++] = $key->text;
                                      $start++;
                              }
                      }

      $id=$_GET['type'];

      switch($id)
      {
        case 1:

                    header("Content-type: text/csv");
                    header("Content-Disposition: attachment; filename=tweets.csv");
                    header("Pragma: no-cache");
                    header("Expires: 0");
                    $count = count($user_tweets);
                    for($i=0;$i<$count;$i++)
                    {
                        $c = count($user_tweets[$i]);
                            echo $user_tweets[$i].' , ';
                    }
                    break;
        case 2:
                    $excel = new PHPExcel();
                    $count = count($user_tweets);
                    $row = 1;
                    $col = 1;
                    for($i=0;$i<$count;$i++)
                    {
                            $excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $user_tweets[$i]);
                            $row++;
                    }
                    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
                    header("Content-Disposition: attachment;filename=tweets.xlsx");
                    header("Cache-Control: max-age=0");
                    $file = PHPExcel_IOFactory::createWriter($excel,'Excel2007');
                    $file->save("php://output");
                    break;
        case 3:
                    header('Content-disposition: attachment; filename=tweets.json');
                    header('Content-type: application/json');
                    header("Pragma: no-cache");
                    header("Expires: 0");
                    $arr = array(
                        'tweets' => $user_tweets
                    );
                    $arr = json_encode($arr);
                    print_r($arr);
                    break;

        case 4:
                    $_SESSION['user-tweets'] = $user_tweets;
                    header('location:lib\google-drive-api/index.php');
                    break;

      }
             //header('location:home.php');


 ?>
