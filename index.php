<?php
#################################################################
##  Database Installer          							   ##
##-------------------------------------------------------------##
##  Version: 1.00                                              ##
##-------------------------------------------------------------##
##  Author: Nishant Kumar									   ##
##-------------------------------------------------------------##
##  Copyright ©2015 . All rights reserved.	                   ##
##-------------------------------------------------------------##
#################################################################

ini_set('max_execution_time', 0); 
?>
<html>
	<head>
		<title>Database Installer</title>
		<script type="text/javascript" src="jquery-2.1.3.min.js" language="javascript"></script>
		<script>
		function check_db(x , e){
			e.preventDefault();
			var hostname = document.forms["db_install"]["db_host"].value;  
			var dbname = document.forms["db_install"]["db_name"].value;  
			var dbusername = document.forms["db_install"]["db_username"].value;  
			if (hostname == "" || hostname == null)  
				{  
					jQuery('#db_host').css('border','1px solid #FF0000');
					return false;
				}
			else if (dbname == "" || dbname == null)  
				{  
					jQuery('#db_name').css('border','1px solid #FF0000');
					return false;
				}
			else if (dbusername == "" || dbusername == null)  
				{  
					jQuery('#db_username').css('border','1px solid #FF0000');
					return false;
				}
			else {
					jQuery('#db_install').submit();
					return true;
				}
			
		} 
		
		jQuery(document).ready(function(){
				jQuery('.db_field').mouseover(function(){
						jQuery(this).css('border','1px solid #666');
					});
			});
			
		//ajax call for drop table	
		function drop_db() {
			 var checkboxChecked = $('input[name="drop_chk"]:checked').length ;
			 if(checkboxChecked > 0){
				 jQuery('#chk-label').hide();
				 jQuery('.img-loader').show();
				 jQuery.ajax
					({ 
						url: 'install.php',
						data: {action: 'drop'},
						type: 'post',
						success: function(response) {
									  jQuery('#show_drop_action td').html(response);
									  jQuery('.drop_info').hide();
									  jQuery('.img-loader').hide();
								  }
					});
			 }
			 else {
				 jQuery('#chk-label').show();
			}
		}
		</script>
		
		<style>
			body{
				font-family: serif;
			}
			#db_submit{
				background: none repeat scroll 0 0 #ccc;
				font-weight: bold;
				height: 30px;
				width: 70px;
				float: right;
			}
			.drop-table{
				background: none repeat scroll 0 0 #ccc;
				font-weight: bold;
				height: 30px;
				width: 60px;
			}
			#db_host, #db_name, #db_username, #db_password {
				border: 1px solid #666;
				height: 25px;
				width: 100%;
				padding: 0 5px;
			}			
			.th-head {
				background: none repeat scroll 0 0 #333;
				color: #fff;
				font-size: 17px;
			}
			#db_install table tr td {
				font-size: 15px;
				background: #ccc;
			}
			.td-left {
				padding-left: 5px;
			}
			#chk-box {
				margin:0px;
			}
			.img-loader {
			    display: inline-block;
				height: 20px;
				left: 10px;
				position: relative;
				top: 5px;
			}
			#chk-label {
				margin-left: 7px;
			}
			
		</style>
	</head>
	<body>
	<?php
		session_start();
		function Delete_tables(){
			$conn = mysqli_connect($_SESSION['hostname'], $_SESSION['dbusername'], $_SESSION['dbpassword'], $_SESSION['dbname']);
			
			$result = mysqli_query($conn, "show tables"); 
			while($table = mysqli_fetch_array($result, MYSQLI_BOTH)) { 
				//echo "<tr><td>".$table[0] . "</td></tr>";				
				$drop_tab = mysqli_query($conn , 'DROP TABLE IF EXISTS `'.$_SESSION['dbname'].'`.`'.$table[0].'`');
			}
			if($drop_tab) {
					//return "<p class='drop-noti'>Tables droped successfully</p><script>jQuery(document).ready(function(){jQuery('.drop-noti').fadeOut(5000);window.location = location.href; });</script>";
					return "<p class='drop-noti'>Tables droped successfully</p><script>jQuery(document).ready(function(){setTimeout(function(){jQuery('.drop-noti').fadeOut(function() {window.location = window.location.href; });}, 5000);});</script>";
						
				}
				else {
					return mysqli_error($conn);	
				}
		}
		if(isset($_POST['action']) && !empty($_POST['action'])) {
			$action = $_POST['action'];
			switch($action) {
				case 'drop' : $result = Delete_tables();break;
				case 'test' : test();break;
			}
			echo $result; die;
		}		
		?>
		<form name="db_install" id="db_install" method="post">
			<?php  //session_start();?>
			<table style="margin: 0px auto; width: 50%;" cellpadding="2" >				
					<tr style="height: 35px;">
						<th colspan="2" align="center" class="th-head">Database Installer</th>
					</tr>
					<tr>
						<td class="td-left">Database Hostname:</td>
						<td style="width:50%">
							<input type="text" class="db_field" name="db_host" id="db_host" value="<?php if(isset($_SESSION['hostname'])) {echo $_SESSION['hostname'];}?>" placeholder="localhost or MySQL server host name" />
						</td>
					</tr>
					<tr>
						<td class="td-left">Database Name:</td>
						<td style="width:50%">
							<input type="text" name="db_name" class="db_field" id="db_name" value="<?php if(isset($_SESSION['dbname'])){ echo $_SESSION['dbname'];}?>" placeholder="MySQL Database to install tables" />
						</td>
					</tr>
					<tr>
						<td class="td-left">Database Username:</td>
						<td style="width:50%">
							<input type="text" name="db_username" class="db_field" id="db_username" value="<?php if(isset($_SESSION['dbusername'])){ echo $_SESSION['dbusername'];}?>" placeholder="MySQL Username" />
						</td>
					</tr>
					<tr>
						<td class="td-left">Database Password:</td>
						<td style="width:50%">
							<input type="text" name="db_password" class="db_field" id="db_password" value="<?php if(isset($_SESSION['dbpassword'])){ echo $_SESSION['dbpassword'];}?>" placeholder="MySQL Password" />
						</td>
					</tr>
					<tr>
						<td colspan="2" style="background:none;">
							<input onclick="return check_db(this, event)" type="submit"  id="db_submit" class="db_submit" value="Install" />
							<input  type="hidden" name="db_submit" class="db_submit" value="Install" />
						</td>
					</tr>
					<tr class="overlay-message" style="display:none;">
						<td colspan="2" align="right"> 
						<span style="display: inline-block; position: relative; bottom: 8px; left: 5px;">Please wait database installation is being processing.</span> 
						</td>
					</tr>			
			</table>
		</form>
		<table style="margin: 0px auto; width: 50%;color:#ff0000">	
			<tr id="show_drop_action"><td> </td></tr>
			<?php			
			// Name of the sql file
			$filename = 'mysql.sql';
			
			if(isset($_POST['db_submit'])){
				$dbhost = check_data($_POST["db_host"]);
				$dbname = check_data($_POST["db_name"]);
				$dbusername = check_data($_POST["db_username"]);
				$dbpassword = check_data($_POST["db_password"]);
				
				if($dbhost == ''){
					echo "<tr><td>"."Please Enter Hostname"."</td></tr>" ;
				}
				elseif($dbname == ''){
					echo "<tr><td>"."Please Enter Database Name"."</td></tr>" ;
				}
				elseif($dbusername == ''){
					echo "<tr><td>"."Please Enter Database Username"."</td></tr>" ;
				}
				else {					
					// Connect to MySQL server
					$connect =  mysqli_connect($dbhost, $dbusername, $dbpassword, $dbname);
					if(!$connect){
					    echo '<tr><td>'.'Error connecting to MySQL server: ' . mysqli_connect_error.'<br></td></tr>';
					}
					
					// Select database
					$result = mysqli_query($connect, "SHOW TABLE STATUS");
					$dbsize = 0;
					while($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
						$dbsize += $row["Data_length"] + $row["Index_length"];
					}
					
					if($dbsize != '' || $dbsize != null){
						//save data in session
						//session_start();
						if(!isset($_SESSION['dbname'])) {
							$_SESSION['hostname']   = $dbhost;
							$_SESSION['dbname']     = $dbname;
							$_SESSION['dbusername'] = $dbusername;
							$_SESSION['dbpassword'] = $dbpassword;
						}
						
						echo "<tr class='drop_info'><td>"."Database is not empty. Drop the tables to reinstall"."</td></tr>";
						echo "<tr class='drop_info'><td><input type='checkbox' name='drop_chk' id='chk-box' value='0' /><span style='color:#000;'> Delete the existing tables</span> <input type='button' onclick='drop_db()' class='drop-table' value='Delete' /><span style='display:none;' class='img-loader'>Please Wait...</span> <span id='chk-label' style='display:none;'>Please Check the checkbox</span></td></tr>";
					}
					else {
						if($connect) {
							
							// Temporary variable, used to store current query
							$templine = '';
							
							// Read in entire file
							$lines = file($filename);
							?>
							<script>
								jQuery('.overlay-message').show();
							</script>
							<?php
							// Loop through each line
							foreach ($lines as $line)
							{
								// Skip it if it's a comment
								if (substr($line, 0, 2) == '--' || substr($line, 0, 2) == '/*' || $line == '')
									continue;

								// Add this line to the current segment
								$templine .= $line;
								
								// If it has a semicolon at the end, it's the end of the query
								if (substr(trim($line), -1, 1) == ';')
								{
									// Perform the query
									mysqli_query($connect, $templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysqli_error($connect) . '<br /><br />');
									
									// Reset temp variable to empty
									$templine = '';
								}
							}
							if(!mysqli_error($connect)){
								echo "<tr><td>"."Tables imported successfully"."</td></tr>";
							}
							else{
								echo "<tr><td>"."Tables is not imported"."</td></tr>";
							}
							session_destroy();
							?>
							<script>
								jQuery('.overlay-message').hide();
							</script>
							<?php
						}
						else{
							echo '<tr><td>'.'Database not correct: '. mysqli_error($connect).'</td></tr>';
						}
					  }					
				}
			
			}
			if(isset($_GET['del'])) {
				//Delete_tables();
			  }
			
			function check_data($data) {
			   $data = trim($data);
			   $data = stripslashes($data);
			   $data = htmlspecialchars($data);
			   return $data;
			}			
			
		?>
		</table>
	</body>
</html>
