// https://github.com/LeoWinterDE/TS3ServerStatusViewer

function ts3ssvconnect(id, channel)
{
	var id = "ts3ssv-" + id;
	var hostport = document.getElementById(id + "-hostport").value;
	var nickname = document.getElementById(id + "-nickname");
	var password = document.getElementById(id + "-password");
	var command = "ts3server://" + hostport.replace(":", "?port=");
	var dateExpire = new Date;

	dateExpire.setMonth(dateExpire.getMonth()+1);

	if(channel != null){
		command += "&cid=" + channel;
	}

	if(nickname != null && nickname.value != ""){
		command += "&nickname=" + escape(nickname.value);
		document.cookie = id + "-nickname=" + escape(nickname.value) + "; expires=" + dateExpire.toGMTString();
	}

	if(password != null && password.value != ""){
		command += "&password=" + escape(password.value);
		document.cookie = id + "-password=" + escape(password.value) + "; expires=" + dateExpire.toGMTString();
	}
	(window.open(command)).close();
}
