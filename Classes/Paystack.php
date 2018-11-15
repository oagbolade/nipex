<?php
	/**
	 * Bank
   * 
   * This class is used to interact with the Paystack Online Payment Gateway
   * @author      Alabi A. <alabi.adebayo@alabiansolutions.com>
   * @copyright   2018 Alabian Solutions Limited
   * @link        alabiansolutions.com
	 */
	class Paystack{
		private $_privateKey;
		private $_publicKey;
		private $_getName;
		
		/**
     * Assign value to both private and public key
     * @param string $privateKey paystack private key
     * @param string $publicKey paystack public key
		 * @param string $getName $_GET index for reference passage
		 * @return void
     */
    public function __construct($privateKey, $publicKey, $getName){
      $this->_privateKey = $privateKey;
			$this->_publicKey = $publicKey;
			$this->_getName = $getName;
    }
		
		/**
		 * Create the payment button 
		 * @param string $reference unquie transaction no
		 * @param integer $amount amount payable in kobo
		 * @param sting $email email of the payer
		 * @param string $redirect the url response for payment will be redirect to
		 * @return string $button an html form for payment button
		 */
		public function payButton($reference, $amount, $email, $redirect){
			$getName = $this->_getName;
			$publicKey = $this->_publicKey;
			$button = $payStackButton = "
					<form action='$redirect?$getName=$reference' method='POST' class='text-center'>
					  <script
					    src='https://js.paystack.co/v1/inline.js' 
					    data-key='$publicKey'
					    data-email='$email'
					    data-amount='$amount'
					    data-ref='$reference'
					  >
					  </script>
					</form>
				";
			return $button;
		} 
		
		/**
		 * check the status of a transaction no
		 * @param string $reference unquie transaction no
		 * @return array $check the status of the transaction no
		 */	
		public function checkReferenceNo($reference){
			$privateKey = $this->_privateKey;
			$check = ['status' => false, 'error' => 'Unknown Error']; 
			$curl = curl_init();
			$curlSetOpt = [
			  CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . rawurlencode($reference),
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_HTTPHEADER => [
			    "accept: application/json",
			    "authorization: Bearer $privateKey",
			    "cache-control: no-cache"
			  ]
			];
			if(DEVELOPMENT) $curlSetOpt[CURLOPT_SSL_VERIFYPEER] = false;
			curl_setopt_array($curl, $curlSetOpt);
			
			$response = curl_exec($curl);
			$err = curl_error($curl);
	
			if($err){
				$check = ['status' => false, 'error' => $err];
			}
			else {
				$tranx = json_decode($response);
				if(!$tranx->status){
				  $check = ['status' => false, 'error' => $tranx->message];
				}
				
				if('success' == $tranx->data->status){
				  $check = ['status' => $tranx->data, 'error' => null];
				}
			}
			return $check;
			
		}
		
		
	}	