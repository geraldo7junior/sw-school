﻿//Quando o documento (pagina) estiver Ready(carregado) ele chama as funções

$('document').ready(function(){


    $('.cosultant-atividade').blur(function(){
    	var selecionado = $(this).val();
    	
    	//mostrar todos os options disponiveis
    	$('.cosultant-atividade').children('option').show();
    	//esconder o option selecionado nos selects
    	$('.cosultant-atividade').children('option[value='+selecionado+']').hide();
    	//mostrar o option selecionado no select usado
    	$(this).children('option[value='+selecionado+']').show();

	    $(".cosultant-atividade").each(function() {
	    		var selecionado = $(this).val();
			    $('.cosultant-atividade').children('option[value='+selecionado+']').hide();
    			$(this).children('option[value='+selecionado+']').show();
		});
    });


	//Menu
	var flag = false;
	$('#botao_home').click(function(e){
		if (flag==false){
			$('#Menu_Home').animate({'margin-left':'-230px'});	
			flag = true;
		}
		else{
			$('#Menu_Home').animate({'margin-left':'-500px'});	
			flag =false;
		}		
	});
	$('#Menu_Home').click(function(e){
		e.stopPropagation();
	})
	$('html').click(function(){
		flag = false;
		$('#Menu_Home').animate({'margin-left':'-500px'});	
	});
	//endmenu

	
	//Mascaras
	$("#cpf").mask("999.999.999-99");
	$("#phone1").mask("(99)9999-9999");
	$("#phone2").mask("(99)9999-9999");
	$("#zip_code").mask("99.999-999");
	$('#cnpj').focus();
        $("#cnpj").mask("99.999.999/9999-99");
	$("#phone_financial").mask("(99)9999-9999");
	$("#phone_sponsor").mask("(99)9999-9999");
	$("#phone_sepg").mask("(99)9999-9999");		
	$("#hora").mask("99:99");
	$("#entryHourWorked").mask("99:99");
	$("#actvStartHour").mask("99:99");
	$("#actvEndHour").mask("99:99");


	
		
	
	//end mascaras

	//Buscar Endereço ao digitar o CEP
	$('#zip_code').keypress(function(){
		var cep = $(this).val();
		cep = cep.replace('-','');
		cep = cep.replace('.','');
		cep = cep.replace('_','');
		var tamanho = cep.length;
		if(tamanho == 8){
			//Função de buscar endereço pelo cep
			getEndereco();
		}
	});
	//end buscar cep

	
	 
	 
	 //Função Do campo de cor, escolhendo a cor e edicionando ao campo como background a cor e o valor hexadecimal
	 $('#acronym_color').ColorPicker({
		 	///var elemento = this;
			color: '#000001',
			onShow: function (colpkr) {
				$(colpkr).fadeIn(500);
				
				return false;
			},
			onHide: function (colpkr) {
				$(colpkr).fadeOut(500);
				return false;
			},
			onChange: function (hsb, hex, rgb) {
				$('#acronym_color').css('backgroundColor', '#' + hex);
				$('#acronym_color').val('#'+hex);
			}
		});
	 
	 //total de horas
	 SomarHorasProjeto();
	 SomarHorasGrupoProjeto();
	 

	 //calendario no campo data na tela de atividades
	$(function() {
	$( "#datepicker" ).datepicker();
	});

	 
	
	
});

setTimeout(
		function() {
			$('.flash').fadeOut('fast');
			}, 
		4000);

//Checar se abreviação já é utilizada
function checkAcronym(src){
	d = src;
	var acronym = $(d).val();
	$.get("ajaxMsg/"+acronym,null,
		function(data) {   
			if(data == 'true'){
				d.setCustomValidity("Abreviação já utilizada");
			}
			else {
				d.setCustomValidity("");
			}
	});
};

//Somar horas do projeto
function SomarHorasProjeto(){
	 var total = 0;
	 if($('#hora_a').val() != ''){
	 total = parseInt($('#hora_a').val());
	 }
	 if($('#hora_b').val() != ''){
	 total = total + parseInt($('#hora_b').val());
	 }
	 if($('#hora_c').val() != ''){
	 total = total + parseInt($('#hora_c').val());
	 }
	 $('#total-de-horas p').html(total);
};
function SomarHorasGrupoProjeto(){
	 var total = 0;
	 if($('#hora_a_group').val() != ''){
	 total = parseInt($('#hora_a_group').val());
	 }
	 if($('#hora_b_group').val() != ''){
	 total = total + parseInt($('#hora_b_group').val());
	 }
	 if($('#hora_c_group').val() != ''){
	 total = total + parseInt($('#hora_c_group').val());
	 }
	 $('#total-de-horas-grupo p').html(total);
};





function anularConsultant(obt){
	$(obt).attr('id')
}