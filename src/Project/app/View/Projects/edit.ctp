
<?php 
                        foreach ($projects as $project) 
                            {
                                $list_projects[$project['Project']['id']] =$project['Project']['name'];
                            };
                    
                        foreach ($companies as $company) 
                            {
                                $list_companies[$company['Company']['id']] =$company['Company']['name'];
                            };
                        if (!isset($list_projects)){
                            $list_projects['none'] = 'Nenhum Projeto Cadastrado';
                        }
                        if(!isset($list_companies)){
                            $list_companies['none'] = 'Nenhuma Empresa Cadastrada';
                        }
                    ?>
    <a href="../../Projects/index" class="botao" alt="Cancelar"> Cancelar</a> 
    <h2>Editar Projeto</h2>
    <h3 id="tituloprojeto">Projeto - <?php echo $nome_projeto; ?> </h3>

    <div id="conteudoAddProjeto">
        <?php echo $this->Form->create('Projects', array('action' => 'edit/'.$id)); ?>
            <fieldset id="dadosProjeto">
            <legend class="legenda">Dados</legend>
                        <?php echo $this->Form->input('Project.id', array('type'=>'hidden')); ?>
                        <?php echo $this->Form->input('Project.name', array('label' => 'Nome <sup title="Campo obrigatório" class="obrigatorio">*</sup>:','required'=>'required', 'id'=>'nameProject')); ?>
                        <?php echo $this->Form->input('Project.description', array('type'=>'textarea', 'label' => 'Descrição <sup title="Campo obrigatório" class="obrigatorio">*</sup>:', 'required'=>'required', 'id'=>'description')); ?>
                        <?php echo $this->Form->input('Project.parent_project_id',array('options' => $list_projects,'type' => 'select', 'empty' => 'Selecione','label' => 'Projeto Pai: ' , 'id' => 'parent_project')); ?>
                        <?php echo $this->Form->input('Project.company_id',array('options' => $list_companies,'type' => 'select', 'empty' => 'Selecione','label' => 'Empresa <sup title="Campo obrigatório" class="obrigatorio">*</sup>: <br>', 'id' => 'company', 'required'=>'required')); ?><br>
            </fieldset>

            <fieldset id="horaGrupo">
                <legend class="legenda">Hora em grupo</legend><br>
                    <?php echo $this->Form->input('Project.a_hours_group', array('type'=>'text','label' => 'Hora A: ','id'=>'hora_a_group', 'onblur'=>'SomarHorasGrupoProjeto()', 'class'=>'hora')); ?><br>
                    <?php echo $this->Form->input('Project.b_hours_group', array('type'=>'text','label' => 'Hora B: ', 'id'=>'hora_b_group', 'onblur'=>'SomarHorasGrupoProjeto()', 'class'=>'hora')); ?><br>
                    <?php echo $this->Form->input('Project.c_hours_group', array('type'=>'text','label' => 'Hora C: ', 'id'=>'hora_c_group', 'onblur'=>'SomarHorasGrupoProjeto()', 'class'=>'hora')); ?><br>
                    <span id="total-de-horas-grupo">Total de horas : <p style=display:inline></p> </span><br>
            </fieldset>

            <fieldset id="horaIndiv">
                 <legend class="legenda">Hora Individual</legend><br>
                    <?php echo $this->Form->input('Project.a_hours_individual', array('type'=>'text','label' => 'Hora A: ','id'=>'hora_a', 'onblur'=>'SomarHorasProjeto()', 'class'=>'hora')); ?><br>
                    <?php echo $this->Form->input('Project.b_hours_individual', array('type'=>'text','label' => 'Hora B: ', 'id'=>'hora_b', 'onblur'=>'SomarHorasProjeto()', 'class'=>'hora')); ?><br>
                    <?php echo $this->Form->input('Project.c_hours_individual', array('type'=>'text','label' => 'Hora C: ', 'id'=>'hora_c', 'onblur'=>'SomarHorasProjeto()', 'class'=>'hora')); ?><br>
                     <span id="total-de-horas">Total de horas : <p style= display:inline></p> </span><br>
            </fieldset>           

            
       
            
            <?php echo $this->Form->end('Atualizar'); ?>
    </div>
</div>

