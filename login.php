<?php  
	$title="Login";
	include("incl/header.php");
	
?>
					<div id="content">
					
						<h1><?php echo($title); ?></h1>
						<hr />
						
						<?php ?>
						
						<fieldset>
						  <legend>Type username and password</legend>
						   <form action="login.php" method="post" name="frmLogin" >
								<label>
									Name
									<br />
									<input type="text" name="txtUserName" id="txtUserName" title="Username" placeholder="Type your username!" autofocus="autofocus" required="required" />
								</label>
								<br />
								<label>
									Password
									<br />
									<input type="password" name="txtPassWord" id="txtPassWord" title="Password" placeholder="Type your Password!" required="required" />
								</label>
								<br />
								<input type="submit" name="btnLogin" id="btnLogin" value="Login" />
								<input type="reset" name="btnReset" id="btnReset" value="Reset" />
						  </form>
						</fieldset>
					</div>

<?php include("incl/footer.php");