aCountries = [
	{
		name:"Argentina",
		iso:"AR",
		cities:[{name:"Buenos Aires"},{name:"Córdoba"},{name:"Jujuy"},{name:"Mendoza"}]
	},
	{
		name:"Chile",
		iso:"CL",
		cities:[
			{name:"Antofagasta"},{name:"Concepción"},{name:"Copiapó"},{name:"La Serena"},
			{name:"Puerto Montt"},{name:"Santiago"}
		]
	},
	{
		name:"Perú",
		iso:"PE",
		cities:[{name:"Lima"},{name:"Cuzco"},{name:"Arequipa"},{name:"Trujillo"}]
	}
];

/*
 * This funtion will add an option to the given selection type.
 */

function apendOption( oSelection, sValue, sCaption  ){

	// create the option object then set the value
	var oOption = document.createElement("option");
	oOption.setAttribute("value",sValue);
	// create the "caption" of teh object and then append it to the option object
	var oCaption = document.createTextNode( sCaption );
	oOption.appendChild(oCaption);
	oSelection.appendChild(oOption);
}

function setPaisOrigen( oCountrySelection ){

	removeSuggestion(oCountrySelection);
	var sPais = oCountrySelection.value;
	var oPaisOrigenSelection = document.getElementById('ciudad-origen');
	setCiudades( oPaisOrigenSelection, sPais );
}

function setPaisDestino( oCountrySelection ){

	removeSuggestion(oCountrySelection);
	var sPais = oCountrySelection.value;
	var oPaisDestinoSelection = document.getElementById('ciudad-destino');
	setCiudades( oPaisDestinoSelection, sPais );
}

function removeSuggestion( oSelect ){
	var oSuggestion = oSelect[0];
	if(oSuggestion.value == "" ){
		oSuggestion.remove();
	}

}

function setCiudades( oCiudadSelection, sPais ){

	for(var i= 0; i < aCountries.length ; i++){

		if(aCountries[i].name == sPais  ){
			// Reset the content of the given selection
			oCiudadSelection.innerHTML = "";
			apendOption( oCiudadSelection, "", "Seleccione una Ciudad" );
			for( var j=0 ; j < aCountries[i].cities.length ; j++ ){
				apendOption( oCiudadSelection, aCountries[i].cities[j].name, aCountries[i].cities[j].name );
			}
		}
	}
}

/*
 * Esta funcion valida inputs de formulario, corroborando que no tengan valor "" (string vacío)
 */
function testInputValue( sElementID, sErrorMessage ){
	if( document.getElementById(sElementID).value == "" ){
		alert(sErrorMessage);
		return false;
	}
	return true;
}

/*
 * Esta funcion valida fechas, retornando false si la fecha es incorrecta u el objecto date si es correcta
 */
function testDate( sDate ){

	  /*
		 * verifica que la fecha pesea el formato correcto
	   * verifica que los primeros 4 caracteres deben ser números seguidos de un "-""
	   * luego deben haver entre 1 y 2 caracteres numericos, seguidos por un "-"
	   * finalmente debe terminar entre 1 y 2 caracteres también numericos
	   */
		var regexDate = /[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}$/;

		if( !regexDate.test(sDate) ){
			return false;
		}

		// Divide the sDate sting in to an array using "-" divitions
		var aDate = sDate.split("-");

		console.log(aDate);

		// first check the length pf the array
		if( aDate.length !== 3 ){
	    console.log("mal largo");
			return false;
		}

	  // Parse the number to compare
	  aDate[0] = parseInt(aDate[0]);
	  aDate[1] = parseInt(aDate[1]);
	  aDate[2] = parseInt(aDate[2]);

		// Detetect if the date was weel write
		var oDate = new Date(aDate[0],(aDate[1]-1),aDate[2]);
	  console.log(oDate);

		// Detect if the year is correct
		if( oDate.getFullYear() != aDate[0] ){
	    console.log("mal año",oDate.getFullYear(),aDate[0])
			return false;
		}
		// Detect if the month is correct
		if( (oDate.getMonth()+1) != aDate[1] ){
	    console.log("mal mes",oDate.getMonth(),aDate[1])
			return false;
		}

		// Detect if the day is correct
		if( oDate.getDate() != aDate[2] ){
	    console.log("mala fecha",oDate.getDate(),aDate[2])
			return false;
		}

	  // La fecha es válida =]
		return oDate;
	}

function testEmail( sEmail ){
	var expregEmail = /^[a-zA-Z0-9.!#$%&amp;’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
	if( !expregEmail.test(sEmail) ){
		return false;
	}
	return true;
}

/*
 *  Esta función rellena una tabla según el arreglo de objetos que se ingresa.
 *  Es importante notar que el orden y la cantidad de atributos son importantes por
 *  que se auto genera el rellenado.
 *  Dentro del objeto se debe espefificar el tipo de dato que se esta danto, asignando s para texto y i para imágenes
 *   aData = [ [ {t:'s,v:'camara'},...],[]];
 '} ] ]; 
 */
function fillTable( sTableID, aData ){

	console.log("rellenando tabla");
	var oTabla = document.getElementById(sTableID);

	for( var i=0 ; i < aData.length ; i++ ){

		var oRow = document.createElement("tr");
		oRow.setAttribute( "onclick","verDetalle(this)" );

		for( var j=0 ; j < aData[i].length ; j++ ){

			var oCell = document.createElement("td");

			if( aData[i][j].t == 's' ){
				oCell.innerHTML = aData[i][j].v;
			}else if( aData[i][j].t == 'i' ){
				oCell.innerHTML = "<img alt=\"imagen articulo\" src=\"img/small/"+aData[i][j].v+"\" />";
			}
			oRow.appendChild(oCell);
		}
		oTabla.appendChild(oRow);
	}
}