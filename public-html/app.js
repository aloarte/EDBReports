(function(){
	/*
	 * Referencia a cargar en el html para cargar este modulo de angular 
	 */
	var app = angular.module('raidStuff',[]);


	/*
	 * Sobre el modulo, se crea un controller con las funciones a ejecutar
	 */
	app.controller('RaidController',function(){
		this.miembros = groups;
		this.jefes = bosses;

	});

	/*
	 * Modulo para controlar los tabs entre los dos grupos
	 */
	app.controller('TabController', function(){
		this.tab=0;

		//Para setear un nuevo valor de tab
		this.setTab = function(newValue){
			this.tab= newValue;
		};
		//Para conocer si el tab pasado por parametro es el que esta puesto
		this.isSet = function(tabName){
			return this.tab === tabName;
		};

	});

	app.filter('date', function($filter){
		return function(input){
		  	if(input == null){ 
		  		return ""; 
		  	} 	 
			var _date = $filter('date')(new Date(input), 'MMM dd yyyy');
	 	  	return _date.toUpperCase();
	 	};
	});


	/*
	 * Variable con toda la información de los jefes de raid
	 */
	var bosses = [
		{ name: "Guardian del Valle"		, wing: 1,showBoss: true, image: "images/GuardianValleImagen.jpg"},
		{ name: "Gorseval el Multiple"		, wing: 1,showBoss: true, image: "images/GorsevalImagen.jpg"},
		{ name: "Sabetha"					, wing: 1,showBoss: true, image: "images/SabethaImagen.jpg"},
		{ name: "Perezon"					, wing: 2,showBoss: true, image: "images/PerezonImagen.jpg"},
		{ name: "Trio de Bandidos"			, wing: 2,showBoss: false, image: "images/TrioImagen.jpg"},
		{ name: "Mathias"					, wing: 2,showBoss: true, image: "images/MathiasImagen.jpg"},
		{ name: "Escolta"					, wing: 3,showBoss: false, image: "images/EscoltaImagen.jpg"},
		{ name: "Ensamblaje de la Fortaleza", wing: 3,showBoss: true, image: "images/KCImagen.jpg"},
		{ name: "Xera"						, wing: 3,showBoss: true, image: "images/XeraImagen.jpg"},
		{ name: "Cairn el Indomable"		, wing: 4,showBoss: true, image: "images/CairnImagen.jpg"},
		{ name: "Estatua Mursaat"			, wing: 4,showBoss: true, image: "images/EstatuaMursaatImagen.jpg"},
		{ name: "Samarog el puto"			, wing: 4,showBoss: true, image: "images/SamarogImagen.jpg"},
		{ name: "Deimos"					, wing: 4,showBoss: true, image: "images/DeimosImagen.jpg"},


	
	];
	
	/*
	 * Variable con la información de los grupos de raid
	 */
	var groups = [
		{ name: "Grupo 1", completed: true},
		{ name: "Grupo 2", completed: true}
	];

	function getDate(strDate , strTime) {
		if((strDate.lenght === 8)&&(strTime.lenght ===6)){
			var year = strDate.substring(0, 4);
			var month = strDate.substring(4, 6);
			var day = strDate.substring(6, 8);

			var hours = strTime.substring(0, 2);
			var minutes = strTime.substring(2, 4);
			var seconds = strTime.substring(4, 6);

			return new Date(year, month, day, hours, minutes, seconds, 0);
		}
		else{
			return null;
		}

  		
	}

		
})();
