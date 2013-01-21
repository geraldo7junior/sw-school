<?php

class Activity extends AppModel{
	
	public $name = 'Activity';
	public $useTable = 'activities';
	var $belongsTo = array('Project');   //V�rias atividades pertencem a um projeto
	public $hasMany = array('Pointing'); //Uma atividade pode ter v�rios apontamentos
   public $hasAndBelongsToMany = array('Consultant'); //Uma atividade pode ser executada por v�rios
   													  //consultores, e um consultor pode executar
   													  //v�rias atividades
    
}
?>