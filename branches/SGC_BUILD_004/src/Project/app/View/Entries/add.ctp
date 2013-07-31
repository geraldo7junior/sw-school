	
<?php 
    foreach ($activities as $activity) {        
        $list_activities[$activity['Activity']['id']] ='Projeto: '.$activity['Project']['name'].' - Atividade: '.$activity['Activity']['description'];
        };                    
    if (!isset($list_activities)){
		$list_activities['none'] = 'Nenhuma Atividade Cadastrada';
    }
?>		
<?php 
    foreach ($consultants as $consultant) {        
        $list_consultants[$consultant['Consultant']['id']] =$consultant['Consultant']['name'];
        };                    
    if (!isset($list_consultants)){
		$list_consultants['none'] = 'Nenhuma Consultor Cadastrado';
    }
?>

<h1>Cadastrar Apontamento</h1>
<h2 id="tituloprojeto">Projeto - <?php echo $nome_projeto; ?> </h2>
<h2 id="tituloatividade">Atividade - <?php echo $nome_atividade; ?></h2>
    <div id="content">
        <div class="conteudo">

        <?php 
		echo $this->Form->create('Entries', array('action' => 'add/'.$id_atividade.'/'.$id_projeto)); ?>
            <fieldset id="Dados_projeto_pai">
		<?php //Se for um consultor logado, o apontamento automaticamente é no nome dele, se for admin, aparecerá uma lista de consultores
		if (in_array($tipo_usuario , array('admin','cons_manager','rel_manager'))){
			echo $this->Form->input('Entry.consultant_id', array('options' => $list_consultants,'empty' => 'Selecione', 'type'=>'select','label' => 'Consultor: ', 'id'=>'actvID','required'=>'required'));
		} else {
			echo 'Consultor logado: ', $nome_consultor_logado;
			echo $this->Form->input('Entry.consultant_id',array('type'=>'text','default'=>$id_consultor_logado, 'type'=>'hidden'));                                  
		}
		?><br>							                
                <?php echo $this->Form->input('Entry.date', array('type'=>'text','label' => 'Data: ', 'id'=>'datepicker','required'=>'required')); ?><br>
                <?php echo $this->Form->input('Entry.observations', array('type'=>'textarea','label' => 'Observações: ', 'id'=>'actvObs')); ?>
            </fieldset>
            <fieldset id="Dados_projeto_pai">
				<!--<?php echo $this->Form->input('Entry.activity_id', array('options' => $list_activities,'empty' => 'Selecione', 'type'=>'select','label' => 'Projeto/Atividade: ', 'id'=>'actvID','required'=>'required')); ?><br>-->

                <!--<?php echo 'Projeto/Atividade: ', $nome_projeto, ' - ', $nome_atividade;?> <br>-->
                <?php echo $this->Form->input('Entry.activity_id',array('type'=>'text','default'=>$id_atividade,'type'=>'hidden')); ?>

				<?php echo $this->Form->input('Entry.type_consulting', array('options' => array("A"=>"A","B"=>"B", "C"=>"C"),'label' => 'Tipo de consultoria: ', 'id'=>'entryType')); ?> <br>
				<?php echo $this->Form->input('Entry.type', array('options' => array("Individual" => "Individual", "Grupo" => "Grupo"), 'type'=>'select', 'empty' => 'Selecione', 'label' => 'Tipo: ', 'id'=>'actvStatus', 'required' => 'required')); ?><br>
                <?php echo $this->Form->input('Entry.hours_worked', array('type'=>'text', 'label' => 'Horas Trabalhadas: ','required'=>'required', 'id'=>'entryHourWorked')); ?>

				</fieldset>

            <?php echo $this->Form->end('Confirmar Cadastro'); ?>

        </div>
    </div>
