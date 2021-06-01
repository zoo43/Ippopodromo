function checkRadio()
{
	var radios = document.getElementsByTagName('input');
	var value;
	for (var i = 0; i < radios.length; i++) {
		if (radios[i].type === 'radio' && radios[i].checked)
		{
			document.getElementById("error").hidden=false;
            return true;
		}
	}
	document.getElementById("error").hidden=true;
	return false;
}