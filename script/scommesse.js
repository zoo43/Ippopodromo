function checkDoc()
{
    if(checkBitSquits() && checkRadio())
    {
		return true;
	}
    else 
	{
		return false;
	}
}

function checkBitSquits()
{
	var n = document.getElementsByTagName('input');
	var bitScuits = document.getElementById('creditoUtente').innerText;
	bitScuits = parseInt(bitScuits);
    var value;
	for (var i = 0; i < n.length; i++) {
		if (n[i].type === 'number')
		{
			if(n[i].value <= bitScuits)
			return true;
			else
			{
				alert('Non hai abbastanza bitSquits :(. Si prega di inserire un importo valido');
				return false;
			}
		}
	}
	alert('Qualcosa è andato storto :(');
	return false;
}

function checkRadio()
{
	var radios = document.getElementsByTagName('input');
	var value;
	for (var i = 0; i < radios.length; i++) {
		if (radios[i].type === 'radio' && radios[i].checked)
		{
            return true;
		}
	}
	alert('Non è stato selezionato nessun cavallo su cui scommettere');
	return false;
}