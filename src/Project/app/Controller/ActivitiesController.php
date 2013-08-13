<?php

 class ActivitiesController extends AppController{
 	public $helpers = array ('Html','Form','Js'=>array('Jquery'));
 	public $name = 'Activities';
 	var $scaffold;
 	
 	
 	public function index($id = null){
 		 if ($id != null){
 		 	$this->set('title_for_layout', 'Atividades');
 		 	if (!$id) {
            throw new NotFoundException(__('Invalid post'));
	        }

	 		$Projects =  $this->Activity->Project->findById($id);
	 		
	 		if (!$Projects) {
	            throw new NotFoundException(__('Invalid post'));
	        }
 			$this -> layout = 'basemodal';
 			//$this -> set ('activities', $this-> Activity->find('all', array('conditions'=> array('Activity.removed !=' => 1,'Activity.project_id =' => $id),'order'=>array('Project.name','Activity.description'))));
 			$activities = $this->Activity->query("select id, project_id, description, status, date from activities where removed != 1 and project_id = '".$id."' order by concat(substring(date,7,4) , substring(date,4,2), substring(date,1,2) ) DESC");
	 			$this -> set ('activities',$activities);
 			$this -> set('attachments', $this->Activity->Attachment->find('all'), array('conditions'=>array('Attachment.removed !=' => 1)));
			$this -> set ('entries', $this-> Activity-> Entry-> find('all', array('conditions'=> array('Entry.removed !=' => 1))));
			$this-> set ('projects',$this->Activity->Project->find('all', array('conditions'=> array('Project.id =' => 'Activity.project_id'))));	
			$this-> set ('tipo_usuario',$this->Auth->user('type'));		
			$this ->set('project',$Projects);
 		 }		
 				 
 	}
 	
	public function AjaxListConsultant(){
		$name = $this->Activity->Consultant->findAll();
		return $name['Consultant'];
	}
	
	public function AjaxListFiles($id){
		$this->layout = 'ajax';
		$attachments = $this->Activity->Attachment->find('all',array('conditions' => array('Attachment.activity_id =' =>$id, 'Attachment.removed !='=> 1)));
		$this-> set('attachments', $attachments);
		
	}
		
	public function AjaxAttachFiles(){
		
	
	}
	
	public function add($id){
	 	$this->layout = 'basemodalint';
	 	$this-> set ('id',$id);
		$projects = $this->Activity->Project->query('select * from projects where id not in (select parent_project_id from projects where parent_project_id is not null) order by name');			
		$this-> set ('projects',$projects);	
		$nome_projeto = $this->Activity->Project->query("SELECT projects.name FROM projects WHERE projects.id = ".$id);		
		$this-> set ('nome_projeto', $nome_projeto[0]['projects']['name']);	
		//$this-> set ('projects',$this->Activity->Project->find('all'), array('conditions'=> array('Project.removed !=' => 1)));
		$this-> set ('consultants',$this->Activity->Consultant->find('all'), array('conditions'=> array('Consultant.removed !=' => 1)));
	 	$this -> set('attachments', $this->Activity->Attachment->find('all'), array('conditions'=>array('Attachment.removed !=' => 1)));
	 	if($this->request->is('post')){
	 		if ($this -> verifica($this->request->data)) {
		 		if($this->Activity->saveAll($this->request->data)){
		 			$this->Session->setFlash($this->flashSuccess('A atividade foi adicionada com sucesso.'));
	          		$this->redirect(array('action' => '../activities/index/'.$id));
		 		}
		 		else{
					$this->Session->setFlash($this->flashError('Erro ao cadastrar atividade!'));
				}		
			}		
	 	}
	 	else{
	 		$this->Session->setFlash($this->Session->setFlash($this->flashError('A atividade não foi adicionada. Tente novamente!')));			
		
	 	}			 	

	 	
	 }
	 
	public function verifica($data) {
		$ctr = 0;
		$strerro = '';
		//Hora final não pode ser menor que a hora inicial.
		if ($data['Activity']['start_hours'] > $data['Activity']['end_hours']) {
			$strerro = $strerro . 'A hora inicial não pode ser maior que a hora final.</br>';

			$ctr ++;

		}
		//Não é permitido que a hora inicial seja igual a hora final
		elseif ($data['Activity']['start_hours'] == $data ['Activity']['end_hours']){
			$strerro = $strerro . 'A hora inicial não pode ser igual a hora final.</br>';
			$ctr ++;
		}

		//Se a atividade for 'Em desenvolvimento'  a data não pode ser depois do dia do cadastramento.
		if ($data['Activity']['status'] == 'Em desenvolvimento') {
			$dt =  date('d').'/'.date('m').'/'.date('Y');
			if ($data['Activity']['date'] > $dt) {
				$ctr ++;
				$strerro = $strerro . 'Status "Em desenvolvimento", com data inicial a começar.</br>';
			};			
		}

		//Se a atividade já existe.
		$ext = $this -> Activity -> query ( "SELECT * FROM `activities` WHERE description = '". $data['Activity']['description']."'" );
		if (empty($ext)){
		}
		else {
			$ctr ++;
			$strerro = $strerro . 'Atividade já cadastrada.';
		}

		if ($ctr > 0) {
			$this -> Session -> setFlash ($this -> flashError ($strerro));
			return false;
		}
		else {
			return true;
		}
	}

	public function verificaedit($data) {
		$ctr = 0;
		$strerro = '';
		//Hora final não pode ser menor que a hora inicial.
		if ($data['Activity']['start_hours'] > $data['Activity']['end_hours']) {
			$strerro = $strerro . 'A hora inicial não pode ser maior que a hora final.</br>';

			$ctr ++;
		}
		//Não é permitido que a hora inicial seja igual a hora final
		elseif ($data['Activity']['start_hours'] == $data ['Activity']['end_hours']){
			$strerro = $strerro . 'A hora inicial não pode ser igual a hora final.</br>';
			$ctr ++;
		}

		//Se a atividade for 'Em desenvolvimento'  a data não pode ser depois do dia do cadastramento.
		if ($data['Activity']['status'] == 'Em desenvolvimento') {
			$dt =  date('d').'/'.date('m').'/'.date('Y');
			if ($data['Activity']['date'] > $dt) {
				$ctr ++;
				$strerro = $strerro . 'Status "Em desenvolvimento", com data inicial a começar.</br>';
			};			
		}
		if ($ctr > 0) {
			$this -> Session -> setFlash ($this -> flashError ($strerro));
			return false;
		}
		else {
			return true;
		}
	}

	public function delete($id = NULL, $id_projeto){
		$this->Activity->id = $id;
		if($this->Activity->saveField("removed", "true")){
			$this->Session->setFlash($this -> flashSuccess('A atividade foi removida com sucesso!'));
			$this->redirect(array('action' => 'index/'.$id_projeto));
		}
	}

	public function eliminate($id = NULL, $id_projeto)
{
 
		if($this->Activity->delete($id))
{
			$this->Session->setFlash($this->flashSuccess('Atividade deletada!'));
   			$this->redirect(array('action' => 'index/'.$id_projeto));
}

}
	
	public function edit($id = NULL, $id_projeto){
		$this->layout = 'basemodalint';
		$this-> set ('id',$id);
		$this-> set ('id_projeto',$id_projeto);		
		$projects = $this->Activity->Project->query('select * from projects where id not in (select parent_project_id from projects where parent_project_id is not null) order by name');			
		$this-> set ('projects',$projects);	
		$nome_projeto = $this->Activity->Project->query("SELECT projects.name FROM projects, activities WHERE activities.project_id = projects.id and activities.id = ".$id);		
		$this-> set ('nome_projeto', $nome_projeto[0]['projects']['name']);		
		$nome_atividade = $this->Activity->Project->query("SELECT activities.description FROM projects, activities WHERE activities.project_id = projects.id and activities.id = ".$id);		
		$this-> set ('nome_atividade', $nome_atividade[0]['activities']['description']);	
		//$this-> set ('projects',$this->Activity->Project->find('all'), array('conditions'=> array('Project.removed !=' => 1)));
		$this-> set ('consultants',$this->Activity->Consultant->find('all'), array('conditions'=> array('Consultant.removed !=' => 1)));
		$this->Activity->id = $id;
		
		if ($this->request->is('get')) {
			$this->request->data = $this->Activity->read();
		}
		
		else{			
			$this->Activity->id = $id;

			if ($this -> verificaedit($this->request->data)){

				if ($this->Activity->saveAll($this->request->data)) {
				
					//$this->Session->setFlash($this->flashSuccess('Atividade foi editada.'));
					$this->redirect(array('action' => 'index/'.$id_projeto));
				}
				else {
					$this->redirect(array('action' => 'index/'.$id_projeto));
				}
			}
		}
		$nome_projeto = $this->Activity->Project->query("SELECT projects.name FROM projects, activities WHERE activities.project_id = projects.id and activities.id = ".$id);		
			$this-> set ('nome_projeto', $nome_projeto[0]['projects']['name']);		
			
		$nome_atividade = $this->Activity->Project->query("SELECT activities.description FROM projects, activities WHERE activities.project_id = projects.id and activities.id = ".$id);		
			$this-> set ('nome_atividade', $nome_atividade[0]['activities']['description']);
	   
	}
	
	public function view($id){

		$this->Activity->id = $id;
		$this-> set ('tipo_usuario',$this->Auth->user('type'));	
		$this->layout = 'basemodalint';
		$Atividade =  $this->Activity->findById($id);
		$this -> set ('consultor1', $this-> Nome_Consultor($Atividade['Activity']['consultant1_id']));
		$this -> set ('consultor2', $this-> Nome_Consultor($Atividade['Activity']['consultant2_id']));
		$this -> set ('consultor3', $this-> Nome_Consultor($Atividade['Activity']['consultant3_id']));
		$this -> set ('consultor4', $this-> Nome_Consultor($Atividade['Activity']['consultant4_id']));
		$this -> set ('entries', $this-> Activity-> Entry-> find('all', array('conditions'=> array('Entry.removed !=' => 1, 'Entry.activity_id = ' => $id))));
 		$this -> set ('activities', $this-> Activity->find('all', array('conditions'=> array('Activity.removed !=' => 1))));
		$this -> set ('nome_projeto', $this-> Nome_Projeto($Atividade['Activity']['project_id']));
	    if ($this->request->is('get')) {
	        $this->set('activities', $this->Activity->read());
	    }

	    $id_projeto=$this->Activity->Project->query("SELECT activities.project_id FROM projects, activities WHERE activities.project_id = projects.id and activities.id = ".$id);
			$this-> set ('id_projeto', $id_projeto[0]['activities']['project_id']);
		$id_atividade=$this->Activity->Project->query("SELECT activities.id FROM activities WHERE activities.id = ".$id);
			$this-> set ('id_atividade', $id_atividade[0]['activities']['id']);

	    $nome_projeto = $this->Activity->Project->query("SELECT projects.name FROM projects, activities WHERE activities.project_id = projects.id and activities.id = ".$id);	
			$this-> set ('nome_projeto', $nome_projeto[0]['projects']['name']);
		$nome_atividade = $this->Activity->Project->query("SELECT activities.description FROM projects, activities WHERE activities.project_id = projects.id and activities.id = ".$id);					
			$this-> set ('nome_atividade', $nome_atividade[0]['activities']['description']);

	}


	public function add2($idX){
		//1.T.16-07-2013.1
		list ($id, $per, $dia, $mes, $ano, $consultant_id) = split ('[/.-]', $idX);
	 	$this->layout = 'basemodal';
	 	$this-> set('consultant_id', $consultant_id);
	 	$this-> set ('idX', $idX);
	 	$this-> set ('id',$id);
	 	if ($per=="M"){
	 		$this-> set ('act_ini', "08:00");
	 		$act_ini = "00:00:00";
	 		$this-> set ('act_ter', "12:00");
	 		$act_ter = "12:59:00";
	 	}elseif ($per=="T") {
	 		$this-> set ('act_ini', "13:00");
	 		$act_ini = "13:00:00";
	 		$this-> set ('act_ter', "17:00");
	 		$act_ter = "23:59:00";
	 	}
	 	$data = $dia.'/'.$mes.'/'.$ano;
	 	$this-> set ('data', $data);
	 	$this-> set ('per', $per);
		$projects = $this->Activity->Project->query('select * from projects where id not in (select parent_project_id from projects where parent_project_id is not null) order by name');			
		$this-> set ('projects',$projects);	
	
			
		$nome_projeto = $this->Activity->Project->query("SELECT projects.name FROM projects WHERE projects.id = ".$id);		
		$this-> set ('nome_projeto', $nome_projeto[0]['projects']['name']);	
		//$this-> set ('projects',$this->Activity->Project->find('all'), array('conditions'=> array('Project.removed !=' => 1)));
		$this-> set ('consultants',$this->Activity->Consultant->find('all'), array('conditions'=> array('Consultant.removed !=' => 1)));
	 	$this -> set('attachments', $this->Activity->Attachment->find('all'), array('conditions'=>array('Attachment.removed !=' => 1)));
	 	if($this->request->is('post')){
	 		if ($this -> verifica($this->request->data)) {
		 		if($this->Activity->saveAll($this->request->data)){
		 			$this->Session->setFlash($this->flashSuccess('A atividade foi adicionada com sucesso.'));
		 			sleep(3);
	          		//$this->redirect(array('action' => '../activities/index/'.$id));
		 		}
		 		else{
					$this->Session->setFlash($this->flashError('Erro ao cadastrar atividade!'));
				}		
			}		
	 	}
	 	else{
	 		$this->Session->setFlash($this->Session->setFlash($this->flashError('A atividade não foi adicionada. Tente novamente!')));			
		
	 	}	 	
	 	
	}


	 public function edit2($idX){
	 	echo $idX;
	 	//1.M.18-07-2013.1.MS
	 	list ($id_projeto, $per, $dia, $mes, $ano, $consultant_id, $sigla_consultor) = split ('[/.-]', $idX);
		$this->layout = 'basemodal';
	 	if ($per=="M"){
	 		//$this-> set ('act_ini', "08:00");
	 		$act_ini = "00:00:00";
	 		//$this-> set ('act_ter', "12:00");
	 		$act_ter = "12:59:00";
	 	}elseif ($per=="T") {
	 		//$this-> set ('act_ini', "13:00");
	 		$act_ini = "12:59:00";
	 		//$this-> set ('act_ter', "17:00");
	 		$act_ter = "23:59:00";
	 	}
	 	$this-> set ('consultant_id', $consultant_id);
	 	$consultant_id = 'consultant'.$consultant_id.'_id';
	 	$id_consultor = $this->Activity->Project->query("SELECT consultants.id FROM consultants WHERE consultants.acronym = '$sigla_consultor'");
	 	$id_consultor = $id_consultor[0]["consultants"]["id"];
	 	$this-> set ('id_consultor', $id_consultor);
	 	$data = $dia.'/'.$mes.'/'.$ano;
	 	$this-> set ('data', $data);
	 	$this-> set ('id_projeto',$id_projeto);		
	 	$this-> set ('sigla_consultor', $sigla_consultor);
	 	$this-> set ('per', $per);
		$projects = $this->Activity->Project->query('select * from projects where id not in (select parent_project_id from projects where parent_project_id is not null) order by name');
		$id = $this->Activity->Project->query("SELECT activities.id FROM activities WHERE activities.project_id =  '$id_projeto' AND activities.date = '$data' AND (activities.consultant1_id = '$id_consultor' OR activities.consultant2_id = '$id_consultor' OR activities.consultant3_id = '$id_consultor' OR activities.consultant4_id = '$id_consultor') AND activities.start_hours <= '$act_ter' AND activities.end_hours >= '$act_ini'");
		$id = $id[0]["activities"]["id"];
		$this-> set ('id',$id);	
		$this-> set ('projects',$projects);	
		$nome_projeto = $this->Activity->Project->query("SELECT projects.name FROM projects, activities WHERE activities.project_id = projects.id and activities.id = '$id'");		
		$this-> set ('nome_projeto', $nome_projeto[0]['projects']['name']);		
		$nome_atividade = $this->Activity->Project->query("SELECT activities.description FROM projects, activities WHERE activities.project_id = projects.id and activities.id = '$id'");		
		$this-> set ('nome_atividade', $nome_atividade[0]['activities']['description']);	
		//$this-> set ('projects',$this->Activity->Project->find('all'), array('conditions'=> array('Project.removed !=' => 1)));
		$this-> set ('consultants',$this->Activity->Consultant->find('all'), array('conditions'=> array('Consultant.removed !=' => 1)));
		$this->Activity->id = $id;
		
		if ($this->request->is('get')) {
			$this->request->data = $this->Activity->read();
		}
		else{			
			$this->Activity->id = $id;
			if ($this->Activity->saveAll($this->request->data)) {
				
				$this->Session->setFlash($this->flashSuccess('Atividade foi editada.'));
				//$this->redirect(array('action' => '../home/'));
				echo '<script>window.parent.$.fancybox.close();</script>';
			}
			else {
				//$this->redirect(array('action' => '../home/'));
				echo '<script>window.parent.$.fancybox.close();</script>';
			}
			
		}
		$nome_projeto = $this->Activity->Project->query("SELECT projects.name FROM projects, activities WHERE activities.project_id = projects.id and activities.id = ".$id);		
			$this-> set ('nome_projeto', $nome_projeto[0]['projects']['name']);		
			
		$nome_atividade = $this->Activity->Project->query("SELECT activities.description FROM projects, activities WHERE activities.project_id = projects.id and activities.id = ".$id);		
			$this-> set ('nome_atividade', $nome_atividade[0]['activities']['description']);
	}
	   



	private function Nome_Consultor($id){
		$name = $this->Activity->Consultant->findById($id);
			if ($name){
				return $name['Consultant']['name'];
 		 	}else{
				return '';
			}
		}
	
	private function Nome_Projeto($id){
		$name = $this->Activity->Project->findById($id);
		return $name['Project']['name'];
 		}
	 	
}
?>
