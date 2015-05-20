<?php
/** https://github.com/LeoWinterDE/TS3ServerStatusViewer **/

// To enable the setup script you have to edit THIS! And replace "$enableGenerator = false;" to "$enableGenerator = true;".
$enableGenerator = false;
// $enableGenerator = true;


$absoluteDir = dirname(__FILE__) . "/";
$wwwDir = substr($_SERVER["SCRIPT_NAME"], 0, strrpos($_SERVER["SCRIPT_NAME"], "/") + 1);


$host = isset($_POST["host"]) ? $_POST["host"] : "";
$qport = isset($_POST["qport"]) ? intval($_POST["qport"]) : 10011;
$portOrId = isset($_POST["portOrId"]) ? intval($_POST["portOrId"]) : 1;
$port = isset($_POST["port"]) ? intval($_POST["port"]) : 9987;
$sid = isset($_POST["sid"]) ? intval($_POST["sid"]) : 1;
$showNicknameBox = !isset($_POST["showNicknameBox"]);
$timeout = isset($_POST["timeout"]) ? intval($_POST["timeout"]) : 2;
$showPasswordBox = !isset($_POST["showPasswordBox"]);
$serverQueryLogin = isset($_POST["serverQueryLogin"]) ? $_POST["serverQueryLogin"] : "";
$serverQueryPassword = isset($_POST["serverQueryPassword"]) ? $_POST["serverQueryPassword"] : "";
$cacheTime = isset($_POST["cacheTime"]) ? intval($_POST["cacheTime"]) : 0;
$cacheFile = isset($_POST["cacheFile"]) ? $_POST["cacheFile"] : "";
$limitToChannels = isset($_POST["limitToChannels"]) ? $_POST["limitToChannels"] : "";
$hideEmptyChannels = !isset($_POST["hideEmptyChannels"]);
$hideParentChannels = !isset($_POST["hideParentChannels"]);


if($timeout < 1) $timeout = 0;
else if($timeout > 10) $timeout = 10;

$htmlCode = '<link rel="stylesheet" type="text/css" href="' . $wwwDir . 'ts3ssv.css" />
<script type="text/javascript" src="' . $wwwDir . 'ts3ssv.js"></script>';
echo $htmlCode;

$phpCode = "<?php\n";
$phpCode .= 'require_once("' . $absoluteDir . 'ts3ssv.php");' . "\n";
$phpCode .= '$ts3ssv = new ts3ssv("' . $host . '", ' . $qport . ');' . "\n";
if($portOrId == 1) $phpCode .= '$ts3ssv->useServerPort(' . $port . ');' . "\n";
if($portOrId == 2) $phpCode .= '$ts3ssv->useServerId(' . $sid . ');' . "\n";
$phpCode .= '$ts3ssv->imagePath = "' . $wwwDir . 'img/default/";' . "\n";
$phpCode .= '$ts3ssv->timeout = ' . $timeout . ";\n";
if($serverQueryLogin != "") $phpCode .= '$ts3ssv->setLoginPassword("'.$serverQueryLogin.'", "'.$serverQueryPassword.'");' . "\n";
if($cacheTime > 0 && $cacheFile == "") $phpCode .= '$ts3ssv->setCache('.$cacheTime.');' . "\n";
if($cacheTime > 0 && $cacheFile != "") $phpCode .= '$ts3ssv->setCache('.$cacheTime.', "'.$cacheFile.'");' . "\n";
if($limitToChannels != "") $phpCode .= '$ts3ssv->limitToChannels('.$limitToChannels.');' . "\n";
$phpCode .= '$ts3ssv->hideEmptyChannels = ' . (!$hideEmptyChannels ? "true" : "false") . ";\n";
$phpCode .= '$ts3ssv->hideParentChannels = ' . (!$hideParentChannels ? "true" : "false") . ";\n";
$phpCode .= '$ts3ssv->showNicknameBox = ' . ($showNicknameBox ? "true" : "false") . ";\n";
$phpCode .= '$ts3ssv->showPasswordBox = ' . ($showPasswordBox ? "false" : "true") . ";\n";
$phpCode .= 'echo $ts3ssv->render();' . "\n?>";

?>
<html>
<head>
<title>START SETUP - <a href="https://github.com/LeoWinterDE/TS3SSV">TeamSpeak Server Status Viewer</a></title>
<style type="text/css">
body, table{
	font-family: Verdana;
	font-size: 12px;
}
th{
	text-align: right;
}
td{
	font-style: italic;
}
label{
	font-style: normal;
}
h3{
	font-size: 14px;
	padding-bottom: 4px;
	border-bottom: 1px solid #aaa;
}
.warning{
	color: red;
}
</style>
</head>
<body>
<h3>START SETUP - TeamSpeak Server Status Viewer</h3>

<?php
if($enableGenerator)
{
	if($host != "")
	{
		echo "<h3>TS3SSV Result</h3>\n";

		require_once($absoluteDir . "ts3ssv.php");
		$ts3ssv = new ts3ssv($host, $qport);
		$ts3ssv->imagePath  = $wwwDir . "img/default/";
		if($portOrId == 1) $ts3ssv->useServerPort($port);
		if($portOrId == 2) $ts3ssv->useServerId($sid);
		$ts3ssv->timeout = $timeout;
		if($serverQueryLogin != "") $ts3ssv->setLoginPassword($serverQueryLogin, $serverQueryPassword);
		if($cacheTime > 0 && $cacheFile == "") $ts3ssv->setCache($cacheTime);
		if($cacheTime > 0 && $cacheFile != "") $ts3ssv->setCache($cacheTime, $cacheFile);
		if($limitToChannels != "")
		{
			$ids = explode(",", $limitToChannels);
			call_user_func_array(array($ts3ssv, "limitToChannels"), $ids);
		}
		$ts3ssv->hideEmptyChannels = !$hideEmptyChannels;
		$ts3ssv->hideParentChannels = !$hideParentChannels;
		$ts3ssv->showNicknameBox = $showNicknameBox;
		$ts3ssv->showPasswordBox = !$showPasswordBox;
		echo $ts3ssv->render();

		echo "<h3>HTML code</h3>\n";
		highlight_string($htmlCode);
		echo "<h3>PHP code</h3>\n";
		highlight_string($phpCode);
		echo "<h3>Full page sample</h3>\n";
		highlight_string("<html>\n<head>\n<title>ts3ssv</title>\n$htmlCode\n</head>\n<body>\n$phpCode\n</body>\n</html>");

		echo '<br /><br /><br /><div class="warning">Don\'t forget to disable this script once finished testing!</div>';
	}
}
else
{
	echo '
	<div class="warning">
		This script is disabled by default for security purposes!<br />
		To enable the setup script you have to edit <strong>setup.php</strong> and replace <strong>$enableGenerator = false;</strong> to <strong>$enableGenerator = true;</strong> on line 5!<br />
		<strong>Don\'t forget to disable this script once finished testing!</strong>
	</div>';
}
?>

<form action="" method="post">
<table>
	<tr>
		<th>Host IP</th>
		<td><input type="text" name="host" value="<?php echo htmlentities($host); ?>" /></td>
		<td>Your TeamSpeak Server hostname or ip.</td>
	</tr>
	<tr>
		<th>Query Port</th>
		<td><input type="text" name="qport" value="<?php echo $qport; ?>" /></td>
		<td>Server's query port, not the client port! (default 10011)</td>
	</tr>
	<tr>
		<th>Server Port</th>
		<td>
			<input type="radio" name="portOrId" value="1" <?php if($portOrId == 1) echo "checked"; ?> />
			<input type="text" name="port" value="<?php echo $port; ?>" />
		</td>
		<td>You must define a server port or a server id to connect.</td>
	</tr>
	<tr>
		<th>Server ID</th>
		<td>
			<input type="radio" name="portOrId" value="2" <?php if($portOrId == 2) echo "checked"; ?> />
			<input type="text" name="sid" value="<?php echo $sid; ?>" />
		</td>
	</tr>
	<tr>
		<th>Timeout</th>
		<td><input type="text" name="timeout" value="<?php echo $timeout; ?>" /></td>
		<td>The timeout, in seconds, for connect, read, write operations.</td>
	</tr>
	<tr>
		<th>ServerQuery Login</th>
		<td><input type="text" name="serverQueryLogin" value="<?php echo $serverQueryLogin; ?>" /></td>
		<td>[Optional] The ServerQuery login used by TS3SSV.</td>
	</tr>
	<tr>
		<th>ServerQuery password</th>
		<td><input type="text" name="serverQueryPassword" value="<?php echo $serverQueryPassword; ?>" /></td>
		<td>[Optional] The ServerQuery password used by TS3SSV.</td>
	</tr>
	<tr>
		<th>Cache Time</th>
		<td><input type="text" name="cacheTime" value="<?php echo $cacheTime; ?>" /></td>
		<td>
			[Optional] Cache datas for X seconds before updating (prevent bans from the server). 0 =&gt; disabled
		</td>
	</tr>
	<tr>
		<th>Cache File</th>
		<td><input type="text" name="cacheFile" value="<?php echo $cacheFile; ?>" /></td>
		<td>
			[Optional] The file were the cache file will be saved. (.../ts3ssv/ts3ssv.php.cache if not specified)
		</td>
	</tr>
	<tr>
		<th>Limit to these Channels</th>
		<td><input type="text" name="limitToChannels" value="<?php echo $limitToChannels; ?>" /></td>
		<td>
			[Optional] Comma seperated list of channels ID to display. If set TS3SSV will only list these channels.
		</td>
	</tr>
	<tr>
		<th></th>
		<td><label><input type="checkbox" name="hideEmptyChannels" <?php echo (!$hideEmptyChannels ? "checked" : "") ?> /> Hide empty channels.</label></td>
		<td></td>
	</tr>
	<tr>
		<th></th>
		<td><label><input type="checkbox" name="hideParentChannels" <?php echo (!$hideParentChannels ? "checked" : "") ?> /> Hide parents channels.</label></td>
		<td>To use with "Limit to these channels" and "Hide empty channels" options.</td>
	</tr>
	<tr>
		<th></th>
		<td><label><input type="checkbox" name="showNicknameBox" <?php echo (!$showNicknameBox ? "checked" : "") ?> /> Hide nickname box.</label></td>
		<td></td>
	</tr>
	<tr>
		<th></th>
		<td><label><input type="checkbox" name="showPasswordBox" <?php echo (!$showPasswordBox ? "checked" : "") ?> /> Show password box.</label></td>
		<td>The box will only be visible if the the server have a password.</td>
	</tr>
	<?php if ($enableGenerator):?>
	<tr>
		<td colspan="3" style="text-align: center"><input type="submit" value="Test TS3SSV!" /></td>
	</tr>
	<?php endif;?>
</table>
</form>

</body>
</html>
