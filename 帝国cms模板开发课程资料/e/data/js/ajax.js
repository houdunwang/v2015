var http_request = false;
function makeRequest(url, functionName, httpType, sendData) {

	http_request = false;
	if (!httpType) httpType = "GET";

	if (window.XMLHttpRequest) { // Non-IE...
		http_request = new XMLHttpRequest();
		if (http_request.overrideMimeType) {
			http_request.overrideMimeType('text/plain');
		}
	} else if (window.ActiveXObject) { // IE
		try {
			http_request = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try {
				http_request = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e) {}
		}
	}

	if (!http_request) {
		alert('Cannot send an XMLHTTP request');
		return false;
	}

	var changefunc="http_request.onreadystatechange = "+functionName;
	eval (changefunc);
	//http_request.onreadystatechange = alertContents;
	http_request.open(httpType, url, true);
	http_request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	http_request.send(sendData);
}

function getReturnedText () {
	if (http_request.readyState == 4) {
		if (http_request.status == 200) {
			var messagereturn = http_request.responseText;
			return messagereturn;
		} else {
			alert('There was a problem with the request.');
		}
	}
}

function EchoReturnedText () {
	if (http_request.readyState == 4) {
		if (http_request.status == 200) {
			var messagereturn = http_request.responseText;
			if(messagereturn!='isfail')
			{
				var r;
				r=messagereturn.split('|');
				if(r.length!=1)
				{
					if(r[0]!='')
					{
						document.getElementById(r[1]).innerHTML=r[0];
					}
					if(r[2]!='')
					{
						alert(r[2]);
					}
				}
				else
				{
					document.getElementById('ajaxarea').innerHTML=messagereturn;
				}
			}
		} else {
			alert('There was a problem with the request.');
		}
	}
}