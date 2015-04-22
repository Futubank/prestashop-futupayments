<style>
	p.payment_module > a.futubank {
		/* background-image: url({$logo});*/
		background-position: 15px 50%;
		background-repeat: no-repeat;
	}
</style>

<div class="row">
	<div class="col-xs-12">
		<p class="payment_module">
			<a href="javascript:void(0)" onclick="javascript:document.getElementById('futubank_form').submit();" title="{l s='Pay by Futubank' mod='futubank'}" class="bankwire futubank">
				{l s='Pay by Futubank' mod='futubank'}</span>
			</a>
		</p>
	</div>
</div>

<form class="hidden" id="futubank_form" method="post" name="futubank_form" action="{$action}">
{$form_fields}
</form>
