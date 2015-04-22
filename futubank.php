<?php

if (!defined('_PS_VERSION_'))
	exit;
	
	
class Futubank extends PaymentModule
{
	public function __construct()
	{
		$this->name = 'futubank';
		$this->tab = 'payments_gateways';
		$this->version = '1.0.0';
		$this->author = 'Futubank';
		$this->controllers = array('payment', 'validation');
		$this->need_instance = 0;
		$this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
		$this->bootstrap = true;
		
		$this->currencies = true;
		$this->currencies_mode = 'checkbox';
		
		parent::__construct();
		
		$this->displayName = $this->l('Futubank');
		$this->description = $this->l('Accept payments for your products via futubank.com');	
		
		if (!Configuration::get('FUTUBANK_MERCHANT_ID'))
			$this->warning = $this->l('Please, fill the field MERCHANT_ID');
			
		if (!Configuration::get('FUTUBANK_SECRET_KEY'))
			$this->warning = $this->l('Please, fill the field SECRET_KEY');
	}
	
	
	public function install()
	{
		if (!parent::install() || 
			!$this->registerHook('payment') || 
			!$this->registerHook('paymentReturn'))
			return false;
		
		Configuration::updateValue('FUTUBANK_MERCHANT_ID', '');
		Configuration::updateValue('FUTUBANK_SECRET_KEY', '');
		
		return true;
	}
	
	
	public function uninstall()
	{
		Configuration::deleteByName('FUTUBANK_MERCHANT_ID');
		Configuration::deleteByName('FUTUBANK_SECRET_KEY');
		
		return parent::uninstall();
	}
	
	public function getContent()
	{
		$output = null;
		
		if (Tools::isSubmit('submit'.$this->name))
		{
			Configuration::updateValue('FUTUBANK_MERCHANT_ID', Tools::getValue('FUTUBANK_MERCHANT_ID'));
			Configuration::updateValue('FUTUBANK_SECRET_KEY', Tools::getValue('FUTUBANK_SECRET_KEY'));
			
			$output .= $this->displayConfirmation($this->l('Settings updated'));
		}
		
		return $output.$this->renderForm();
	}
	
	public function renderForm()
	{
		$default_lang = (int)Configuration::get('PS_LANG_DEFAULT');
		
		$fields_form[0]['form'] = array(
			'legend' => array(
				'title' => $this->l('Settings'),
				'icon' => 'icon-cogs'
			),
			'input' => array(
				array(
					'type' => 'text',
					'label' => $this->l('Merchant ID'),
					'name' => 'FUTUBANK_MERCHANT_ID',
					'required' => true
				),
				array(
					'type' => 'text',
					'label' => $this->l('Secret Key'),
					'name' => 'FUTUBANK_SECRET_KEY',
					'required' => true
				)
			),			
			'submit' => array(
				'title' => $this->l('Save')
			)
		);
		
		$helper = new HelperForm();
		
		$helper->module = $this;
		$helper->name_controller = $this->name;
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;
		
		$helper->default_form_language = $default_lang;
		$helper->allow_employee_form_lang = $default_lang;
		
		$helper->title = $this->displayName;
		$helper->submit_action = 'submit'.$this->name;
		
		$helper->show_toolbar = true;
		$helper->toolbar_scroll = true;
		$helper->toolbar_btn = array(
			'save' => array(
				'desc' => $this->l('Save'),
				'href' => AdminController::$currentIndex.'&configure='.$this->name.'&save'.$this->name.
					'&token'.Tools::getAdminTokenLite('AdminModules')
			),
			'back' => array(
				'desc' => $this->l('Back to list'),
				'href' => AdminController::$currentIndex.'&token='.Tools::getAdminTokenLite('AdminModules')
			)
		);
		
		$helper->fields_value['FUTUBANK_MERCHANT_ID'] = Configuration::get('FUTUBANK_MERCHANT_ID');
		$helper->fields_value['FUTUBANK_SECRET_KEY'] = Configuration::get('FUTUBANK_SECRET_KEY');
		
		return $helper->generateForm($fields_form);
	}
	

	public function checkCurrency($cart)
	{
		$currency_order = new Currency($cart->id_currency);
		$currencies_module = $this->getCurrency($cart->id_currency);

		if (is_array($currencies_module))
			foreach ($currencies_module as $currency_module)
				if ($currency_order->id == $currency_module['id_currency'])
					return true;
		return false;
	}
	
	
	public function hookPayment($params) 
	{
		if (!$this->active)
			return;
			
		if (!$this->checkCurrency($params['cart']))
			return;
			
		$this->smarty->assign(array(
			'this_path' => $this->_path,
			'this_path_bw' => $this->_path,
			'this_path_ssl' => Tools::getShopDomainSsl(true, true).__PS_BASE_URI__.'modules/'.$this->name.'/'
		));
		
		return $this->display(__FILE__, 'payment.tpl');		
	}
}
?>