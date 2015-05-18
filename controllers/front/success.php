<?php

class FutubankSuccessModuleFrontController extends ModuleFrontController
{
	public $ssl = true;
	public $module;

	public function initContent()
	{
		parent::initContent();

		// $ordernumber = Tools::getValue('id_cart', 0);
		$this->context->smarty->assign('ordernumber', $ordernumber);
		$this->context->smarty->assign('time', date('Y-m-d H:i:s'));

		$cart = new Cart((int)$this->context->cookie->id_cart);

		$ordernumber = Order::getOrderByCartId($cart->id);
		$order = new Order((int)$ordernumber);
		$customer = new Customer((int)$order->id_customer);

		if ($order->hasBeenPaid())
		{
			Tools::redirectLink(__PS_BASE_URI__.'order-confirmation.php?key='.$customer->secure_key.'&id_cart='.(int)$order->id_cart.'&id_module='.(int)$this->module->id.'&id_order='.(int)$order->id);
		}
	}
}