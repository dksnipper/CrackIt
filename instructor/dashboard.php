<?php 
  session_start(); 

  if (!isset($_SESSION['username'])) {
	$_SESSION['username'] = $username;
	$_SESSION['msg'] = "You must log in first";
  	header('location: ../student/dashboard.php');
  }
  if (isset($_GET['logout'])) {
  	unset($_SESSION['username']);
	session_destroy();  	
  	header("location: ../registration/login.php");
  }
?>

<?php
    // initialize errors variable
	$errors = "";

	// connect to database
	$db = mysqli_connect("localhost", "root", "", "database");
	
	// insert a quote if submit button is clicked
	if (isset($_POST['submit'])) {
		if (empty($_POST['task'])) {
			$errors = "You must fill in the task";
		}else{
			$task = $_POST['task'];
			$sql = "INSERT INTO tasks (task) VALUES ('$task')";
			mysqli_query($db, $sql);
			header('location: dashboard.php');
		}
	}

	// ...
	if (isset($_GET['del_task'])) {
	$id = $_GET['del_task'];

	mysqli_query($db, "DELETE FROM tasks WHERE id=".$id);
	header('location: dashboard.php');
}
?>

<!DOCTYPE html>

<html lang="en" dir="ltr">
	
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<title> Instructor | Dashboard </title>
		
		<link rel="icon" href="../images/icon.png"> 
		
		<link rel="stylesheet" href="dashboard.css">
		<link 
			rel="stylesheet" 
			href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
		
		<script 
			src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" 
			charset="utf-8"> 
		</script>
	</head>
  
	<body>
		<input type="checkbox" id="check">
	
		<!--header area start-->
		<header>		
			<div class="left_area">
				<h3>Crack<span>It</span></h3>
			</div>
      
			<div class="right_area">
				<a href="="../student/login.php" class="logout_btn"> LogOut </a>
			</div>
		</header>
		<!--header area end-->
	
		<!--sidebar start-->
		<div class="sidebar">
			<div class="profile_info">
				<img src="../images/profile_pic.jpg" class="profile_image" alt="Profile Pic">
				<?php  if (isset($_SESSION['username'])) : ?>
					<p>
						Welcome <strong>
									<?php echo $_SESSION['username']; ?>
								</strong>
					</p>
				<?php endif ?>
			</div>
      
			<a href="dashboard.php"> 
					<i class="fas fa-desktop"> </i> 
					<span> Home </span> 
			</a>
				
			<a href="add_course.php"> 
				<i class="fa fa-plus"> </i> 
				<span> Add New Course </span>
			</a>
			
			<a href="add_note.php"> 
				<i class="far fa-sticky-note"> </i> 
				<span> Add Note </span> 
			</a>
			
			<a href="../student/dashboard.php"> 
				<i class="fas fa-user-alt"> </i> 
				<span> Switch to Student Mode </span> 
			</a>
		</div>
		<!--sidebar end-->

		<!-- Content to display -->
		<div class="content">
			<table>
				<thead>
					<tr>
						<th> Task No. </th>
						<th> Task Discription </th>
						<th style="width: 60px;"> Task Completed </th>
					</tr>
				</thead>

				<tbody>
					<?php 
						// select all tasks if page is visited or refreshed
						$tasks = mysqli_query($db, "SELECT * FROM tasks");
						$i = 1; 
						while ($row = mysqli_fetch_array($tasks)) { ?>
							<tr>
								<td> <?php echo $i; ?> </td>
								<td class="task"> <?php echo $row['task']; ?> </td>
								<td class="delete"> 
									<a href="dashboard.php?del_task=<?php echo $row['id'] ?>">x</a> 
								</td>
							</tr>
					<?php $i++; } ?>	
				</tbody>
			</table>
		</div>
		<!-- Content to display -->
		
		<script>
			/* Loop through all dropdown buttons to toggle between hiding and showing its 
			dropdown content - This allows the user to have multiple dropdowns without any conflict */
			var dropdown = document.getElementsByClassName("dropdown-btn");
			var i;
			for (i = 0; i < dropdown.length; i++) {
				dropdown[i].addEventListener("click", function() {
					this.classList.toggle("active");
					var dropdownContent = this.nextElementSibling;
					if (dropdownContent.style.display === "block") {
						dropdownContent.style.display = "none";
					} 
					else {
						dropdownContent.style.display = "block";
					}
				});
			}
		</script>

	</body>
</html>