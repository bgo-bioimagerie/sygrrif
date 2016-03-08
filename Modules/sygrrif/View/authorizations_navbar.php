			<fieldset>
				<legend><?php echo  SyTranslator::Users_Authorizations($lang) ?></legend>
	
				    <button onclick="location.href='sygrrif/addauthorization'"
						class="btn btn-link" id="navlink"><?php echo  SyTranslator::Add_Authorizations($lang) ?></button>
					<button onclick="location.href='sygrrif/authorizations'"
						class="btn btn-link" id="navlink"><?php echo  SyTranslator::Active_Authorizations($lang) ?></button>
					<button onclick="location.href='sygrrif/uauthorizations'"
						class="btn btn-link" id="navlink"><?php echo  SyTranslator::Unactive_Authorizations($lang) ?></button>
					<br/>	
						<button onclick="location.href='sygrrif/visa'"
						class="btn btn-link" id="navlink"><?php echo  SyTranslator::Visa($lang) ?></button>
					<button onclick="location.href='sygrrif/addvisa'"
						class="btn btn-link" id="navlink"><?php echo  SyTranslator::Add($lang) ?></button>
			</fieldset>
