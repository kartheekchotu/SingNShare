<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Sing N Share</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
    body {
        padding-top: 70px;
        /* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */
    }
    </style>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Sing&Share</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="#">Upload Song</a>
                    </li>
                    <li>
                        <a href="image.php">Upload image</a>
                    </li>
                    <li>
                        <a href="#">Logout</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container">

        <div class="row">
            <div class="col-lg-12 text-center">
              <!DOCTYPE html>
<html>
<body>
<form method="post" enctype="multipart/form-data">

 
 <input type="file" name="file" value="select Song" required><br> 
 <input type="submit" value="Upload" name="disp">
</br>
</br>
</form>

</body>
</html>
<?php   //This is the directory where images will be saved
 session_start();
 if(!isset($_SESSION['username']))
{
    // not logged in
    header('Location: http://localhost/SingNShare/index.php');
    exit();
}
 mysql_connect('localhost','root','','mydb') or die(mysql_error($con)) ;
	mysql_select_db("mydb") or die(mysql_error($con)) ;   //Writes the information to the database 
		$query=mysql_query("select * from songs ORDER BY id DESC") or die(mysql_error());
		//echo "<table>";
		$sname=mysql_query("SELECT r.username FROM songs s,register r WHERE s.nameid=r.id");
		while($all_audio=mysql_fetch_array($query))
 
 		{
           $names=mysql_fetch_array($sname)  or die(mysql_error());          
 		   //echo $all_audio;
			//$ab=time_elapsed_string($all_audio['time'],2)
			$ab=timeAgo($all_audio['time']);
			//$date=getdate($all_audio[3]);	
			 //$_SESSION['username']
			echo '<div class="list-group"><a  class="list-group-item active">'. $names['username'].' has uploaded this song on '.$ab.'</a>';
			echo '<a class="list-group-item">'.$a=$all_audio['title'].'</a>';
						
			?>
			<a  class="list-group-item">
			<audio   controls>
<!--	<source src="uploads/" type="audio/mpeg"> -->
			<source src="<?php echo $all_audio['path'];  ?>" type="audio/mp3">
 
			Your browser does not support the audio tag
			</audio> 
			</a>
			</div>
 <?php ;}
 
 
 
 if(isset($_POST['disp']))
 {
	 
 
	$target = "uploads/"; 
	$target = $target . basename( $_FILES['file']['name']);  
	//This gets all the other information from the form	
	$nameid=$_SESSION['id']; 
	//extract($_POST);
	$pic=($_FILES['file']['name']);
   // Connects to your Database  
	
	mysql_query("INSERT INTO songs VALUES (NULL,'$nameid','$pic',current_timestamp,'$target')") ; 
  //Writes the photo to the server
	if(move_uploaded_file($_FILES['file']['tmp_name'], "uploads/".$_FILES['file']['name']))  {   
	//Tells you if its all ok 
	echo "The file ". basename( $_FILES['file']['name']). " has been uploaded, and your information has been added to the directory";  }  else { 
  //Gives and error if its not 
	echo "Sorry, there was a problem uploading your file."; 
	} 
echo '<script type="text/javascript">'
   , 'load();'
   , '</script>'
;
	}    //echo "sunil";

 ?>	
<?php

function timeAgo($time_ago)
{
    $time_ago = strtotime($time_ago);
    $cur_time   = time();
    $time_elapsed   = $cur_time - $time_ago;
    $seconds    = $time_elapsed ;
    $minutes    = round($time_elapsed / 60 );
    $hours      = round($time_elapsed / 3600);
    $days       = round($time_elapsed / 86400 );
    $weeks      = round($time_elapsed / 604800);
    $months     = round($time_elapsed / 2600640 );
    $years      = round($time_elapsed / 31207680 );
    // Seconds
    if($seconds <= 60){
        return "just now";
    }
    //Minutes
    else if($minutes <=60){
        if($minutes==1){
            return "one minute ago";
        }
        else{
            return "$minutes minutes ago";
        }
    }
    //Hours
    else if($hours <=24){
        if($hours==1){
            return "an hour ago";
        }else{
            return "$hours hrs ago";
        }
    }
    //Days
    else if($days <= 7){
        if($days==1){
            return "yesterday";
        }else{
            return "$days days ago";
        }
    }
    //Weeks
    else if($weeks <= 4.3){
        if($weeks==1){
            return "a week ago";
        }else{
            return "$weeks weeks ago";
        }
    }
    //Months
    else if($months <=12){
        if($months==1){
            return "a month ago";
        }else{
            return "$months months ago";
        }
    }
    //Years
    else{
        if($years==1){
            return "one year ago";
        }else{
            return "$years years ago";
        }
    }
}
?> 
 
 
            </div>
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container -->

    <!-- jQuery Version 1.11.1 -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
   <script>
   function load()
   
   {
   location.reload();
   }
   </script>
</body>

</html>
