<?php


define("PAC",1);
define("SEDEX",2);
define("OUTROS",3);



class Pagseguro extends Service
{

	public $stage='SANDBOX';


	public $sandboxToken = 'SANDBOXSANDBOXSANDBOXSANDBOXSANDBOXSANDBOX';
	public $sandboxCheckoutUrl = 'https://ws.sandbox.pagseguro.uol.com.br/v2/checkout';
	public $sandboxPaymentUrl =   'https://sandbox.pagseguro.uol.com.br/v2/checkout/payment.html';
	public $sandboxNotificationsUrl = 'https://ws.sandbox.pagseguro.uol.com.br/v2/transactions/notifications/';
	

	public $productionToken = 'PRODUCTIONPRODUCTIONPRODUCTIONPRODUCTIONPRODUCTION';
	public $productionCheckoutUrl = 'https://ws.pagseguro.uol.com.br/v2/checkout';
	public $productionPaymentUrl = 'https://pagseguro.uol.com.br/v2/checkout/payment.html';
	public $productionNotificationsUrl = 'https://ws.pagseguro.uol.com.br/v2/transactions/notifications/';


	public $registeredEmail;
	public $registeredToken;
	public $currency;
	public $returnUrl;
	public $redirectUrl;
	public $sender;
	public $shipping;
	public $products;

	
	private function afterConstruct() 
	{
		$this->loadService( 'requests' );
	}
 

 	public function checkout(){
 		
 	}


}