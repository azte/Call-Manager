var subtipo_4=new Array("-","Promociones","Extension","Error Operativo","Consityf","Recibo","Internet Explorer","Corte","IDI","Arqueo","Inc. Gral. Recibo","Inc. Gral. Recargas","Inc Gral. J&P","TDC/TDD","Venezia POS","SIPOS","IVA","Hoja de Costeo","Orden de Surtimiento","Otros")



	function cambia_subtipo()
		{


			var tipollamada; //Obteniendo el valor del Select
			tipollamada=document.captura.tipo[document.captura.tipo.selectedIndex].value;
				if(tipollamada=="Informes")

					{
						//Si el valor existe y es igual a 4 se ejecuta lo siguiente
						mis_tipos=subtipo_4 //Obtiene el arreglo con los subtipos
						num_tipos = mis_tipos.length //Mide la longitud del arreglo subtipo_4
						document.captura.subtipo.length=num_tipos //Asignamos el numero de subtipos que contiene el select

							for(i=0;i<num_tipos;i++)
								{

							/* Por cada subtipo de llamada que existe, el ciclo va crear un option dentro
							del select SUBTIPO que creamos*/

									document.captura.subtipo.options[i].value=mis_tipos[i]
									document.captura.subtipo.options[i].text=mis_tipos[i]

								}

					}
					else //Si la variable tipollamada no es 4, va escribir que no existen subtipos
							{
									document.captura.subtipo.length=1
									document.captura.subtipo.options[0].value="0"
									document.captura.subtipo.options[0].text="Sin Subtipo"
							}




				document.captura.subtipo.options[0].selected= true	

				
		}


