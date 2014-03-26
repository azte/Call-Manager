			function valida(){

		user=document.getElementById("usuario").value;
		tienda = document.getElementById("tienda").value;

		if(user==null || user==""){
		
		alert("Hey pon atenci\u00F3n, escribe un usuario");
		return false;
	}

		if( isNaN(tienda) || tienda=="" || tienda.length>3) {
			alert("Hey, escribe una tienda que exista");	
  		return false;
		}

		tipo = document.getElementById("tipo").selectedIndex;
		if( tipo == null || tipo == 0 ) {
  		
  		alert("Selecciona un tipo de llamada");	

  	return false;
}

	
 

	
}
