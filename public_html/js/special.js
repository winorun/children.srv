	function setFontSize(fontSize) {
		setCookie("fontSize", fontSize);
		var color = getCookie('color');
		if(color!="undefined") document.getElementById("wrapper").className = (color + ' ' +fontSize);
		else document.getElementById("wrapper").className = fontSize;
	}

	function setColorSite(color) {
		document.getElementById("wrapper").className = color;
		setCookie("color", color);
		var fontSize = getCookie('fontSize');
		if(fontSize!="undefined") document.getElementById("wrapper").className = (color + ' ' +fontSize);
		else document.getElementById("wrapper").className = color;
	}

	// возвращает cookie с именем name, если есть, если нет, то undefined
	function getCookie(name) {
	  var matches = document.cookie.match(new RegExp(
	    "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
	  ));
	  return matches ? decodeURIComponent(matches[1]).split(' ',1)[0] : undefined;
	}

	function setCookie(name, value) {
	  var updatedCookie = name + "=" + value;
      updatedCookie += "; path=/;";
	  document.cookie = updatedCookie;
	}

	window.onload=function(){
		var color = getCookie('color');
		var fontSize = getCookie('fontSize');
		if(fontSize!="undefined")
			if(color!="undefined")document.getElementById("wrapper").className = (color + ' ' +fontSize);
			else document.getElementById("wrapper").className = fontSize;
		else if(color!="undefined") document.getElementById("wrapper").className = color;
	}