			<fieldset>
				<legend><?= SyTranslator::Users_Authorizations($lang) ?></legend>
					<button onclick="location.href='sygrrif/visa'"
						class="btn btn-link" id="navlink"><?= SyTranslator::Visa($lang) ?></button>
					<button onclick="location.href='sygrrif/addvisa'"
						class="btn btn-link" id="navlink"><?= SyTranslator::Add($lang) ?></button>
				<br/>
					<button onclick="location.href='sygrrif/authorizations'"
						class="btn btn-link" id="navlink"><?= SyTranslator::Active_Authorizations($lang) ?></button>
					<button onclick="location.href='sygrrif/uauthorizations'"
						class="btn btn-link" id="navlink"><?= SyTranslator::Unactive_Authorizations($lang) ?></button>
					<button onclick="location.href='sygrrif/addauthorization'"
						class="btn btn-link" id="navlink"><?= SyTranslator::Add_Authorizations($lang) ?></button>
			</fieldset>
