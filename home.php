<?php
        session_start();
        require_once("./lib/autoload.php");
        use Abraham\TwitterOAuth\TwitterOAuth;

        define('CONSUMER_KEY','gIU0R5o4YY4zpqD0B7qKwdVoE');
        define('CONSUMER_SECRET','scy1USBMcrmz8FUd6t4j9D3ULD2bbJhWqfAPahfSNQf99LYW6c');
        define('ACCESS_TOKEN','895563161339699201-MGubcSGAlLmb8Hriadhmh1PxclyzdoA');
        define('ACCESS_SECRET','3Gdt0fIYTw1fPALbJXYPRojHioIQdCDk0FKgI9AGz71d4');
        define('OAUTH_CALLBACK','https://mansishah3883.000webhostapp.com/callback.php');

        if(!isset($_SESSION['access_token'])){
          header('location:index.php');
        }
        $access_token = $_SESSION['access_token'];

        $connection=new TwitterOAuth(CONSUMER_KEY,CONSUMER_SECRET,$access_token['oauth_token'],$access_token['oauth_token_secret']);
        //var_dump($user);

        $user=$connection->get("account/verify_credentials");

        $profiles = array();

        // Get Followers List
        $ids = $connection->get('followers/list');
        $list= json_decode(json_encode($ids), true);
        $list=$list['users'];
        $length_user=count($list);
        $json=json_encode($list);

        //Get User Tweets
        $limit=10;
        $tweets = $connection->get("statuses/user_timeline", array('count' => $limit, 'exclude_replies' => true, 'screen_name' => $user->screen_name));
        $tweets= json_decode(json_encode($tweets), true);
  ?>

<!DOCTYPE html>
<html>
  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Twitter</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

    <link rel="stylesheet" href="css/style.css";
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->

  </head>

  <body class="hold-transition skin-blue layout-boxed sidebar-mini">
      <div class="wrapper">
         <header class="main-header">
            <a href="#" class="logo">
              <span class="logo-lg"><b>Twitter</b></span>
            </a>
            <nav class="navbar navbar-static-top" role="navigation">
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                  <span class="sr-only">Toggle navigation</span>
                </a>
                <div class="navbar-custom-menu">
                  <ul class="nav navbar-nav">
                    <li>
                        <a href="" id="my_profile" class="my_profile"><i class="glyphicon glyphicon-user"></i> My Profile </a>
                    </li>

                    <li class="dropdown">
                        <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="glyphicon glyphicon-download"></i>Download<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                          <li><a href="Download.php?type=1" st>csv</a></li>
                          <li><a href="Download.php?type=2">xls</a></li>
                          <li><a href="Download.php?type=3">json</a></li>
                          <li><a href="Download.php?type=4">upload to Drive</a></li>
                        </ul>
                      </li>

                    <li>
                        <a href="logout.php"><i class="glyphicon glyphicon-log-out"></i> Logout </a>
                    </li>
                 </ul>
            </div>
          </nav>
        </header>


        <aside class="main-sidebar">
            <section class="sidebar">
                <div class="input-group">
                  <input type="text" id="sea" class="sear" name="q" class="form-control" placeholder="Search..." style="width:210px; margin-left:10px; margin-top:10px;" />
                </div>


            <ul class="sidebar-menu">
               <div id="searchlist" class="listsearch">

              </div>
              <li class="header">
                <h4 style="font-family:cursive;">
                  <center>
                    Followers
                  </center>
                </h4>
              </li>

  <?php
  $i=0;

  foreach($list as $arr)
  {
    if($i>9)
      break;
  ?>
            <li>
              <button style="background-color: Transparent;
                             border: none;  color:white; margin-bottom:10px; margin-left:5px;
                             cursor:pointer;" class="follower" data-value="<?php echo $arr['screen_name'];?>">
                  <img src="<?php echo
                      $arr['profile_image_url']; ?>" alt="user" width="50px" height="50px" style="display:inline-block;border-radius:100%;">
                  </img>
                  <span style="margin-left:15px;">
                      <?php echo $arr['name']; ?>
                  </span>
             </button>
           </li>
  <?php
    $i++;
  }
  ?>
        </ul>
      </section>
    </aside>

    <div class="content-wrapper">
      <section class="content-header">
        <h1 style="display: inline-block;">
              Timeline
               &nbsp;&nbsp;
              <h3 style="display: inline-block;" class="uname" id="usrname">
                <?php echo($user->name); ?>
              </h3>
              <div style="display:inline-block;margin-left:220px;">
                    <img class="propic" id="profile" src="<?php echo($user->profile_image_url); ?>" alt="user" height="70px" width="70px" style="border-radius:100%;"></img>
              </div>
       </h1>
      </section>

     <section class="content">
       <div class="slideshow-container">
  <?php

      foreach($tweets as $ar1)
      {
         $temp=$ar1['text'];
  ?>
          <div class="mySlides fade">
            <div class="box">
              <div id="content" class="box-body" style="margin-left:50px;">
  <?php
         echo($temp);
  ?>
             </div><!-- /.box-body -->

            <div class="box-footer" style="margin-left:50px;">
              <button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-thumbs-up"<span class="badge" id='like'> <?php echo($ar1['favorite_count']) ?></span></span></button>
              <button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-comment"<span class="badge" id='retweet'> <?php echo($ar1['retweet_count']) ?> </span></span></button>
            </div><!-- /.box-footer-->
          </div><!-- /.box -->
            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next" onclick="plusSlides(1)">&#10095;</a>
          </div>
  <?php
   }
  ?>

        </div>
      </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
  </div>

    <div class="control-sidebar-bg"></div>
  </div>

    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <script src="js/JSFile.js"></script>

    <script>
      $(document).ready(function(){
        var user;
      user= <?php echo $json; ?>;

        $('.follower').on('click', function(e){
        var id = $(this).attr('data-value');

         $.ajax({
           url:'getFollowers.php?id='+id,
           dataType:'json',
           type:'GET',
           success:function(results){
             $('#profile').attr('src',results['profile']);
             $('#usrname').text(results['name']);
             var length=0;
             if(results['posts'].length>10){
                    length=10;
             }
            else {
                    length=results['posts'].length;
              }
              //alert(length);
              var t='';
              if(length==0)
              {
                t += '<div class="mySlides fade"><div class="box"><div id="content" class="box-body" style="margin-left:50p">No Tweets Found</div></div></div>';
                $('.slideshow-container').html(t);
              }
              else
              {
                t = '';
                for(i=0;i<length;i++)
                {
                    var a = results['posts'][i].text ;
                    var c = results['posts'][i].retweet_count;
                    var l=  results['posts'][i].favorite_count;
                    t += '<div class="mySlides fade"><div class="box"><div id="content" class="box-body" style="margin-left:50p">'
                    + a
                    +'</div><div class="box-footer" style="margin-left:50px;"><button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-thumbs-up"<span class="badge" id="like"> l </span></span></button> <button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-comment"<span class="badge" id="retweet">'
                    + ' '
                    +c
                    +'</span></span></button></div></div><a class="prev" onclick="plusSlides(-1)">&#10094;</a><a class="next" onclick="plusSlides(1)">&#10095;</a></div>';
                }
                //alert(t);
                $('.slideshow-container').html(t);
              }

           }
         });
      });

//search

      $('.sear').on('input', function(e){
        var text=$(this).val();
        var pattern=new RegExp('^.*'+text+'.*$','i');
        var length_followers=user.length;
        var i=0;
        var array = [];
var t='';
        var array1 = [];
        for(i=0;i<length_followers;i++)
        {
          var sn=user[i].screen_name;
            var name=user[i].name;
            //var load_data='';

            if(pattern.test(name))
            {
              t=t+'<li><button style="background-color: Transparent;border: none;  color:white; margin-bottom:10px; margin-left:5px;cursor:pointer;" class="follower123" data-value="'+sn+'"><img src="'+user[i].profile_image_url+'" alt="user" width="50px" height="50px" style="display:inline-block;border-radius:100%;"></img><span style="margin-left:15px;">'+name+'</span></button></li>';

            }
        }

          $('.listsearch').html(t);
        });

        $(document.body).on('click','.follower123',function(){
          var id = $(this).attr('data-value');

           $.ajax({
             url:'getFollowers.php?id='+id,
             dataType:'json',
             type:'GET',
             success:function(results){
               $('#profile').attr('src',results['profile']);
               $('#usrname').text(results['name']);
               var length=0;
               if(results['posts'].length>10){
                      length=10;
               }
              else {
                      length=results['posts'].length;
                }
                //alert(length);
                var t='';
                if(length==0)
                {
                  t += '<div class="mySlides fade"><div class="box"><div id="content" class="box-body" style="margin-left:50p">No Tweets Found</div></div></div>';
                  $('.slideshow-container').html(t);
                }
                else
                {
                  t = '';
                  for(i=0;i<length;i++)
                  {
                      var a = results['posts'][i].text ;
                      var c = results['posts'][i].retweet_count;
                      var l=  results['posts'][i].favorite_count;
                      t += '<div class="mySlides fade"><div class="box"><div id="content" class="box-body" style="margin-left:50p">'
                      + a
                      +'</div><div class="box-footer" style="margin-left:50px;"><button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-thumbs-up"<span class="badge" id="like"> l </span></span></button> <button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-comment"<span class="badge" id="retweet">'
                      + ' '
                      +c
                      +'</span></span></button></div></div><a class="prev" onclick="plusSlides(-1)">&#10094;</a><a class="next" onclick="plusSlides(1)">&#10095;</a></div>';
                  }
                  //alert(t);
                  $('.slideshow-container').html(t);
                }

             }
           });
        });
//      Search Complete


      });
    </script>

    <script>
        $(document).load(function(){
          $.ajax({
              url:'getAllFollowers.php',
              dataType:'json',
              type:'GET',
              success:function(results){
                alert(results.length);
              }
          });
       });
    </script>

    <script>
      $(document).ready(function(){

        $('#my_profile').on('click', function(e){
        var id = $(this).attr('data-value');
         $.ajax({
           url:'getFollowers.php?id='+id,
           dataType:'json',
           type:'GET',
           success:function(results){
             $('#profile').attr('src',results['profile']);
             $('#usrname').text(results['name']);
             var length=0;
             if(results['posts'].length>10){
                    length=10;
             }
            else {
                    length=results['posts'].length;
              }

              if(length==0)
              {
                  var t="No Post Found"
                  $('.slideshow-container').html(t);
              }

              else
              {
                var t = '';
                for(i=0;i<length;i++)
                {
                    var a = results['posts'][i].text ;
                    var c = results['posts'][i].retweet_count;
                    var l=  results['posts'][i].favorite_count;
                    t += '<div class="mySlides fade"><div class="box"><div id="content" class="box-body" style="margin-left:50p">'
                    + a
                    +'</div><div class="box-footer" style="margin-left:50px;"><button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-thumbs-up"<span class="badge" id="like"> l </span></span></button> <button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-comment"<span class="badge" id="retweet">'
                    + ' '
                    +c
                    +'</span></span></button></div></div><a class="prev" onclick="plusSlides(-1)">&#10094;</a><a class="next" onclick="plusSlides(1)">&#10095;</a></div>';
                }
                //alert(t);
                $('.slideshow-container').html(t);
              }
           }
         });
      });



    });
    </script>

  </body>
</html>
