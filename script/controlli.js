function validazioneInput()
{
    var maggiorenne = document.getElementById('date').value;
	if(calculate_age(new Date(maggiorenne)))
	{
		return true;
	}
	else
	{
		alert('Per poterti iscrivere a questo servizio devi avere più di 18 anni');
		return false;
	}
}

function calculate_age(dob) { 
	var diff = Date.now() - dob.getTime();
	var age = new Date(diff); 
	var maggiorenne = Math.abs(age.getUTCFullYear() - 1970);
	if(maggiorenne>=18)
	{
		return true;
	}
	else
	{
		return false;
	}
}
function controllaPosizioni()
{    
	var x = document.getElementsByName("cavalli[]"); 
	var y = x;
	var uguali = false;
	
	for(i=0;i<x.length;i++)
	{                
		for(j=0;j<x.length;j++)
		{
			if(x[i].value==x[j].value && x[i].value!="" && x[j].value!="" && i!=j)
			{
				uguali = true;
			}
		}
	}       
	document.getElementById('submit-button').disabled=uguali;
}

function impostaData()
{
	var date = new Date();
	var currentDate = date.toISOString().slice(0,10);
	
	var ora = date.getHours();
	var minuti = date.getMinutes();
	if (date.getHours() < 10) {
		ora = "0" + ora;
	}
	if (date.getMinutes() < 10) {
		minuti = "0" + minuti;
	}
	var currentTime = ora + ':' + minuti;
	
	var min = "08:00:00";
	if(currentTime>min)
	{
		min=currentTime;
	}
	
	document.getElementById('date').setAttribute("min", currentDate);
	document.getElementById('date').setAttribute("value", currentDate);
	document.getElementById('time').setAttribute("value", currentTime);
	document.getElementById('time').setAttribute("min", min);
}

function controllaNumeroCavalli()
{
	var x = document.getElementsByName("cavalli[]");
	var i;
	var tot=0;
	for (i = 0; i < x.length; i++) {
		if(x[i].checked==true && x[i].type=="checkbox")   
		{
			tot++;
		}           
	}
	var submitButton = document.getElementById('submit-button');
	if(tot>=4 && tot<=8)
	{
		submitButton.disabled = false;
		submitButton.value = "Inserisci la gara";
	}
	else
	{
		submitButton.disabled = true;
		submitButton.value = "Inserisci la gara (disabilitato)";
	}
}