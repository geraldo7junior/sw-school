<a href="../../activities/index/<?php echo $id_projeto ?>" class="botao" alt="Voltar">Voltar </a>
<h3 id="tituloprojeto">Projeto - <?php echo $nome_projeto; ?> </h3>
<h3 id="tituloatividade">Atividade - <?php echo $activity; ?></h3>




<div class="entry index">

	<table  class="zebra" cellpadding="0" cellspacing="0">
		<tr>
			<th class="responsive">Observação</th>
			<th class="responsive">Consultor</th>
			<th>Tipo consultoria</th>
			<th>Tipo</th>
			<th class="responsive">Horas Trabalhadas</th>
			<th class="responsive">Data</th>			
			<th class="actions">Ações</th>
			<th class="responsive">Aprovação</th>
		</tr>

		<?php
			
			$i = 0;
			foreach ($entries as $entry) 
			{
				$class = null;
				
				if($i++ % 2 == 0)
				{
					$class = 'class="altrow"';
				}
					
							
		?>



		<tr <?php echo $class; ?>>
			<td class="atividade"><?php echo $entry['Entry']['observations']; ?></td>
			<td class="consultor"><?php echo $entry['Consultant']['name']; ?></td>
			<td class="tipo"><?php echo $entry['Entry']['type_consulting']; ?></td>
			<td class="tipo"><?php echo $entry['Entry']['type']; ?></td>
			<td class="horas trabalhadas"><?php echo $entry['Entry']['hours_worked']; ?></td>
			<td class="data"><?php echo implode('/', array_reverse(explode('-', $entry['Entry']['date']))); ?></td>
			<div>
				<td class="actions">
					<?php echo $this->Html->link(
					$this->Html->image("view.png", array('alt' => 'Ver', 'title' => 'Visualizar')), array('action' => 'view', $entry['Entry']['id']), array('escape'=>false, 'id'=>'link'))?>

					<?php 
					if ((in_array($tipo_usuario , array('admin','cons_manager','rel_manager'))) or ($id_consultor_logado === $entry['Entry']['consultant_id'])){
					echo $this->Html->link($this->Html->image("edit.png", array('alt' => 'Editar', 'title' => 'Editar')), array('action' => 'edit', $entry['Entry']['id'],$entry['Entry']['activity_id']),
					array('escape'=>false, 'id'=>'link'));
					}
					?>

					<a href="../add/<?php echo $id_atividade."/".$id_projeto ?>">   <?php echo $this->Html->image("clock.png",array('alt'=>'Apontar', 'title' => 'Apontar', 'id' => 'btnRelogio'));?></a>

					<?php 
					if ((in_array($tipo_usuario , array('admin','cons_manager','rel_manager'))) or ($id_consultor_logado === $entry['Entry']['consultant_id'])){
					echo $this->Html->link($this->Html->image("delete.png", array('alt' => 'Remover', 'title' => 'Excluir')), array('action' => 'delete', $entry['Entry']['id'],$entry['Entry']['activity_id']),
					array('escape'=>false, 'id'=>'link'), "Confirmar exclusão do apontamento?");
					}
					?>
					

					</td>
			</div>
			<td class="actions"> 
				<?php 
				if (in_array($tipo_usuario , array('admin','cons_manager','rel_manager'))) {
						 if ($entry['Entry']['approved'] == 0) {
						echo $this->Html->link(
					$this->Html->image("okay.png", array('alt' => 'Aprovar', 'title' => 'Aprovar')), array('action' => 'approve', $entry['Entry']['id'],$entry['Entry']['activity_id']),
					array('escape'=>false, 'id'=>'link'), "Confirmar aprovar apontamento?");
						}else {
						echo 'Aprovado';
						}
				}else {
						if ($entry['Entry']['approved'] == 0) {
						echo 'Aguardando aprovação';
						}else {
						echo 'Aprovado';
						}
				} 
				?></td>
		</tr>
		<?php } ?>
	</table>
	
</div>
