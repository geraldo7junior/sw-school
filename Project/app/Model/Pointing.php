<?php

class Pointing extends AppModel{
	
	public $name = 'Pointing';
	public $useTable = 'pointings';
	var $belongsTo = array('Activity');   //V�rios apontamentos para uma atividade

    
}
?>