
$('document').ready(function(){
	
	$('.edit').live('click',function(e){
		//$(this).html(createInput($(this).parent('p').html()));
		$('.edit p').show();
		$('.edit textarea').hide();
		$(this).children('p').hide();
		$(this).children('textarea').show();
		$(this).children('textarea').focus();
		$('.edit p').html($('.edit p ~ textarea').val());
	});
})

function createInput(html){
	html ='<textarea> '+html+' </textarea>'
	return html;
}


//------------------
//=====Funções para pesquisa do consultor gerente, na tela de projetos
//-----------------

//Box com a lista de consultores
function ListGerentes(key){
	$.get(urlAjax('AjaxListConsultant'),null,
			function(data) {   
				$.fancybox(data);
				$('.load').remove();
		})
}

//buscar gerente por nome
function ListGerenteNome(key){
	var name =  $(key).val();
	if (name != '') {
		$.get(urlAjax("AjaxListConsultantNome/"+name),null,
				function(data) {   
					$('#tabela-pesquisa').html(data);
					$('.load').remove();
			});
	}
}
//buscar gerente por cpf
function ListGerenteCPF(key){
	var cpf =  $(key).val();
	if (cpf != '') {
		$.get(urlAjax("AjaxListConsultantCpf/"+cpf),null,
				function(data) {   
					$('#tabela-pesquisa').html(data);
					$('.load').remove();
			});
	}
}

//adicionar o gerente ao projeto na tela
function addConsultorGerente(id,name){
	var html = 	'<div class="input text" id="box-gerente">'+
				'<p>'+name+
				'<img src="'+limparUrl('img/delete.png')+'" alt="Deletar Gerente" title="Deletar Gerente" onclick="deleteGerente()"/></p>'+
				'<input style="display:none" name="data[Project][consultant_id]" id="consultantProject" value='+id+' maxlength="15" type="text">'+
				
				'</div>';
	$('#botaoGerente').append(html);
	$('.fancybox-wrap').remove();
	$('#fancybox-overlay').remove();	
	$('#bt-add-gerente').hide();
}

//adicionar consultor alocado
function addConsultorAlocado(id,name){
	$.get('../AjaxAddConsultant/'+1+'/'+2,null,
		function(data) {   
			$.fancybox(data);
			$('.load').remove();
			var html = 	'<tr>'+
					'<td id="nameTableProject">'+name+' <span id="id-projectconsultant">'+data+'</span></td>'+
					'<td class="edit"><p></p> <textarea style="display:none"></textarea></td>'+
					'<td class="edit"><p></p> <textarea style="display:none"></textarea></td>'+
					'<td class="edit"><p></p> <textarea style="display:none"></textarea></td>'+
					'<td class="edit"><p></p> <textarea style="display:none"></textarea></td>'+
					'<td>'+
						'<div id="actionsProject">'+
						'<img src="'+limparUrl('img/save.png')+'" alt="Salvar Consultor" title="Salvar Consultor" onclick="deleteGerente()"/>'+
						'<img src="'+limparUrl('img/delete.png')+'" alt="Deletar consultor" title="Deletar Consultor" onclick="deleteGerente()"/>'+
						'</div>'+
					'</td>'+
					
					'</tr>'
					
			$('table').append(html);
			$('.fancybox-wrap').remove();
			$('#fancybox-overlay').remove();	
			$('#bt-add-gerente').hide();
	})
}

//deletar gerente
function deleteGerente(){
	$("#box-gerente").remove();
	$('#bt-add-gerente').show();
}

//gif para carregamento ajax
$(document).ajaxStart(function() {
	   $('body').append('<img src="'+limparUrl('img/loading.gif')+'" class="load">');
});

//evitar erros de url ajax
function urlAjax(pag){
	var url = window.location.toString();
	
	if (url.search('add') != '-1'){
		url = url.replace('add',pag);
	}
	else if(url.search('edit') != '-1'){
		url = url.replace('edit',pag);
	}
	else {
		url = url.replace('alocados',pag);
	}
	
	return url;
}

function limparUrl(pag){
	var url = window.location.toString();
	n =  url.search('projects');
	url = url.slice(0,n);
	return url+'/'+pag;
}

//Fim funções projetos



//---------------
//====Funções alocar consultores
//---------------


//Abrir lista de consultores

function listConsultores (){
		$.get('../AjaxListConsultants',null,
				function(data) {   
					$.fancybox(data);
					$('.load').remove();
			})
}