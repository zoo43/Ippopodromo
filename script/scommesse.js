function checkDoc()
{
    if(checkBitScuits() && checkRadio())
    {
		return true;
	}
    else 
	{
		return false;
	}
}

function checkRadio()
{
	var radios = document.getElementsByTagName('input');
	var value;
	for (var i = 0; i < radios.length; i++) {
		if (radios[i].type === 'radio' && radios[i].checked)
		{
			document.getElementById("errorRadio").hidden=true;
            return true;
		}
	}
	document.getElementById("errorRadio").hidden=false;
	return false;
}

function checkBitScuits()
{
	var n = document.getElementsByTagName('input');
	var bitScuits = document.getElementById('creditoUtente').innerText;
	bitScuits = parseInt(bitScuits, 10);
    var value;
	for (var i = 0; i < n.length; i++) {
		if (n[i].type === 'number')
		{
			if(n[i].value <= bitScuits)
			{
				document.getElementById("errorBitScuit").hidden=true;
				return true;
			}
			else
			{
				document.getElementById("errorBitScuit").hidden=false;
				return false;
			}
		}
	}
	alert('Qualcosa è andato storto');
	return false;
}
