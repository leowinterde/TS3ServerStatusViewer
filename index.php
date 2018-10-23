<html>
<head>
<!-- https://github.com/LeoWinterDE/TS3SSV -->
<title>TeamSpeak Server Status Viewer</title>
<link rel="stylesheet" type="text/css" href="/ts3ssv.css" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<script type="text/javascript" src="/ts3ssv.js"></script>
</head>
<body>
<?php
require_once("ts3ssv.php");
$ts3ssv = new ts3ssv("s1.ts.5g5.net", 10011);
$ts3ssv->useServerPort(9987);
$ts3ssv->imagePath = "/img/default/";
$ts3ssv->timeout = 2;
$ts3ssv->setCache(180);
$ts3ssv->hideEmptyChannels = false;
$ts3ssv->hideParentChannels = false;
$ts3ssv->showNicknameBox = true;
$ts3ssv->showPasswordBox = false;
echo $ts3ssv->render();
?>
</body>
</html>
