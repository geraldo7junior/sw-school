<?php
header('Content-Type: text/html; charset=UTF-8');
?>

	<script type="text/javascript">
		$(document).ready(function() {
			/*
			 *  Simple image gallery. Uses default settings
			 */

			$('.fancybox').fancybox();

			/*
			 *  Different effects
			 */

			// Change title type, overlay closing speed
			$(".fancybox-effects-a").fancybox({
				helpers: {
					title : {
						type : 'outside'
					},
					overlay : {
						speedOut : 0
					}
				}
			});

			// Disable opening and closing animations, change title type
			$(".fancybox-effects-b").fancybox({
				openEffect  : 'none',
				closeEffect	: 'none',

				helpers : {
					title : {
						type : 'over'
					}
				}
			});

			// Set custom style, close if clicked, change title type and overlay color
			$(".fancybox-effects-c").fancybox({
				wrapCSS    : 'fancybox-custom',
				closeClick : true,

				openEffect : 'none',

				helpers : {
					title : {
						type : 'inside'
					},
					overlay : {
						css : {
							'background' : 'rgba(238,238,238,0.85)'
						}
					}
				}
			});

			// Remove padding, set opening and closing animations, close if clicked and disable overlay
			$(".fancybox-effects-d").fancybox({
				padding: 0,

				openEffect : 'elastic',
				openSpeed  : 150,

				closeEffect : 'elastic',
				closeSpeed  : 150,

				closeClick : true,

				helpers : {
					overlay : null
				}
			});

			/*
			 *  Button helper. Disable animations, hide close button, change title type and content
			 */

			$('.fancybox-buttons').fancybox({
				openEffect  : 'none',
				closeEffect : 'none',

				prevEffect : 'none',
				nextEffect : 'none',

				closeBtn  : false,

				helpers : {
					title : {
						type : 'inside'
					},
					buttons	: {}
				},

				afterLoad : function() {
					this.title = 'Image ' + (this.index + 1) + ' of ' + this.group.length + (this.title ? ' - ' + this.title : '');
				}
			});


			/*
			 *  Thumbnail helper. Disable animations, hide close button, arrows and slide to next gallery item if clicked
			 */

			$('.fancybox-thumbs').fancybox({
				prevEffect : 'none',
				nextEffect : 'none',

				closeBtn  : false,
				arrows    : false,
				nextClick : true,

				helpers : {
					thumbs : {
						width  : 50,
						height : 50
					}
				}
			});

			/*
			 *  Media helper. Group items, disable animations, hide arrows, enable media and button helpers.
			*/
			$('.fancybox-media')
				.attr('rel', 'media-gallery')
				.fancybox({
					openEffect : 'none',
					closeEffect : 'none',
					prevEffect : 'none',
					nextEffect : 'none',

					arrows : false,
					helpers : {
						media : {},
						buttons : {}
					}
				});

			/*
			 *  Open manually
			 */

			$("#fancybox-manual-a").click(function() {
				$.fancybox.open('1_b.jpg');
			});

			$("#fancybox-manual-b").click(function() {
				$.fancybox.open({
					href : 'iframe.html',
					type : 'iframe',
					padding : 5
				});
			});

			$("#fancybox-manual-c").click(function() {
				$.fancybox.open([
					{
						href : '1_b.jpg',
						title : 'My title'
					}, {
						href : '2_b.jpg',
						title : '2nd title'
					}, {
						href : '3_b.jpg'
					}
				], {
					helpers : {
						thumbs : {
							width: 75,
							height: 50
						}
					}
				});
			});


		});
	</script>
	
	<h1 id="titulo">Atividades</h1>
	<table class="zebra" id="tabela_atividades" cellpadding="0" cellspacing="0">
		<tr>

			<th>Descrição</th>
			<th>Consultor(es)</th>
			<th>Horário</th>
			<th class="actions">Ações</th>
		</tr>

		<?php
			
			$i = 0;
			foreach ($activities as $activity) 
			{
				$class = null;
				
				if($i++ % 2 == 0)
				{
					$class = 'class="altrow"';
					foreach($attachments as $attachment){
						
						$list_attachments[$attachment['Attachment']['id']] = $attachment['Attachment']['file_name'];
						
						
					}
				}
					
							
		?>

		<tr <?php echo $class; ?>>

			<td class="descrição"><?php echo $activity['activities']['description']; ?></td>
			<td class="consultores"><?php echo $activity['activities']['consultant1_id'].$activity['activities']['consultant2_id'].$activity['activities']['consultant3_id'].$activity['activities']['consultant4_id']; ?></td>
			<td class="periodo"><?php echo 'De: '.$activity['activities']['start_hours'].' '.$activity['activities']['start_date'].' à '.$activity['activities']['end_hours'].' '.$activity['activities']['end_date']; ?></td>
         
	
				<td>
					<div>
					<?php echo $this->Html->link(
					$this->Html->image("view.png", array('alt' => 'Ver','title'=>'Visualizar')), array('action' => 'view', $activity['activities']['id']), array('escape'=>false, 'id'=>'link'))?>

					<?php 
						if (in_array($tipo_usuario , array('admin','cons_manager','rel_manager'))){
							echo $this->Html->link($this->Html->image("edit.png", array('alt' => 'Editar','title'=>'Editar')), array('action' => 'edit', $activity['activities']['id'], $activity['activities']['project_id']),
							array('escape'=>false, 'id'=>'link'));
						}
					?>					
					                							
					<?php 
						if (in_array($tipo_usuario , array('admin','cons_manager','rel_manager'))){
							echo $this->Html->link($this->Html->image("delete.png", array('alt' => 'Remover','title'=>'Excluir')), array('action' => 'delete', $activity['activities']['id'], $activity['activities']['project_id']),
							array('escape'=>false, 'id'=>'link'), "Confirmar exclusão da atividade?");
						}
					?>
						<br>

					<a href="../../entries/add/<?php echo $activity['activities']['id']."/".$activity['activities']['project_id'] ?>"><?php echo $this->Html->image("clock.png",array('alt'=>'Apontar', 'title' => 'Apontar', 'id' => 'btnRelogio'));?></a>


					</div>
				</td>
			
		</tr>

		<?php } ?>
	</table>
	<br>
	<center><?php echo $this->Html->link("Cadastrar Atividade", array('action' => '../activities/add/'.$project['Project']['id']),array('class'=>'botao', 'id'=>'botao-cadastrar-atividade'));?></center>
<br>
<br>
