<?php

namespace App\Services;

class UltiPro
{
	const LOGIN_URL = 'https://service4.ultipro.com/services/LoginService';
    const EMP_URL = 'https://service4.ultipro.com/services/EmployeePerson';
    const BI_URL = 'https://service4.ultipro.com/services/BIDataService';

	/**
	 * Login to UltiPro.
     * 
	 * @return string $token
	 */
	private function login()
	{
		$client = new \SoapClient(self::LOGIN_URL, array('soap_version' => SOAP_1_2, 'exceptions' => TRUE, 'trace' => TRUE));

        $headers = array();
        $headers[0] = new \SoapHeader('http://www.w3.org/2005/08/addressing', 'Action', 'http://www.ultipro.com/services/loginservice/ILoginService/Authenticate', true);
        $headers[1] = new \SoapHeader('http://www.ultipro.com/services/loginservice', 'ClientAccessKey', env('ULTIPRO_CKEY'));
		$headers[2] = new \SoapHeader('http://www.ultipro.com/services/loginservice', 'Password', env('ULTIPRO_PW'));
		$headers[3] = new \SoapHeader('http://www.ultipro.com/services/loginservice', 'UserAccessKey', env('ULTIPRO_UKEY'));
        $headers[4] = new \SoapHeader('http://www.ultipro.com/services/loginservice', 'UserName', env('ULTIPRO_USER'));

        $client->__setSoapHeaders($headers);
		$response = $client->Authenticate();

		try {
			return $response->Token;
		} catch (Exception $e) {
			return $e;	
		}
        
	}

    /**
     * Get employee info.
     * 
     * @param $empid EmployeeID
     * @return $status boolean
     */
    public function getEmpById($empid)
    {

        $token = self::login();
        $ckey = env('ULTIPRO_CKEY');
        $ccode = env('ULTIPRO_COMPANY_CODE');

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://service4.ultipro.com/services/EmployeePerson/",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "<s:Envelope xmlns:a=\"http://www.w3.org/2005/08/addressing\" xmlns:s=\"http://www.w3.org/2003/05/soap-envelope\">\r\n  <s:Header>\r\n  <a:Action s:mustUnderstand=\"1\">http://www.ultipro.com/services/employeeperson/IEmployeePerson/GetPersonByEmployeeIdentifier</a:Action> \r\n  <UltiProToken xmlns=\"http://www.ultimatesoftware.com/foundation/authentication/ultiprotoken\">".$token."</UltiProToken> \r\n  <ClientAccessKey xmlns=\"http://www.ultimatesoftware.com/foundation/authentication/clientaccesskey\">".$ckey."</ClientAccessKey> \r\n  </s:Header>\r\n  <s:Body>\r\n  <GetPersonByEmployeeIdentifier xmlns=\"http://www.ultipro.com/services/employeeperson\">\r\n  <employeeIdentifier xmlns:b=\"http://www.ultipro.com/contracts\" xmlns:i=\"http://www.w3.org/2001/XMLSchema-instance\" i:type=\"b:EmployeeNumberIdentifier\">\r\n  <b:CompanyCode>".$ccode."</b:CompanyCode> \r\n  <b:EmployeeNumber>".$empid."</b:EmployeeNumber> \r\n  </employeeIdentifier>\r\n  </GetPersonByEmployeeIdentifier>\r\n  </s:Body>\r\n  </s:Envelope>\r\n",
            CURLOPT_HTTPHEADER => array(
            "action: http://www.ultipro.com/services/employeeperson/IEmployeePerson/GetPersonByEmployeeIdentifier",
            "cache-control: no-cache",
            "content-type: application/soap+xml; charset=utf-8",
          ),
        ));

        try {
            
            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);


            if ($err) {
              return "cURL Error #:" . $err;
            }

            $xml = simplexml_load_string($response);
            $rxml = $xml->children('s', true)->Body->children('http://www.ultipro.com/services/employeeperson')->GetPersonByEmployeeIdentifierResponse->GetPersonByEmployeeIdentifierResult;
            $opresult = $rxml->children("http://www.ultipro.com/contracts")->OperationResult;
            $array = array();

            if(strcmp($opresult->HasErrors, 'true') == 0){
                $json = json_encode($opresult);
                $array = json_decode($json,TRUE);
            }
            else{
                $person = $rxml->children("http://www.ultipro.com/contracts")->Results->Person;

                $json = json_encode($person);
                $array = json_decode($json,TRUE);
            }

            return $array;
            
        } catch (Exception $e) {
            return $e;
        }

    }

    /**
     * Validate if employee ID is valid.
     * 
     * @param $empid employee ID to validate
     * @return boolean true if validated, false if not validated
     */
    public function validateId($empid)
    {

        $emp = UltiPro::getEmpById($empid);
        if(isset($emp['HasErrors']))
            return false;
        else{
            return $emp;
        }

    }

    /**
     * Query employees.
     * 
     * @param $empid EmployeeID
     * @return string $token
     */
    public function findEmployees($start_date = null, $empid = null, $lastname = null)
    {
        
        $token = self::login();
        $ckey = env('ULTIPRO_CKEY');

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://service4.ultipro.com/services/EmployeePerson/",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "<s:Envelope xmlns:a=\"http://www.w3.org/2005/08/addressing\" xmlns:s=\"http://www.w3.org/2003/05/soap-envelope\">\r\n  <s:Header>\r\n  <a:Action s:mustUnderstand=\"1\">http://www.ultipro.com/services/employeeperson/IEmployeePerson/FindPeople</a:Action> \r\n  <UltiProToken xmlns=\"http://www.ultimatesoftware.com/foundation/authentication/ultiprotoken\">".$token."</UltiProToken> \r\n  <ClientAccessKey xmlns=\"http://www.ultimatesoftware.com/foundation/authentication/clientaccesskey\">".$ckey."</ClientAccessKey> \r\n  </s:Header>\r\n  <s:Body>\r\n  <FindPeople xmlns=\"http://www.ultipro.com/services/employeeperson\">\r\n  <query xmlns:b=\"http://www.ultipro.com/contracts\" xmlns:i=\"http://www.w3.org/2001/XMLSchema-instance\">\r\n  <b:CompanyCode /> \r\n  <b:CompanyName /> \r\n  <b:Country /> \r\n  <b:EmployeeNumber /> \r\n  <b:FirstName /> \r\n  <b:FormerName /> \r\n  <b:FullOrPartTime /> \r\n  <b:Job /> \r\n  <b:LastHire /> \r\n  <b:LastName /> \r\n  <b:Location /> \r\n  <b:OrganizationLevel1 /> \r\n  <b:OrganizationLevel2 /> \r\n  <b:OrganizationLevel3 /> \r\n  <b:OrganizationLevel4 /> \r\n  <b:OriginalHire></b:OriginalHire> \r\n  <b:PageNumber /> \r\n  <b:PageSize /> \r\n  <b:PayGroup /> \r\n  <b:Status>= A</b:Status> \r\n  <b:SupervisorLastName /> \r\n  <b:TerminationDate /> \r\n  <b:TimeClockId /> \r\n  </query>\r\n  </FindPeople>\r\n  </s:Body>\r\n  </s:Envelope>\r\n",
            CURLOPT_HTTPHEADER => array(
                "action: http://www.ultipro.com/services/employeeperson/IEmployeePerson/FindPeople",
                "cache-control: no-cache",
                "content-type: application/soap+xml; charset=utf-8",
                "postman-token: f583e142-07ee-938e-4866-1e297a78b701"
          ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
          return "cURL Error #:" . $err;
        }

        $xml = simplexml_load_string($response);
        $rxml = $xml->children('s', true)->Body->children('http://www.ultipro.com/services/employeeperson')->FindPeopleResponse->FindPeopleResult;
        $opresult = $rxml->children("http://www.ultipro.com/contracts")->OperationResult;

        if(strcmp($opresult->HasErrors, 'true') == 0){
            return $opresult->Messages->OperationMessage->Message;
        }
        else{

            $people = $rxml->children("http://www.ultipro.com/contracts")->Results;

            $json = json_encode($people);
            $array = json_decode($json,TRUE);
            $arr = $array["EmployeePerson"];

            return $array;
        }

    }

    /**
     * BI service.
     *
     * @return void
     */
    public function getBI()
    {
        
        $token = self::login();

        $client = new \SoapClient(self::BI_URL, array('soap_version' => SOAP_1_2, 'exceptions' => TRUE, 'trace' => TRUE));

        $headers = array();
        $headers[] = new \SoapHeader('http://www.w3.org/2005/08/addressing', 'Action', 'http://www.ultipro.com/dataservices/bidata/2/IBIDataService/LogOn', true);
        $headers[] = new \SoapHeader('http://www.w3.org/2005/08/addressing', 'To', 'https://servicehost/services/BiDataService', true);

        $user = new \SoapVar(env('ULTIPRO_USER'), XSD_STRING, null, null, 'UserName');
        $pw = new \SoapVar(env('ULTIPRO_PW'), XSD_STRING, null, null, 'Password');
        $ckey = new \SoapVar(env('ULTIPRO_CKEY'), XSD_STRING, null, null, 'ClientAccessKey');
        $ukey = new \SoapVar(env('ULTIPRO_UKEY'), XSD_STRING, null, null, 'UserAccessKey');

        $arr = new \ArrayObject();
        $arr->append($user);
        $arr->append($pw);
        $arr->append($ckey);
        $arr->append($ukey);

        $params = new \SoapVar(
            $arr, SOAP_ENC_OBJECT, null, null, 'logOnRequest', 'http://www.w3.org/2001/XMLSchema-instance'
        );

        $final = new \ArrayObject();
        $final->append($params);

        $client->__setSoapHeaders($headers);
        $client->LogOn(new \SoapParam(new \SoapVar($final, SOAP_ENC_OBJECT), 'LogOn'));

        try {
            // return htmlentities($client->__getLastRequest());   
            return htmlentities($client->__getLastResponse());
        } catch (Exception $e) {
            return $e;  
        }

    }

}