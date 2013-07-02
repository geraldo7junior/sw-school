<h1 id="titulo">Atividade - <?php echo $activities['Activity']['id']; ?> 

<?php 
	if (in_array($tipo_usuario , array('admin','cons_manager','rel_manager'))){
	
	echo '<span class="icon-action">';
	echo $this->Html->link($this->Html->image("delete.png", array("alt" => "Deletar")),array('action' => 'delete', $activities['Activity']['id']),array('escape'=>false),"Você quer excluir realmente ?");
	echo '</span>';
	echo '<span class="icon-action">'; 
	echo $this->Html->link($this->Html->image("edit.png", array("alt" => "Editar")),'edit/'.$activities['Activity']['id'],array('escape'=>false));
	echo '</span>';
	}
	?>
	
</h1>


<div id="dados-view-atividades"> 
	<h2 id="titulodados"> Informações </h2>
	<p><span>Descrição: </span><?php echo $activities['Activity']['description']; ?></p>
	<p><span>Projeto: </span><?php echo $nome_projeto; ?></p>
	<p><span>Status: </span><?php echo $activities['Activity']['status']; ?></p>
	<p><span>Observações: </span><?php echo $activities['Activity']['observations']; ?></p>
	<p><span>Consultores: </span></p>
	<p><?php echo $consultor1 ?></p>
	<p><?php echo $consultor2 ?></p>
	<p><?php echo $consultor3 ?></p>
	<p><?php echo $consultor4 ?></p>
</div>

<div id="hora-view-atividades">
	<h2 id="titulodados">Horários</h2>
	<p><span>Hora inicial: </span> <?php echo $activities['Activity']['start_hours']; ?></p>
	<p><span>Hora final: </span> <?php echo $activities['Activity']['end_hours']; ?></p>
	<p><span>Data: </span> <?php echo $activities['Activity']['date']; ?></p>
</div>

<h2 id="ApontamentosEmAtividades">
	Apontamentos 
</h2>

<div class="entry index">

	<table cellpadding="0" cellspacing="0">
		<tr>
			<th class="responsive">Atividade</th>
			<th class="responsive">Consultor</th>
			<th>Tipo</th>
			<th class="responsive">Horas Trabalhadas</th>
			<th class="responsive">Data</th>			
			<th class="actions">Visualizar Detalhadamente</th>
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
			<td class="atividade"><?php echo $entry['Activity']['description']; ?></td>
			<td class="consultor"><?php echo $entry['Consultant']['name']; ?></td>
			<td class="tipo"><?php echo $entry['Entry']['type_consulting']; ?></td>
			<td class="horas trabalhadas"><?php echo $entry['Entry']['hours_worked']; ?></td>
			<td class="data"><?php echo $entry['Entry']['date']; ?></td>
			<div>
				<td class="actions">
					<?php
						if ($entry['Entry']['activity_id']===$activities['Activity']['id']) {
							echo $this->html->link(
							$this->html->image("view.png", array('alt' => 'Ver')), array('action' => '../entries/view', $entry['Entry']['id']), array('escape'=>false, 'id'=>'link'));
					}
					?>
				</td>
			</div>
		</tr>
		<?php } ?>
	</table>
	
</div>