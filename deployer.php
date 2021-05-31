<?php 
date_default_timezone_set("Asia/Manila");
error_reporting(E_ALL^E_NOTICE);
$post = $_REQUEST['post'];
$gitusername = $_REQUEST['username'];
$gitpassword = $_REQUEST['password'];


/*************************** CONFIGURATION HERE *****************************/

$githubrepo = "github.com/NMGResources-Inc/deloitte-backend.git";
$branch = "master";

/****************************************************************************/

function runCommand($command){
	global $gitusername, $gitpassword, $db;
	$pull = false;
	if(strpos($command, "git pull")!==false){
		$commandp = str_replace(":".urlencode($gitpassword)."@", ":".str_repeat("*", strlen($gitpassword))."@", $command);
		echo "<b>".$commandp."</b>\n";
		$pull = true;
	}
	else{
		echo "<b>".$command."</b>\n";
	}
	$out = shell_exec($command." 2>&1");
	//to hide the password
	$out = str_replace(":".urlencode($gitpassword)."@", ":".str_repeat("*", strlen($gitpassword))."@", $out);
	echo $out;
	echo "\n";
	//if command is pull then run migrate
	if($pull){
		echo "<b>Run Migrate</b>\n";
		echo $_SERVER['REQUEST_SCHEME']."://".$_SERVER['SERVER_NAME']."/migrate";
		echo " ... ";
		echo file_get_contents($_SERVER['REQUEST_SCHEME']."://".$_SERVER['SERVER_NAME']."/migrate")."\n\n";
	}
}
?>

<?php
if($post){
	?>
	<style>
	body{
		background:black;
	}
	*{
		color:white;
		font-family:courier;
		font-size:12px;
	}
	b{
		color: green;
	}
	</style>
	<?php
	echo "<pre>";
	runCommand("hostname");
	runCommand("echo \$PWD/");
	if(trim($gitusername)&&trim($gitpassword)){
		runCommand("cd \$PWD/ && git reset --hard");
		runCommand("cd \$PWD/ && git pull https://".urlencode($gitusername).":".urlencode($gitpassword)."@".$githubrepo." ".$branch);
	}
	echo "</pre>";
	exit();
}
?>
<style>
input{
	border:1px solid black;
	padding:10px;
}
*{
	color:black;
	font-family:verdana;
	font-size:12px;
}
</style>
<center>
<form method="post" target="hiframe">
	<input type="hidden" name="post" value="1">
	<table>
	<tr><td style="text-align:center; padding:10px;">
	</td></tr>
	<tr><td><input type="text" name="username" placeholder="git username" value="<?php echo htmlentities($gitusername); ?>"></td></tr>
	<tr><td><input type="password" name="password" placeholder="git password"></td></tr>
	<tr><td style="text-align:center"><input type="submit" value="Deploy"></td></tr>
	</table>
</form>
<iframe name="hiframe" style="width:600px; height:400px" src="deployer.php?post=1">
</iframe>
</center>