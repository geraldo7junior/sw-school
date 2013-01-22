<?php 
    foreach ($projects as $project) {        
        $list_projects[$project['Project']['id']] =$project['Project']['name'];
        };                    
    if (!isset($list_projects)){
		$list_projects['none'] = 'Nenhum Projeto Cadastrado';
    }
?>	
<?php 
    foreach ($consultants as $consultant) {        
        $list_consultants[$consultant['Consultant']['id']] =$consultant['Consultant']['name'];
        };                    
    if (!isset($list_consultants)){
		$list_consultants['none'] = 'Nenhum Consultor Cadastrado';
    }
?>
				
<h1>Editar Atividade</h1>

        <?php //provavelmente na view add, ou o equivalente para adicionar a pessoa
		echo $this->Form->create('Activities', array('action' => 'edit')); ?>
            <fieldset id="Dados_projeto_pai">
				<?php echo $this->Form->input('Activity.id', array('type'=>'hidden')); ?>
                 <?php echo $this->Form->input('Activity.type', array('label' => 'Tipo: ', 'id'=>'actvType')); ?>        
                <?php echo $this->Form->input('Activity.observations', array('type'=>'textarea','label' => 'Observações: ', 'id'=>'actvObs')); ?>
                <?php echo $this->Form->input('Activity.status', array('options' => array("initiated"=>"Iniciada","in progress"=>"Em desenvolvimento", "completed"=>"Concluída"), 'type'=>'select', 'empty' => 'Selecione', 'label' => 'Status: ', 'id'=>'actvStatus')); ?><br>
                <?php echo $this->Form->input('Activity.consultant1_id', array('options' => $list_consultants,'empty' => 'Selecione', 'type'=>'select','label' => 'Consultor 1: ', 'id'=>'actvID')); ?>
				<?php echo $this->Form->input('Activity.consultant2_id', array('options' => $list_consultants,'empty' => 'Selecione', 'type'=>'select','label' => 'Consultor 2: ', 'id'=>'actvID')); ?>
				<?php echo $this->Form->input('Activity.consultant3_id', array('options' => $list_consultants,'empty' => 'Selecione', 'type'=>'select','label' => 'Consultor 3: ', 'id'=>'actvID')); ?>
				<?php echo $this->Form->input('Activity.consultant4_id', array('options' => $list_consultants,'empty' => 'Selecione', 'type'=>'select','label' => 'Consultor 4: ', 'id'=>'actvID')); ?>
            </fieldset>
            <fieldset id="Dados_projeto_pai">
                <?php echo $this->Form->input('Activity.start_hours', array('type'=>'text','label' => 'Hora Inicial: ','required'=>'required', 'id'=>'actvStartHour')); ?>
                <?php echo $this->Form->input('Activity.end_hours', array('type'=>'text', 'label' => 'Hora Final: ','required'=>'required', 'id'=>'actvEndHour')); ?>
                <?php echo $this->Form->input('Activity.date', array('type'=>'text','label' => 'Data: ', 'id'=>'datepicker')); ?>
                <?php echo $this->Form->input('Activity.hours_worked', array('type'=>'text', 'label' => 'Horas Trabalhadas: ','required'=>'required', 'id'=>'actvHourWorked')); ?>
                <?php echo $this->Form->input('Activity.project_id', array('options' => $list_projects,'empty' => 'Selecione', 'type'=>'select','label' => 'Projeto: ', 'id'=>'actvID')); ?>

            </fieldset>
        
            <?php echo $this->Form->end('Salvar Edição'); ?>
