<?php
	session_start();
	include $_SERVER['DOCUMENT_ROOT']."/basecode-create_connection.php";
	include $_SERVER['DOCUMENT_ROOT']."/Scripts/php/allRetrievalQueries.php";
	$loggedInUserName = $_SESSION['user'];
	$pageCode = "A";
	$loggedInUserName  = $_SESSION['user'];
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<?php include $_SERVER['DOCUMENT_ROOT']."/Components/PageComponents/header.php"; ?>
	<body class="body">
		<div class="container">
			<?php
				include $_SERVER['DOCUMENT_ROOT']."/Components/LoginComponents/logintimebtn.php" ;
			?>
			<?php
				include $_SERVER['DOCUMENT_ROOT']."/Components/LoginComponents/loggedtop.php";
			?>
			<?php
				include $_SERVER['DOCUMENT_ROOT']."/Components/Components/NavBarComponents/adminNavBar.php";
			?>
				<div>
					<?php
						classesTaughtByTeachers($mysqli);
					?>
				</div>
		</div>
		<div class="container" id="bottom"><?php include "../Components/PageComponents/bottom.php"; ?></div>
	</body>
</html>
