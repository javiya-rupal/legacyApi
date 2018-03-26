# legacyApi
Legacy API is an API for recharge topup in mobile SIM with some static data used as dataset for an application

Below are the SIM number which are currently support in this API (statically)
'37250123123' => ['number' => '37250123123', 'blocked' => 'false', 'balance' => '72.00', 'curr' => 'USD']
'8132471896' => ['number' => '8132471896', 'blocked' => 'false', 'balance' => '32.00', 'curr' => 'EUR']
'02071838750' => ['number' => '02071838750', 'blocked' => 'true', 'balance' => '20.00', 'curr' => 'EUR']
'4155552671' => ['number' => '4155552671', 'blocked' => 'false', 'balance' => '-4.99', 'curr' => 'USD']
'8885739922' => ['number' => '8885739922', 'blocked' => 'false', 'balance' => '-10.00', 'curr' => 'USD']

Below are Http authentication credentials for calling this API
username: codeuser
password: codepass

Currenctly supported method of Legacy API are (i) getBalance (ii) addBalance and it can be called as below:

getBalance API - http://127.0.0.1/legacyApi/?action=getBalance&number=8132471896
addBalanceAPI - http://127.0.0.1/legacyApi/?action=addBalance&number=8132471896&curr=EUR&amt=5

