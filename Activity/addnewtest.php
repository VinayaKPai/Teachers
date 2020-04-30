<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Teachers Tools LH</title>
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!-- stylesheet -->
	<link rel="stylesheet" type="text/css" href="/stylesheet.css"  />
</head>
<body class="body">
	<div class="container">
			<div style="text-align: right">
				<?php include $_SERVER['DOCUMENT_ROOT']."/basecode-create_connection.php";
					echo $datetime1; ?>
			</div>
			<hr>
			<?php
				$pageHeading = "Tests";

				include $_SERVER['DOCUMENT_ROOT']."/Components/header.php";
				include $_SERVER['DOCUMENT_ROOT']."/Components/top.php";
				if ($_GET){echo $_GET;}
			?>
			 <a href="../../SetUpPages/newQuestions.php">
				 <h4 class="btn btn-block topbanner">Add New test
					 <small style="padding: 10px; color: White;">This will take you to the question bank</small>
				 </h4>
			 </a>
			 <div class="panel-group" id="accordion">
			     <div class="panel panel-default">
			       <div class="panel-heading">
			         <h4 class="panel-title centered">
			           <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">All Saved Assessments</a>
			         </h4>
			       </div>
			       <div id="collapse1" class="panel-collapse collapse">
			         <div class="panel-body" style="height: 300px; overflow: scroll;">
								 <table style='width: 100%;'>
									 <caption class="centered">**********  Saved Assessments  **********</caption>
									 <?php
										include $_SERVER['DOCUMENT_ROOT']."/AddNew/Existing/tests.php";
								 		?>
									</table>
								</div>
			       </div>
			     </div>
			     <div class="panel panel-default">
			       <div class="panel-heading">
			         <h4 class="panel-title centered">
			           <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">Previously deployed Tests</a>
			         </h4>
			       </div>
			       <div id="collapse2" class="panel-collapse collapse">
			         <div class="panel-body" style="height: 300px; overflow: scroll;">
								 <h4>Administered Tests</h4>
								 <table style='width: 100%;'>
									 <caption class="centered">**********  Administered Tests  **********</caption>
									 <?php
									 include $_SERVER['DOCUMENT_ROOT']."/Activity/administeredTests.php";
									 ?>
								</table>

							 </div>
			       </div>
			     </div>
			     <div class="panel panel-default">
			       <div class="panel-heading">
			         <h4 class="panel-title centered">
			           <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">Ongoing Tests</a>
			         </h4>
			       </div>
			       <div id="collapse3" class="panel-collapse collapse">
			         <div class="panel-body" style="height: 300px; overflow: scroll;"><h4>Ongoing Tests</h4>
							 <table style='width: 100%;'>
								 <caption class="centered">**********  Ongoing Tests  **********</caption>
							 </table>
							 </div>
			       </div>
			     </div>
					 <div class="panel panel-default">
			       <div class="panel-heading">
			         <h4 class="panel-title centered">
			           <a data-toggle="collapse" data-parent="#accordion" href="#collapse4">Future or undeployed Tests</a>
			         </h4>
			       </div>
			       <div id="collapse4" class="panel-collapse collapse">
			         <div class="panel-body" style="height: 300px; overflow: scroll;">
								 <table style='width: 100%;'>
									 <caption class="centered">**********  Future or undeployed Tests  **********</caption>
								 </table></div>
			       </div>
			     </div>

			  </div>





	 </div>
<!-- </body>
</html> -->
