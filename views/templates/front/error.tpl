{capture name=path}
	{l s='Оплата через Futubank' mod='futubank'}
{/capture}

<h1 class="page-heading">
{l s='Информация об оплате' mod='futubank'}
</h1>

{assign var='current_step' value='payment'}
{include file="$tpl_dir./order-steps.tpl"}

{if $nbProducts <=0}
	<p class="alert alert-warning">
	{l s='Ваша корзина пуста' mod='futubank'}
	</p>
{else}
	<form action="{$payment_link}" method="post">
	<input type="hidden" name="cnf" value="1" checked />
	<div class="box cheque-box">
		<h3 class="page-subheading">
		{l s='Оплата через Futubank' mod='futubank'}
		</h3>
		<p class="cheque-indent">
			<strong class="dark">
				{l s='Во время заказа произошла ошибка' mod='futubank'}
			</strong>
		</p>
		<p>
			<div class="alert alert-danger">
			</div>
		</p>
	</div>
	<p class="cart_navigation clearfix" id="cart_navigation">
		<a class="button-executive btn btn-default" href="{$link->getPageLink('order', true, NULL, "step=3")|escape:'html':'UTF-8'}">
			<i class="icon-chevron-left"></i>{l s='Другие методы оплаты' mod='futubank'}
		</a>
	</p>
	</form>
{/if}