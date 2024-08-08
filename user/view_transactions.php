<?php
session_start();
ob_start();
?>

<!DOCTYPE html>
<html>
<head>
<title>Profile</title>

  <meta charset="utf-8">
  
  <!-- mobile responsive meta -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="css/style-footer.css">
      <link href="css/style-header.css" rel="stylesheet">
      <link href="css/style-body.css" rel="stylesheet">
      <link href="css/style2.css" rel="stylesheet">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">

</head>

<?php
include("db.php");
$name=$_SESSION['uname'];
$result=mysqli_query($con,"select username,name,email,phone,userimage from user where username='$name'");
		if (mysqli_num_rows($result)>0)
		{
		$row=mysqli_fetch_array($result);
		$uname=$name;
		$rname=$row[1];
		$email=$row[2];
		$phone=$row[3];
		$userpic=$row[4];
		}
?>

<body>

<!--Main Header-->
<nav class="navbar navbar-default">
      <div class="container">.
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header"><span style="color: #fff;">Transactions</span>
                  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"
                        aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                  </button>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                  <ul class="nav navbar-nav">
                        <li class="active">
                              <a href="./view_transactions.php">View transaction</a>
                        </li>
                        <li>
                              <a href="about.html">Transfer Money</a>
                        </li>
                        <li>
                              <a href="../change_graphicalpw/check_textpw.html">Change Image Pass Point</a>
                        </li>
                        <li>
                              <a href="../change_text_pw/change_pw.html">Change Text Password</a>
                        </li>
                        <li>
                              <a href="../change_profilepic/change_profile_pic.html">Change Profile Picture</a>
                        </li>
                        <li>
                              <a href="../change_user_details/change_profile_info.html">Change Profile Details</a>
                        </li>                                             
                  </ul>
            </div>
            <!-- /.navbar-collapse -->
      </div>
      <!-- /.container-fluid -->
</nav>
<!--End Main Header -->

<div class="signupform">
	<div class="container">
		<div class="agile_info">
			<div class="login_form text-center">
				<div class="transaction">
                              <h2>Transfer to Biodun Abik... #1000</h2>
                              <div style="display: flex; justify-content: space-between;">
                                    <p>June 28th, 16:16:59</p>
                                    <span style="color: #fff; background: green; padding: .3rem;">Successful</span>
                              </div>
                        </div> <br/><br/>
                        <div class="transaction">
                              <h2>Transfer to Ndunche Ble... #5000</h2>
                              <div style="display: flex; justify-content: space-between;">
                                    <p>June 28th, 17:16:59</p>
                                    <span style="color: #fff; background: green; padding: .3rem;">Successful</span>
                              </div>
                        </div><br/><br/>
                        <div class="transaction">
                              <h2>Transfer to Funke Ade... #1000</h2>
                              <div style="display: flex; justify-content: space-between;">
                                    <p>June 29th, 5:14:36</p>
                                    <span style="color: #fff; background: red; padding: .3rem;">Failed</span>
                              </div>
                        </div>
				
			</div>
	
		</div>
	</div>

</div>

<script src="plugins/jquery.js"></script>
<script src="plugins/bootstrap.min.js"></script>
<script src="plugins/bootstrap-select.min.js"></script>


<script src="plugins/validate.js"></script>
<script src="plugins/wow.js"></script>
<script src="plugins/jquery-ui.js"></script>
<script src="js/script.js"></script>

</body>
</html>