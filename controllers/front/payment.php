<?php

class FutubankPaymentModuleFrontController extends ModuleFrontController
{
	public $ssl = true;
	
	public function initContent()
	{
		parent::initContent();

		$this->setTemplate('payment.tpl');
	}
}