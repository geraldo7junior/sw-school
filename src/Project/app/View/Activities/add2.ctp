<?php echo $this->Html->script('aplicacao'); ?>
<?php 
    foreach ($projects as $project) {        
        $list_projects[$project['projects']['id']] =$project['projects']['name'];
        };                      
?>
<?php 
    foreach ($consultants as $consultant) {        
        $list_consultants[$consultant['Consultant']['id']] =$consultant['Consultant']['name'];
        };                     
?>
<?php
$consultant_id = 'Activity.consultant'. $consultant_id . '_id';
?>


<H4>Projeto - <?php echo $nome_projeto; ?></H4> 
<H4>Cadastrar Atividade</H4>
    
        <?php
        echo $this->Form->create('Activities', array('action' => 'add2/'.$id)); ?>
            <fieldset id="Dados_projeto_pai2">
                <?php echo $this->Form->input('Activity.project_id', array('type'=>'hidden', 'value' => $id)); ?>
                <?php echo $this->Form->input('Activity.status', array('type'=>'hidden', 'value' => 'Planejada')); ?>
                <?php echo $this->Form->input('Activity.description', array('label' => 'Descrição <sup title="Campo obrigatório" class="obrigatorio">*</sup>:','required'=>'required', 'id'=>'actvDesc', 'required' => 'required', )); ?>
                <?php echo $this->Form->input('Activity.consultant1_id', array('options' => $list_consultants,'empty' => 'Selecione', 'type'=>'select','label' => 'Consultor 1 <sup title="Campo obrigatório" class="obrigatorio">*</sup>:', 'id'=>'actvID','class'=>'cosultant-atividade', 'required' => 'required')); ?>
                <?php echo $this->Form->input('Activity.consultant2_id', array('options' => $list_consultants,'empty' => 'Selecione', 'type'=>'select','label' => 'Consultor 2: ', 'id'=>'actvID','class' =>'cosultant-atividade')); ?>
                <?php echo $this->Form->input('Activity.consultant3_id', array('options' => $list_consultants,'empty' => 'Selecione', 'type'=>'select','label' => 'Consultor 3: ', 'id'=>'actvID','class'=>'cosultant-atividade')); ?>
                <?php echo $this->Form->input('Activity.consultant4_id', array('options' => $list_consultants,'empty' => 'Selecione', 'type'=>'select','label' => 'Consultor 4: ', 'id'=>'actvID','class'=>'cosultant-atividade')); ?>
                <!--< ?php echo $this->Form->input('Consultant.acronym', array('label' => 'Abreviação do Nome: ','required'=>'required', 'id'=>'acronym')); ?>
                
                <input type="button" value="Pesquisar sigla" id="botao-pesquisar-consultor2"  class='botao' onclick='listConsultores();' />  -->

                <?php echo $this->Form->input('Activity.start_hours', array('type'=>'text','label' => 'Hora Inicial <sup title="Campo obrigatório" class="obrigatorio">*</sup>:','required'=>'required', 'id'=>'actvStartHour', 'onblur' => 'checkHour()', 'default' => $act_ini)); ?>
                <?php echo $this->Form->input('Activity.end_hours', array('type'=>'text', 'label' => 'Hora Final <sup title="Campo obrigatório" class="obrigatorio">*</sup>:','required'=>'required', 'id'=>'actvEndHour', 'onblur' => 'checkHour()', 'default' => $act_ter)); ?>
                <?php echo $this->Form->input('Activity.start_date', array('type'=>'text','label' => 'Data Inicial <sup title="Campo obrigatório" class="obrigatorio">*</sup>:', 'required'=>'required', 'id'=>'datepicker', 'onblur' => 'checkDate(this)', 'default' => $data)); ?>
                <?php echo $this->Form->input('Activity.end_date', array('type'=>'text','label' => 'Data Final <sup title="Campo obrigatório" class="obrigatorio">*</sup>:', 'required'=>'required', 'id'=>'datepicker2', 'onblur' => 'checkDate(this)', 'default' => $data)); ?>
            </fieldset>

            <fieldset id="botao_salvar">
                <?php echo $this->Form->end(array('label' => 'Confirmar Cadastro', 'onclick' => 'parent.$.fancybox.close();')); ?>
            </fieldset>  

