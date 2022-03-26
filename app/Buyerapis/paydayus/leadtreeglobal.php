<?php


use App\Helpers\CurlHelper;
use Illuminate\Support\Facades\Http;

class leadtreeglobal

{
    var $response = array();

    function __construct($client_detail, $post)
    {

        $monthsAtAddress = floor($post->Residence->monthsAtAddress);
        $monthsAtEmployer = floor($post->Employer->monthsAtEmployer);
        $numberOfMonthsInBank = floor($post->Bank->monthsAtBank);

        // Time at bank
//        $numberOfMonthsInBank = floor($post->bank->bankAccountLength);
//        $date = date("c", strtotime('-' . $numberOfMonthsInBank . " months", strtotime($post->created_at)));
//        $BankAccountOpened = date("c", strtotime($date));
//        $bao = new DateTime($BankAccountOpened, new DateTimeZone("UTC"));
//        $BankAccountOpened = '/Date(' . ($bao->getTimestamp() * 1000) . ')/';


        if ($post->Consent->consentFinancial == '1' ) {
            $post->Consent->consentFinancial = true;
        } else {
            $post->Consent->consentFinancial = false;
        }
        if ($post->Consent->consentThirdPartyEmails == '1' ) {
            $post->Consent->consentThirdPartyEmails = true;
        } else {
            $post->Consent->consentThirdPartyEmails = false;
        }


        $lead = array(
            "AffiliateAPIKey" => "4dd3204d-a01d-452d-ae48-8d8c86343000",
            "affiliateReference" => (string) $post->vid ?? 'AFF_UP150',
            "affiliateSubReference" => (string) $post->subid ?? 'AFF_UP150',
            "affiliateCampaign" => "10",

            "referringUrl" => (string)$post->Source->referringUrl,
            "userAgent" => (string)$post->Source->userAgent,
            "ipAddress" => (string)$post->Source->ipAddress,

            "salutation" => (int) $post->Applicant->nameTitle ?? 1,
            "firstName" => (string)$post->Applicant->firstName,
            "surname" => (string)$post->Applicant->lastName,
            "emailAddress" => (string)$post->Applicant->email,
            "dateOfBirthDay" => (string)$post->Applicant->dateOfBirthDay,
            "dateOfBirthMonth" => (string)$post->Applicant->dateOfBirthMonth,
            "dateOfBirthYear" => (string)$post->Applicant->dateOfBirthYear,
            "maritalStatus" => (string)$post->Applicant->maritalStatus,
            "cellPhoneNumber" => (string)$post->Applicant->mobilePhoneNumber,
            "homePhoneNumber" => (string)$post->Applicant->homePhoneNumber,
            "workPhoneNumber" => (string)$post->Applicant->homePhoneNumber,
            "residentialStatus" => (int)$post->Residence->residentialStatus,

            "consentToCreditSearch" => (bool)$post->Consent->consentCreditSearch,
            "consentToMarketingEmails" => (bool)$post->Consent->consentToMarketingEmails,
            "consentToMarketingSMS" => (bool)$post->Consent->consentToMarketingSMS,

            "abaRoutingTransitNumber" => (string)$post->Bank->bankRoutingNumber,
            "bankAccountNumber" => (string)$post->Bank->bankAccountNumber,
//            "bankCardType" => (string)$post->bank->bankAccountNumber,

            "houseNumber" => (string)$post->Residence->houseNumber,
            "street1" =>  (string)$post->Residence->addressStreet1,
            "townCity" =>  (string)$post->Residence->city,
            "state" =>  (string)$post->Residence->state,
            "zipCode" =>  (string)$post->Residence->zip,
            "monthsAtAddress" =>  (string)$post->Residence->monthsAtAddress,

            "loanAmount" => (int)$post->Loan->loanAmount,
            "employmentStatus" => (int)$post->Employer->employmentStatus,
            "employerName" => (int)$post->Employer->employerName,
            "income" => (int)$post->Employer->monthlyIncome,
            "incomeFrequency" => (int)$post->Employer->incomeCycle,
            "nextPayDateDay" => (int)$post->Employer->nextPayDateDay,
            "nextPayDateMonth" => (int)$post->Employer->nextPayDateMonth,
            "nextPayDateYear" => (int)$post->Employer->nextPayDateYear,
            "followingPayDateDay" => (int)$post->Employer->nextPayDateYear,
            "followingPayDateMonth" => (int)$post->Employer->followingPayDateMonth,
            "followingPayDateYear" => (int)$post->Employer->followingPayDateYear,

//            "MonthsWithEmployer" => (int)$post->employer->incomeSource,

            "drivingLicenseIssuingState" => (string) $post->Applicant->drivingLicenseState,
            "drivingLicenseNumber" => (string) $post->Applicant->drivingLicenseNumber,
            "socialSecurityNumber" => (int) $post->Applicant->ssn,

            "bankName" => (int) $post->Bank->bankName,
            "bankAccountType" => (int) $post->Bank->bankAccountType,
            "monthsWithBank" =>  (string) $post->Bank->monthsAtBank,
            "jobTitle" => (int)$post->Employer->incomeSource,
            "consentToTerms" => (boolean) $post->Consent->consentFinancial
        );



		if($client_detail->mode == 1) {
			$mode = (boolean) false;
			$TestResponseType = '';
		}else{
			$mode = (boolean) true;
			$TestResponseType = 'AcceptedByLenderWithCommission';
		}


		$this->response['post_url'] = ($client_detail->mode == '2') ? $client_detail->post_url_test : $client_detail->post_url_live;
		$this->response['post_url'] = $this->response['post_url'] . $client_detail->parameter1;
		$this->response['post_data'] = $lead;
		$this->response['timeout'] = $client_detail->timeout;
		$this->response['header'] = 'Content-Type: application/json';


//		dd($this->response['post_url']);
        $resp = Http::post( $this->response['post_url'], $this->response['post_data'] );

        dd($resp);
    }

    public function returnresponse()
    {
		$result = (new App\Helpers\CurlHelper)->curl_post(
            $this->response['post_url'],
            $this->response['post_data'],
            $this->response['header'],
            $this->response['timeout']
        );

		$this->response['post_res'] = $result['res'];
		$this->response['post_time'] = $result['post_time'];

		$res_json = json_decode($result['res']);

		$PercentComplete = $res_json->percentComplete;
		$Status = $res_json->status;
		$Commission = $res_json->commission;
		$RedirectUrl = $res_json->redirectUrl;


            if ($Status == 'MatchFound') {
                $this->response['accept'] = 'ACCEPTED';
                $this->response['post_price'] = $Commission;
                $this->response['post_status'] = '1';
                $this->response['redirect_url'] = $RedirectUrl;

            } else {
                $this->response['accept'] = 'REJECTED';
                $this->response['post_status'] = '0';
                $this->response['post_price'] = '0';
            }

            return $this->response;
    }

}
