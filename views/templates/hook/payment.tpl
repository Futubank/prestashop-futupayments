<style>
	p.payment_module > a.futubank {
		background-position: 15px 50%;
		background-repeat: no-repeat;
	}
</style>

<div class="row">
	<div class="col-xs-12">
		<p class="payment_module">
			<a href="javascript:void(0)" onclick="javascript:document.getElementById('futubank_form').submit();" title="{l s='Оплата банковской картой' mod='futubank'}" class="bankwire futubank">
				{l s='Оплата банковской картой' mod='futubank'}</span>
			</a>
		</p>
	</div>
</div>

<form class="hidden" id="futubank_form" method="post" name="futubank_form" action="{$action}">
{$form_fields}
</form>
