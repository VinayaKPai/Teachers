<?php
	include $_SERVER['DOCUMENT_ROOT']."/basecode-create_connection.php";
	include $_SERVER['DOCUMENT_ROOT']."/Scripts/php/allRetrievalQueries.php";
	include $_SERVER['DOCUMENT_ROOT']."/Scripts/php/teachersQueryResultToHtmlTable.php";
	include $_SERVER['DOCUMENT_ROOT']."/Scripts/php/studentsQueryResultToHtmlDiv.php";
	$pageHeading = "Teachers";
	$pageCode = "NTD";
	$userName = "Guest";
	$userType = "";
	$loggedInUserName  = "";
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Teachers Tools LH - Manage Teachers</title>
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
			<link type="text" href="./Modals/modaltest.html"/link>
		<link rel="stylesheet" type="text/css" href="/stylesheet.css"  />
		</head>
	<body class="body">
		<div class="container">
			<h3 class="centered">
				<div id="top" class="row" style="padding: 1px;">
					<?php include "../Components/top.php"; ?>
				</div>
			</h3>
				<?php include $_SERVER['DOCUMENT_ROOT']."/Components/internalNav.php"; ?>
			<hr>
			<div class="container">
				<div style="padding: 3px; border: 1px solid #413949; border-radius: 5px;">
					<h5>Click on the teacher's name explore details</h5>
						<?php
							studentsForTeacher($mysqli);
						?>
				</div>
			</div>
			<div class="container">
				<div style="padding: 3px; border: 1px solid #413949; border-radius: 5px;">
				<h5>These teachers have not been assigned any classes</h5>
				<small><li>You can add classes for the active teachers by clicking on the "ADD CLASSES" button</li>
				<li>Only an Admin can change the "Inactive" status to "Active"</li></small>

					<?php teachersWithoutClasses($mysqli); ?>
					<div class='btn btn-text btn-block topbanner' id='showForm' onclick='clsFm()' style='float: right;'>Add Classes</div>
					<hr>
				<!-- </div> -->
				<div id="classFm" style="display: none;">
					<?php
						include $_SERVER['DOCUMENT_ROOT']."/Forms/newClassForm.php";
					?>
					<script>
						function clsFm () {
							var c = document.getElementById("classFm").style.display;
							if (c=="none") {
								document.getElementById("classFm").style.display = "block";
							}
							else {
								document.getElementById("classFm").style.display = "none";
							}
						}
					</script>
				</div>
			</div>
			<?php include $_SERVER['DOCUMENT_ROOT']."/Forms/userTeacherForm.php"; ?>
		</div>
			<!-- <div style="padding: 3px; border: 1px solid #413949; border-radius: 5px;"> -->
			<!-- </div> -->
			<div id="bottom">
			<?php include "../Components/bottom.php"; ?>
		</div>
		</div>

	</body>
</html>
