<?php
session_start();
require "../dbcon.php";
		if(!isset($_SESSION['worker']))
		{			
			$_SESSION['invalid']="First Login After Use...!";
			header('location: ../login.php');
		}
?>

<html lang="en">
<head>
  <title>Massage Box</title>
   <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  	<link rel="stylesheet" href="../css/userindex.css">
    <script src="../js/jquery-3.3.1.slim.min.js"></script>
  <script src="../js/popper.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <link rel="shortcut icon" href="../image/favicon.ico">
  <link href="../fontawesome-free-5.12.1-web/css/all.css" rel="stylesheet"> <!--load all styles -->
</head>
<body class="jumbotron">
<?php

/*----------------- NAVBAR --------------*/
	include "../layout/user_navbar.php";  
?>

<section class=" container find_work">
	<div class="row">
		<div class="col-lg-12">
			<h6 class="h1">Inbox</h1>
		</div>
		
	</div>
</section>
<?php

if($_POST)
{
	
	 $wid=$_POST['wid'];
	 $jid=$_POST['jid'];
	 $hid=$_POST['hid'];
}

		
		$query_work="SELECT * FROM `work` WHERE `w_id`='$wid'";
		
		$run_work=mysqli_query($conn,$query_work);
			
		$data=mysqli_fetch_assoc($run_work);		
		
		
		$query_sms="SELECT * FROM `massage` WHERE `w_id`='$wid' AND `h_id`='$hid' AND `j_id`='$jid'";
		
		$run_sms=mysqli_query($conn,$query_sms);
	?>					
	

<div class="my-3 p-3 bg-white rounded box-shadow container">
        <h6 class="border-bottom border-gray pb-2 mb-0">Recent Massage</h6>
<?php	
			
			while ($data1=mysqli_fetch_assoc($run_sms))
			{
  ?>
     <?php
	 if($data1['status']=="send by hire")
	 {
		 $hire_id=$data1['h_id'];
		 $query="SELECT * FROM `hire` WHERE `h_id`='$hire_id'";																	
							
				$run_hire=mysqli_query($conn,$query);
				$row2 = mysqli_fetch_array($run_hire);
				
					
					$hire_fname=$row2['h_fname']; 
					$hire_lname=$row2['h_lname']; 	
	 ?>
        <div class="media text-muted pt-3 ">
          
          <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
            <strong class="d-block text-gray-dark"><?php echo strtoupper($hire_fname)," ",strtoupper($hire_lname);?></strong>
				<?php echo $data1['sms'];?>
          </p>
        </div>
		
	 <?php
	 
	 }
		
	 if($data1['status']=="send by worker")
	 {
	 ?>
        <div class="media text-muted pt-3 text-right">
          
          <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
            <strong class="d-block text-gray-dark"><?php echo strtoupper($fname)," ",strtoupper($lname);?></strong>
				<?php echo $data1['sms'];?>
          </p>
        </div>
		
	 <?php
	 
	 }
	 }

	 ?> <br>
	 <form class="login-form text-center"  action="#" method="post">
		<div class="form-group">
							<input type="hidden" value="<?php echo $hid;?>" name="hid">	
					<input type="hidden" value="<?php echo $jid;?>" name="jid">	
					<input type="hidden" value="<?php echo $wid;?>" name="wid">									
			<input type="text" class="form-control rounded-pill form-control-lg" placeholder="Type a message.." name="sms" required><br>
			<input type="submit" name="submit_sms" class="btn btn-success" value="Send Massage">
		</div>
	</form>
      </div>
</body>
</html>
<?php
	if($_POST['submit_sms'])
	{	
 $wid=$_POST['wid'];
	 $jid=$_POST['jid'];
	 $hid=$_POST['hid'];
		$sms=$_POST['sms'];
		$t=time(); 
		$time=(date("d-m-Y",$t));
		$query="INSERT INTO `massage` (`w_id`, `j_id`, `h_id`, `date`, `sms`, `status`) VALUES ('$wid','$jid','$hid','$time','$sms','send by worker')";
		$run=mysqli_query($conn,$query);
		echo '<script type="text/javascript">window.location=\'massage.php\';</script>';
	}

?>