<?php
/*
 * Created on 24/12/2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
 class ConsultantsController extends AppController {
 	public $helpers = array ('Html','Form');
 	public $name = 'Consultants';
 	var $scaffold;
 	
 	
 	
 	public function index(){
 		$this->set('title_for_layout', 'Consultores');
 		$this -> layout = 'index';
 		$this -> set ('consultants', $this-> Consultant->find('all', array('conditions'=> array('Consultant.removed !=' => 1),'order'=>array('Consultant.name'))));
		$this-> set ('tipo_usuario',$this->Auth->user('type'));		
 	}
 	
 	public function view($id = null){

    if ($this->Consultant->query('SELECT id FROM consultants where id = ' .$id. ' and removed = 0')){
    $this->set('title_for_layout', 'Consultores');
 		 $this -> layout = 'basemodalint';
		 $this-> set ('tipo_usuario',$this->Auth->user('type'));	
 		 if (!$id) {
            throw new NotFoundException(__('Invalid post'));
        }
 		$consultant =  $this->Consultant->findById($id);
 		 if (!$consultant) {
            throw new NotFoundException(__('Invalid post'));
        }
        $this ->set('projects', $this->Consultant->ProjectConsultant->query('SELECT projects.id, projects.name, projects.description, projects.acronym FROM projects, project_consultants WHERE project_consultants.consultant_id = ' .$id. ' AND project_consultants.project_id = projects.id AND projects.removed != 1'));
        $this ->set('consultant',$consultant);
 	}else {
$this->Session->setFlash($this->flashError('Consultor inválido'));
          $this->redirect(array('action' => 'index'));

  }
}
 	
 	public function add()
  {
    if ($this->Auth->user('type') == 'admin'){
    $this->set('title_for_layout', 'Consultores');
    $this -> layout = 'basemodalint';
    if($this->request->is('post'))
    {
      if ($this->verific($this->request->data)) {
      	$this->request->data['Consultant']['foto'] = $this->SaveImg($this->request->data['Consultant']['foto'],'foto');
        if($this->Consultant->saveAll($this->request->data))
        {
          $this->Session->setFlash($this->flashSuccess('O usuário foi adicionado.'));
          $this->redirect(array('action' => 'index'));
        }
      } 
    }
  }else {
$this->Session->setFlash($this->flashError('Acesso restrito'));
          $this->redirect(array('action' => 'index'));


  }
}

   public function verific($data){
      $ctr = 0;
      $erro ='';
      //Verificar se já existe Nome, Email e usuario.
      $name  =  $this -> Consultant -> query ("SELECT * FROM `consultants` WHERE name = '". $data['Consultant']['name']."'");
      if (empty($name)){} else { $ctr++; $erro = $erro .'Nome já existente.';};
      $email =  $this -> Consultant -> query ("SELECT * FROM `consultants` WHERE email = '". $data['Consultant']['email']."'");
      if (empty($email)){} else { $ctr++; $erro = $erro .'E-mail já existente.';};
      $username =  $this -> Consultant -> query ("SELECT * FROM `consultants` WHERE name = '". $data['User']['username']."'");
      if (empty($username)){} else { $ctr++; $erro = $erro . 'Nome de Usuário já existente.';};

      
      $achouConta  =  $this -> Consultant -> query ("SELECT * FROM consultants_bank_infos WHERE ((number_account = '".$data['BankInfoConsultant']['number_account']."') and (number_account <> '')) and ((number_agency = '".$data['BankInfoConsultant']['number_agency']."') and (number_agency <> '')) ") ;
      if (empty($achouConta)){} else { $ctr++; $erro = $erro . 'Esta conta nesta agência já existe no sistema.';};

      if ($ctr > 0) {
        $this -> Session -> setFlash ($this -> flashError ($erro));
        return false;
      }
      else {
        return true;
      }
   }

   public function verific2($data){
      $ctr = 0;
      $erro ='';
      //Verificar se já existe Conta.
      
      $achouConta  =  $this -> Consultant -> query ("SELECT * FROM consultants_bank_infos WHERE id <> '".$data['BankInfoConsultant']['id']."' and ((number_account = '".$data['BankInfoConsultant']['number_account']."') and (number_account <> '')) and ((number_agency = '".$data['BankInfoConsultant']['number_agency']."') and (number_agency <> '')) ") ;
      if (empty($achouConta)){} else { $ctr++; $erro = $erro . 'Esta conta nesta agência já existe no sistema.';};
    
    if ($ctr > 0) {
        $this -> Session -> setFlash ($this -> flashError ($erro));
        return false;
      }
      else {
        return true;
      }
   }
   public function edit($id = NULL)
  {
    if ($this->Auth->user('type') == 'admin'){
    if ($this->Consultant->query('SELECT id FROM consultants where id = ' .$id. ' and removed = 0')){
    $this->set('title_for_layout', 'Consultores');
		$this->layout = 'base';
		$this->Consultant->id = $id;
		if (!$id) {
        	throw new NotFoundException(__('Invalid post'));
	    }
	
	    $consult = $this->Consultant->findById($id);
	    if (!$consult) {
	        throw new NotFoundException(__('Invalid post'));
	    }
		if ($this->request->is('get')) {
    $this -> set('consultant', $this->Consultant->read());
			$this->request->data = $this->Consultant->read();
		} 
		else {
			$this->Consultant->id = $id;
      if ($this->verific2($this->request->data)) {
        if ($this->Consultant->saveAll($this->request->data)) {
				
				  $this->Session->setFlash($this->flashSuccess('Consultor foi editado.'));
				  $this->redirect(array('action' => 'index'));
        }
			}
		} 
   }else {
$this->Session->setFlash($this->flashError('Consultor inválido'));
          $this->redirect(array('action' => 'index'));

  }
 }else {
$this->Session->setFlash($this->flashError('Acesso restrito'));
          $this->redirect(array('action' => 'index'));


  }
}


   public function delete($id = NULL)
   {
    if ($this->Auth->user('type') == 'admin'){
		$this->Consultant->id = $id;
		if($this->Consultant->saveField("removed", "true")){
			$this->Session->setFlash($this->flashSuccess('O consultor foi deletado!'));
			$this->redirect(array('action' => 'index'));
		}
   }else {
$this->Session->setFlash($this->flashError('Acesso restrito'));
          $this->redirect(array('action' => 'index'));


  }
}



   public function ReportPayment(){
      $this -> layout = 'base';
      if ($this-> request-> is('POST')) {
        $id =  $_POST['id'];
        $this -> set('name', $this->Consultant-> findById($id));
        $this -> set ('consultants', $this-> Consultant -> query('
              select swsdb.consultants.name AS consultant_name,
                   swsdb.projects.name AS project_name,
                     swsdb.project_consultants.value_hour_a_individual,
                     swsdb.project_consultants.value_hour_b_individual,
                     swsdb.project_consultants.value_hour_c_individual,
                     swsdb.project_consultants.value_hour_a_group,
                     swsdb.project_consultants.value_hour_b_group,
                     swsdb.project_consultants.value_hour_c_group,
                   swsdb.entries.type_consulting,
                   swsdb.entries.type,  
                   swsdb.entries.hours_worked,
                   swsdb.entries.date
              from swsdb.consultants
              inner join swsdb.project_consultants
              on swsdb.consultants.id = swsdb.project_consultants.consultant_id
              left join swsdb.projects
              on swsdb.projects.id = swsdb.project_consultants.project_id
              inner join swsdb.entries
              on swsdb.consultants.id = swsdb.entries.consultant_id
              where swsdb.consultants.id ='.$id));
      }
      else {
        $this -> set ( 'consultants' ,$this-> Consultant -> find('all'));
      }
   }


   public function Foto(){
   		
// verifica se foi enviado um arquivo 
if(isset($_FILES['arquivo']['name']) && $_FILES["arquivo"]["error"] == 0)
{
 
    echo "Você enviou o arquivo: <strong>" . $_FILES['arquivo']['name'] . "</strong><br />";
    echo "Este arquivo é do tipo: <strong>" . $_FILES['arquivo']['type'] . "</strong><br />";
    echo "Temporáriamente foi salvo em: <strong>" . $_FILES['arquivo']['tmp_name'] . "</strong><br />";
    echo "Seu tamanho é: <strong>" . $_FILES['arquivo']['size'] . "</strong> Bytes<br /><br />";
 
    $arquivo_tmp = $_FILES['arquivo']['tmp_name'];
    $nome = $_FILES['arquivo']['name'];
     
 
    // Pega a extensao
    $extensao = strrchr($nome, '.');
 
    // Converte a extensao para mimusculo
    $extensao = strtolower($extensao);
 
    // Somente imagens, .jpg;.jpeg;.gif;.png
    // Aqui eu enfilero as extesões permitidas e separo por ';'
    // Isso server apenas para eu poder pesquisar dentro desta String
    if(strstr('.jpg;.jpeg;.gif;.png', $extensao))
    {
        // Cria um nome único para esta imagem
        // Evita que duplique as imagens no servidor.
        $novoNome = md5(microtime()) . $extensao;
         
        // Concatena a pasta com o nome
        $destino = 'imagens/' . $novoNome; 
         
        // tenta mover o arquivo para o destino
        if( @move_uploaded_file( $arquivo_tmp, $destino  ))
        {
            echo "Arquivo salvo com sucesso em : <strong>" . $destino . "</strong><br />";
            echo "<img src=\"" . $destino . "\" />";
        }
        else
            echo "Erro ao salvar o arquivo. Aparentemente você não tem permissão de escrita.<br />";
    }
    else
        echo "Você poderá enviar apenas arquivos \"*.jpg;*.jpeg;*.gif;*.png\"<br />";
}
else
{
    echo "Você não enviou nenhum arquivo!";
}

   }



   
   //Chamada ajax
   public function ajaxMsg($obj=null){
   		$this->layout='ajax';
   		//Fazer verificação do obj de entrada enviado, ser for :
   		//uma abreviação sera 2 digitos;
   		//uma abreviação de cor sera 6 digitos;
   		//um cpf sera 14 digitos, isso por causa da mascara    	   		
   		if(strlen($obj) == 2 ) {
   			//Esse "findBy" acompanhado do nome do campo da tabela faz um seletec, com um where nele.
   			if($this->Consultant->findByAcronym($obj)){
   			$this->set('mensagem', 'true');}
   			else{
   			$this->set('mensagem','false');
   		}
   		}
   		else if(strlen($obj) == 6){
   			$obj = '#'.$obj;
   			if ($this->Consultant->findByAcronym_color($obj))
   			{
   			$this->set('mensagem', 'true');
   			}
   			else{
   			$this->set('mensagem','false');
   			}
   		}
   		else if(strlen($obj) == 14){
   			if($this->Consultant->findByCpf($obj)){
   			$this->set('mensagem','true');}
   			else{
   			$this->set('mensagem','false');
   		}
   		}	
   		else{
   			$this->set('mensagem','true');
   		}
   }

   public function testeConta($agencia = null,  $conta = null, $id = null){
    $this->layout='ajax';

      if ($id < 0){
        $achouConta  =  $this -> Consultant -> query ("SELECT * FROM consultants_bank_infos WHERE number_account = '".$conta."' and number_agency = '".$agencia."'");
        if (empty($achouConta)){
        $this->set('mensagem','false');
        } 
        else {
        $this->set('mensagem','true');

        }
      }
      else{

        $achouConta  =  $this -> Consultant -> query ("SELECT * FROM consultants_bank_infos WHERE number_account = '".$conta."' and number_agency = '".$agencia."' and id <> '".$id."'");
        
        if (empty($achouConta)){
        $this->set('mensagem','false');
        } 
        else {
        $this->set('mensagem','true');
      }
    }
  }
}
 	

?>
