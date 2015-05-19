<?php

class FutubankSuccessModuleFrontController extends ModuleFrontController
{
	public $ssl = true;
	public $module;

	public function initContent()
	{
		parent::initContent();

		$cart = $this->context->cart;
		$qty = $cart->nbProducts();
		$this->context->smarty->assign('nbProducts', $qty);
		
		if (!Validate::isLoadedObject($cart) || $qty < 1)
		{
			// Logger::AddLog('Futubank_Success: Error '.$this->module->l('Cart number is not specified'), 3, null, null, null, true);
			$this->setTemplate('error.tpl');
		} 
		else 
		{
			$ordernumber = Order::getOrderByCartId($cart->id);
			
			if (!$ordernumber)
			{
				// Logger::AddLog('Futubank_Success: Error '.$this->module->l('Order number is not specified'), 3, null, null, null, true);
				$this->setTemplate('error.tpl');
			}
			else
			{
				$order = new Order((int)$ordernumber);
				$customer = new Customer((int)$order->id_customer);

				if ($order->hasBeenPaid())
				{
					// Logger::AddLog('Futubank_Success: #'.$order->id.' '.$this->module->l('Order paid'), 3, null, null, null, true);
					Tools::redirectLink(__PS_BASE_URI__.'order-confirmation.php?key='.$customer->secure_key.'&id_cart='.(int)$order->id_cart.'&id_module='.(int)$this->module->id.'&id_order='.(int)$order->id);
				}
				else 
				{
					// Logger::AddLog('Futubank_Success: #'.$order->id.' '.$this->module->l('Order wait payment'), 3, null, null, null, true);
					$this->setTemplate('paymentWait.tpl');
				}	
			}
		}
	}
}