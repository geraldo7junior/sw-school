<a href="../../Consultants/index" class="botao" alt="Cancelar"> Cancelar </a>
<h2>Editar Consultor</h2>

 <?php echo $this->Form->create('Consultant', array('action' => 'edit')); ?>
 <script language="JavaScript" type="text/javascript">
function HandleBrowseClick()
{
    var fileinput = document.getElementById("foto");
    fileinput.click();
}
function Handlechange()
{
var fileinput = document.getElementById("foto");
var textinput = document.getElementById("filename");
textinput.value = fileinput.value;
}
</script>
 			<div class="left" >
			<fieldset id="dados_pessoais_edit">
				<legend class="legenda">Dados Pessoais</legend>
					<?php echo $this->Form->input('Consultant.id', array('type' => 'hidden')); ?>
					<?php echo $this->Form->input('Consultant.name', array('label' => 'Nome <sup title="Campo obrigatório" class="obrigatorio">*</sup>: ','required'=>'required','placeholder'=>'', 'id'=>'name')); ?>
					<?php echo $this->Form->input('Consultant.cpf', array('label' => 'CPF <sup title="Campo obrigatório" class="obrigatorio">*</sup>: ','required'=>'required','placeholder'=>'', 'id'=>'cpf','div'=>'div_cpf','onblur'=>'checkCPF(this)')); ?>
					<?php echo $this->Form->input('Consultant.acronym', array('label' => 'Abreviação do Nome: ', 'id'=>'acronym')); ?>
					<?php echo $this->Form->input('Consultant.acronym_color', array('type'=> 'text','label' => 'Cor <sup title="Campo obrigatório" class="obrigatorio">*</sup>: ', 'id'=>'acronym_color')); ?>
						<?php echo $this->Form->input('Consultant.phone1', array('label' => 'Telefone <sup title="Campo obrigatório" class="obrigatorio">*</sup>: ', 'required'=>'required' )); ?>
					<?php echo $this->Form->input('Consultant.phone2', array('label' => 'Celular <sup title="Campo obrigatório" class="obrigatorio">*</sup>: ', 'required'=>'required')); ?>
					<?php echo $this->Form->input('Consultant.email', array('type' => 'email','label' => 'E-mail <sup title="Campo obrigatório" class="obrigatorio">*</sup>: ', 'required'=>'required', 'id'=>'email')); ?>					
			</fieldset>
			<fieldset id="dados_bancarios_edit_consultor">
					<legend class="legenda">Dados Bancários</legend>

						<?php echo $this->Form->input('BankInfoConsultant.id', array('type' => 'hidden')); ?>
						
						<?php echo $this->Form->input('BankInfoConsultant.name_bank', array('label' => 'Nome do Banco: ', 'id'=>'BankInfoConsultant.name_bank')); ?>
				
						<?php echo $this->Form->input('BankInfoConsultant.number_agency', array('label' => 'Número da Agência: ', 'id'=>'BankInfoConsultant.number_agency')); ?>

						<?php echo $this->Form->input('BankInfoConsultant.number_account', array('label' => 'Número da Conta: ', 'id'=>'BankInfoConsultant.number_account')); ?>
											
				</fieldset>
			</div>
			<div class="right">
			<fieldset id="enderecoAddConsultor">
				<legend class="legenda">Endereço</legend>
					<?php echo $this->Form->input('Address.id', array('type' => 'hidden')); ?>
					<?php echo $this->Form->input('Address.zip_code', array('label' => 'CEP: ', 'id'=>'zip_code')); ?>
					<?php echo $this->Form->input('Address.address', array('label' => 'Endereço: ', 'id'=>'address')); ?>
					<?php echo $this->Form->input('Address.number', array('label' => 'Número: ')); ?>
					<?php echo $this->Form->input('Address.complement', array('label' => 'Complemento: ')); ?>
					<?php echo $this->Form->input('Address.neighborhood', array('label' => 'Bairro: ','id'=>'neighborhood')); ?>
					<?php echo $this->Form->input('Address.city', array('label' => 'Cidade: ', 'id'=>'city')); ?>
					<?php echo $this->Form->input('Address.state', array('options' => array("AC"=>"AC","AL"=>"AL","AP"=>"AP","AM"=>"AM","BA"=>"BA","CE"=>"CE","DF"=>"DF","ES"=>"ES","GO"=>"GO","MA"=>"MA","MG"=>"MG","MT"=>"MT","MS"=>"MS","PA"=>"PA","PB"=>"PB","PE"=>"PE","PI"=>"PI","PR"=>"PR","RJ"=>"RJ","RN"=>"RN","RO"=>"RO","RR"=>"RR","RS"=>"RS","SC"=>"SC","SE"=>"SE","SP"=>"SP","TO"=>"TO"),'type' => 'select', 'empty' => 'Selecione','label' => 'Estado: ','style'=>"width: 260px", 'id'=>'state')); ?>
					
			</fieldset>

			<fieldset id='usuario_edit'>
        			<legend>Usuário</legend>
					<?php echo $this->Form->input('User.id', array('type' => 'hidden')); ?>
        			<?php echo $this->Form->input('User.username',array('label' => 'Usuário <sup title="Campo obrigatório" class="obrigatorio">*</sup>: ', 'id' => 'campo_usuario','required'=>'required')); ?>
        			<p></p>
        			<?php echo $this->Form->input('User.password', array('label' => 'Senha <sup title="Campo obrigatório" class="obrigatorio">*</sup>: ', 'id' => 'senha','required'=>'required')); ?>
        			<p></p>
        			<?php echo $this->Form->input('User.type', array('label' => 'Tipo de Usuário <sup title="Campo obrigatório" class="obrigatorio">*</sup>: ','required'=>'required', 'empty' => 'Selecione', 'id' => 'tipousuario',
            		'options' => array('cons' => 'Consultor', 'cons_manager' => 'Gerente de consultoria', 'fin_manager' => 'Gerente financeiro',  'rel_manager' => 'Gerente de relacionamento', 'admin' => 'Admin'))); ?>
 
 	 
					<!--<?php echo $this->Html->image('consultant.jpg')?>
		
					<input type="file" id="foto" name="fileupload" style="display: none" onChange="Handlechange();" action="Foto"/>
    				<input type="button" value="Foto" id="fakeBrowse" onclick="HandleBrowseClick();"/>-->

    		</fieldset>

    

			</div>
			<?php echo $this->Form->end('Salvar Edição'); ?>
		</form>
	