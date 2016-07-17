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
 
 if(isset($_POST['disp']))
 {
	$file_type_full = explode('/',$_FILES['file']['type']);
	/*echo '<pre>';
	 print_r($file_type_full);
	echo '</pre>';
    */
    $file_type = $file_type_full[1];

	

	/*echo '<pre>';
	 print_r($_FILES['file']);
	echo '</pre>';	 
    */
	// Connects to your Database  
		mysql_connect('localhost','root','','mydb') or die(mysql_error($con)) ;
		mysql_select_db("mydb") or die(mysql_error($con)) ;   //Writes the information to the database 
		
	 if($file_type == 'wav' || $file_type == 'mp3')
	 {	 
		 $target = "uploads/"; 
		$target = $target . basename( $_FILES['file']['name']);  
		//This gets all the other information from the form	
		$nameid=$_SESSION['id']; 
		//extract($_POST);
		$pic=($_FILES['file']['name']);
	    mysql_query("INSERT INTO songs VALUES (NULL,'$nameid','$pic',current_timestamp,'$target')") ; 
	   //Writes the photo to the server
		if(move_uploaded_file($_FILES['file']['tmp_name'], "uploads/".$_FILES['file']['name']))  {   
		//Tells you if its all ok 
		echo "The file ". basename( $_FILES['file']['name']). " has been uploaded, and your information has been added to the directory";  }  else { 
	   //Gives and error if its not 
		echo "Sorry, there was a problem uploading your file."; 
		} 
	 }
	 else
	 { 
        print 'File type: '.$file_type.'<br>';	 	
		echo "Wrong file type";
	 }
     //echo "sunil";
		$query=mysql_query("select * from songs ORDER BY id DESC") or die(mysql_error());
		//echo "<table>";
		$sname=mysql_query("SELECT r.username FROM songs s,register r WHERE s.nameid=r.id");
		while($all_audio=mysql_fetch_array($query))
 
 		{
           $names=mysql_fetch_array($sname)  or die(mysql_error());          
 		   //echo $all_audio;
			//$ab=time_elapsed_string($all_audio['time']);
			//$date=getdate($all_audio[3]);	
			 //$_SESSION['username']
			echo '<div class="list-group"><a  class="list-group-item active">'. $names['username'].' has uploaded this song on '.$all_audio['time'].'</a>';
			echo '<a class="list-group-item">'.$a=$all_audio['title'].'</a>';
						
			?>
			<a  class="list-group-item">
			<audio   controls>
<!--	<source src="uploads/" type="audio/mpeg"> -->
			<source src="<?php echo $all_audio['path'];  ?>"  accept="audio/mp3" type="audio/mp3">
 
			Your browser does not support the audio tag
			</audio> 
			</a>
			</div>
 <?php ;}
 
 
 }?>
<?php
function time_elapsed_string($ptime)
{
    $etime = time() - $ptime;

    if ($etime < 1)
    {
        return '0 seconds';
    }

    $a = array( 365 * 24 * 60 * 60  =>  'year',
                 30 * 24 * 60 * 60  =>  'month',
                      24 * 60 * 60  =>  'day',
                           60 * 60  =>  'hour',
                                60  =>  'minute',
                                 1  =>  'second'
                );
    $a_plural = array( 'year'   => 'years',
                       'month'  => 'months',
                       'day'    => 'days',
                       'hour'   => 'hours',
                       'minute' => 'minutes',
                       'second' => 'seconds'
                );

    foreach ($a as $secs => $str)
    {
        $d = $etime / $secs;
        if ($d >= 1)
        {
            $r = round($d);
            return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' ago';
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

</body>

</html>
