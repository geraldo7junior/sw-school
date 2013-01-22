<h1 id="titulo">Atividade - <?php echo $activities['Activity']['id']; ?> 
	<span class="icon-action"><?php echo $this->Html->link(
		$this->Html->image("delete.png", array("alt" => "Deletar")),
		array('action' => 'delete', $activities['Activity']['id']),
		array('escape'=>false),"Você quer excluir realmente ?");?>
	</span>
	<span class="icon-action"> <?php echo $this->Html->link(
		$this->Html->image("edit.png", array("alt" => "Editar")),'edit/'.$activities['Activity']['id'],
		array('escape'=>false)) ?>
	</span> 
</h1>


<div id="dados"> 
	<h2 id="titulodados"> Informações </h2>
	<p><span>Tipo: </span><?php echo $activities['Activity']['type']; ?></p>
	<p><span>Status: </span><?php echo $activities['Activity']['status']; ?></p>
	<p><span>Observações: </span><?php echo $activities['Activity']['observations']; ?></p>
</div>

<div id="dados">
	<h2 id="titulodados">Horários</h2>
	<p><span>Hora inicial: </span> <?php echo $activities['Activity']['start_hours']; ?></p>
	<p><span>Hora final: </span> <?php echo $activities['Activity']['end_hours']; ?></p>
	<p><span>Data: </span> <?php echo $activities['Activity']['date']; ?></p>
	<p><span>Horas trabalhadas: </span> <?php echo $activities['Activity']['hours_worked']; ?></p>
</div>

<div id="dadosApontamentos">
	<h2 id="titulodados">Apontamentos Existentes</h2>

	<table cellpadding="0" cellspacing="0" id="tabelaApontamentos">
		<tr>
			<th>Consultor</th>
			<th class="responsive">Atividade</th>
			<th class="responsive">Horas</th>
			<th class="responsive">Data</th>
			<th class="actions">Ações</th>
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
			<td class="consultor"><?php echo $entry['Entry']['consultant_id']; ?></td>
			<td class="atividade"><?php echo $entry['Entry']['activity_id']; ?></td>
			<td class="horas trabalhadas"><?php echo $entry['Entry']['hours_worked']; ?></td>
			<td class="data"><?php echo $entry['Entry']['date']; ?></td>

			<div class="actions">
				<td>
					<?php echo $this->Html->link(
					$this->Html->image("view.png", array('alt' => 'Ver')), array('action' => 'view', $entry['Entry']['id']), array('escape'=>false, 'id'=>'link'))?>

					<?php echo $this->Html->link(
					$this->Html->image("edit.png", array('alt' => 'Editar')), array('action' => 'edit', $entry['Entry']['id']),
					array('escape'=>false, 'id'=>'link'))?>

					<?php echo $this->Html->link(
					$this->Html->image("delete.png", array('alt' => 'Remover')), array('action' => 'delete', $entry['Entry']['id']),
					array('escape'=>false, 'id'=>'link'), "Confirmar exclusão da atividade?");
					?></td>
			</div>
		</tr>
		<?php } ?>
	</table>
	
</div>
