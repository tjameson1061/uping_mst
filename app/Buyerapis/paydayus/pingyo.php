<?php

use Illuminate\Support\Facades\Log;
use PingYo\Status;
use Illuminate\Support\Facades\Http;

class pingyo
{
    var $response = array();

    function __construct($client_detail, $post)
    {
        
        $this->manageDependencies();
        unset($root, $library, $path);

        try {
            $today = new DateTime("now", new DateTimeZone("UTC"));
        } catch (Exception $e) {
        }



        $dob_day = $post->Applicant->dateOfBirthDay;
        $dob_month = $post->Applicant->dateOfBirthMonth;
        $dob_year = $post->Applicant->dateOfBirthYear;
        if (strlen($dob_day) < 2) {
            $dob_day = '0' . $dob_day;
        }
        if (strlen($dob_month) < 2) {
            $dob_month = '0' . $dob_month;
        }

        if ($dob_month > '12') {
            try {
                $dob = new DateTime($dob_year . '/' . $dob_day . '/' . $dob_month, new DateTimeZone("UTC"));
                $dateOfBirth = '/Date(' . ($dob->getTimestamp() * 1000) . ')/';
                Log::debug('DOB Month > 12::', (array)$dateOfBirth);
            } catch (Exception $e) {
                $dob = strtotime($dob_year . '/' . $dob_day . '/' . $dob_month);
                $dateOfBirth = '/Date(' . $dob . ')/';
                Log::debug('DOB CATCH::', (array)$dateOfBirth);

                if ($dob === '') {
                    $dob = date("U", strtotime($dob_year . '/' . $dob_day . '/' . $dob_month));
                    $dateOfBirth = '/Date(' . $dob . ')/';
                    Log::debug('DOB EMPTY::', (array)$dateOfBirth);
                }
            }
        } else {
                try {
                    $dob = new DateTime($dob_year . '/' . $dob_month . '/' . $dob_day, new DateTimeZone("UTC"));
                    $dateOfBirth = '/Date(' . ($dob->getTimestamp() * 1000) . ')/';
                    Log::debug('DOB TRY::', (array)$dateOfBirth);
                } catch (Exception $e) {
                    $dob = strtotime($dob_year . '/' . $dob_month . '/' . $dob_day);
                    $dateOfBirth = '/Date(' . $dob . ')/';
                    Log::debug('DOB CATCH::', (array)$dateOfBirth);

                    if ($dob === '') {
                        $dob = date("U", strtotime($dob_year . '/' . $dob_month . '/' . $dob_day));
                        $dateOfBirth = '/Date(' . $dob . ')/';
                        Log::debug('DOB EMPTY::', (array)$dateOfBirth);
                    }
                }
            }

        Log::debug('DOB::', (array) $dateOfBirth);

//        dd($post);

        $next_pay_date_day = $post->Employer->nextPayDateDay;
        $next_pay_date_month = $post->Employer->nextPayDateMonth;
        $next_pay_date_year = $post->Employer->nextPayDateYear;
        $npd = new DateTime($next_pay_date_year . '/' . $next_pay_date_month . '/' . $next_pay_date_day, new DateTimeZone("UTC"));
        $nextPayDate = '/Date(' . ($npd->getTimestamp() * 1000) . ')/';
//        $nextPayDate = $next_pay_date_year . '/' . $next_pay_date_month . '/' . $next_pay_date_day;


        $followingPayDateDay = $post->Employer->followingPayDateDay;
        $followingPayDateMonth = $post->Employer->followingPayDateMonth;
        $followingPayDateYear = $post->Employer->followingPayDateYear;
        $fpd = new DateTime($followingPayDateYear . '/' . $followingPayDateMonth . '/' . $followingPayDateDay, new DateTimeZone("UTC"));
        $followingPayDate = '/Date(' . ($fpd->getTimestamp() * 1000) . ')/';

        $numberOfMonthsAtAddress = $post->Applicant->monthsAtAddress;
        $date = date("c", strtotime('-' . $numberOfMonthsAtAddress . " months", strtotime($post->created_at)));
        $AddressMoveIn = date("c", strtotime($date));
        $ami = new DateTime($AddressMoveIn, new DateTimeZone("UTC"));
        $AddressMoveIn = '/Date(' . ($ami->getTimestamp() * 1000) . ')/';

        // Time in current employment status
        $numberOfMonthsInCurrentEmploymentStatus = $post->Employer->monthsAtEmployer;
        $date = date("c", strtotime('-' . $numberOfMonthsInCurrentEmploymentStatus . " months", strtotime($post->created_at)));
        $EmploymentStarted = date("c", strtotime($date));
        $es = new DateTime($EmploymentStarted, new DateTimeZone("UTC"));
        $EmploymentStarted = '/Date(' . ($es->getTimestamp() * 1000) . ')/';

        // Time at bank
        $numberOfMonthsInBank = $post->Bank->monthsAtBank;
        $date = date("c", strtotime('-' . $numberOfMonthsInBank . " months", strtotime($post->created_at)));
        $BankAccountOpened = date("c", strtotime($date));
        $bao = new DateTime($BankAccountOpened, new DateTimeZone("UTC"));
        $BankAccountOpened = '/Date(' . ($bao->getTimestamp() * 1000) . ')/';

        switch ($post->Applicant->nameTitle) {
            case 'Mr':
                $post->Applicant->nameTitle = 1;
            case 'Mrs':
                $post->Applicant->nameTitle = 2;
            case 'Ms':
                $post->Applicant->nameTitle = 3;
            case 'Miss':
                $post->Applicant->nameTitle = 4;
        }
        switch ($post->Employer->incomeSource) {
            case 'SelfEmployed':
                $post->Employer->incomeSource = 1;
            case 'EmployedFullTime':
                $post->Employer->incomeSource = 2;
            case 'EmployedPartTime':
                $post->Employer->incomeSource = 3;
            case 'EmployedTemporary':
                $post->Employer->incomeSource = 4;
            case 'Pension':
                $post->Employer->incomeSource = 5;
            case 'DisabilityBenefits':
                $post->Employer->incomeSource = 6;
            case 'Benefits':
                $post->Employer->incomeSource = 7;
        }
        switch ($post->Employer->incomeCycle) {
            case 'Weekly':
                $post->Employer->incomeCycle = 1;
            case 'BiWeekly':
                $post->Employer->incomeCycle = 2;
            case 'TwiceMonthly':
                $post->Employer->incomeCycle = 7;
            case 'Fortnightly':
                $post->Employer->incomeCycle = 7;
            case 'FourWeekly':
                $post->Employer->incomeCycle = 8;
            case 'Monthly':
                $post->Employer->incomeCycle = 8;
            case 'LastWorkingDayMonth':
                $post->Employer->incomeCycle = 14;
            case 'LastDayMonth':
                $post->Employer->incomeCycle = 14;
        }
        switch ($post->Employer->incomePaymentType) {
            case 'Cash':
                $post->Employer->incomePaymentType = 2;
            case 'Cheque':
                $post->Employer->incomePaymentType = 3;
            case 'RegionalDirectDeposit':
                $post->Employer->incomePaymentType = 4;
            case 'NonRegionalDirectDeposit':
                $post->Employer->incomePaymentType = 2;
        }
        switch ($post->Applicant->inMilitary) {
            case 'None':
                $post->Applicant->inMilitary = 1;
            case 'Veteran':
                $post->Applicant->inMilitary = 2;
            case 'Reserves':
                $post->Applicant->inMilitary = 3;
            case 'ActiveDuty':
                $post->Applicant->inMilitary = 4;
        }
        switch ($post->Residence->residentialStatus) {
            case 'HomeOwner':
                $post->Residence->residentialStatus = 1;
            case 'PrivateTenant':
                $post->Residence->residentialStatus = 2;
            case 'CouncilTenant':
                $post->Residence->residentialStatus = 3;
            case 'LivingWithParents':
                $post->Residence->residentialStatus = 4;
            case 'LivingWithFriends':
                $post->Residence->residentialStatus = 5;
            case 'Other':
                $post->Residence->residentialStatus = 6;

        }
        switch ($post->Bank->BankAccountType) {
            case 'Checking':
                $post->Bank->BankAccountType = 1;
            case 'Savings':
                $post->Bank->BankAccountType = 2;

        }
        switch ($post->Applicant->maritalStatus) {
            case 'Single':
                $post->Applicant->maritalStatus = 1;
            case 'Married':
                $post->Applicant->maritalStatus = 2;
            case 'LivingTogether':
                $post->Applicant->maritalStatus = 3;
            case 'Separated':
                $post->Applicant->maritalStatus = 4;
            case 'Divorced':
                $post->Applicant->maritalStatus = 5;
            case 'Widowed':
                $post->Applicant->maritalStatus = 6;
            case 'Other':
                $post->Applicant->maritalStatus = 7;
        }
        if ($post->Consent->consentFinancial === '1') {
            $post->Consent->consentFinancial = true;
        } else {
            $post->Consent->consentFinancial = false;
        }
        if ($post->Consent->consentCreditSearch == '1') {
            $post->Consent->consentCreditSearch = true;
        } else {
            $post->Consent->consentCreditSearch = false;
        }
        if ($post->Consent->consentThirdPartyEmails == '1') {
            $post->Consent->consentThirdPartyEmails = true;
        } else {
            $post->Consent->consentThirdPartyEmails = false;
        }
        if ($post->Consent->consentThirdPartySMS == '1') {
            $post->Consent->consentThirdPartySMS = true;
        } else {
            $post->Consent->consentThirdPartySMS = false;
        }
        if ($post->Consent->consentThirdPartyPhone == '1') {
            $post->Consent->consentThirdPartySMS = true;
        } else {
            $post->Consent->consentThirdPartyPhone = false;
        }
        if ($post->Employer->jobTitle == '') {
            $post->Employer->jobTitle = 'unknown';
        }

        Log::debug('POST::', (array) $post->Applicant);
//        dd($post->Applicant);

        // POST DATA
        $lead = array(
            "AffiliateId" => (string) "TOMJ-USA",
            "Campaign" => (string) $post->vid ?? 'UPING',
            "SubAffiliate" => (string) $post->subid ?? '',
            "Timeout" => (int) $client_detail->timeout ?? '120',
            "TestOnly" => (boolean) true,

            "SourceDetails" => array(
                "Address" => (string) $post->Source->ipAddress,
                "ClientUserAgent" => (string) $post->Source->userAgent,
                "CreationUrl" => (string) $post->Source->creationUrl,
                "ReferringUrl" => (string) $post->Source->referringUrl,
            ),
            "Application" => array(
                "ConsentToCreditSearch" =>  (boolean) true,
                "Title" => (int) $post->Applicant->nameTitle ?? 1,
                "FirstName" => (string) $post->Applicant->firstName,
                "LastName" => (string) $post->Applicant->lastName,
                "DateOfBirth" => (string) $dateOfBirth,
                "Email" => (string) $post->Applicant->email,
                "HomePhoneNumber" => (string) $post->Applicant->homePhoneNumber,
                "MobilePhoneNumber" => (string) $post->Applicant->cellPhoneNumber,
                "WorkPhoneNumber" => (string) $post->Applicant->workPhoneNumber ?? $post->Applicant->cellPhoneNumber,
                "EmployerName" =>  (string) $post->Employer->employerName ?? 'NOT AVAILABLE',
                "JobTitle" => (string) $post->Employer->jobTitle ?? 'unknown',
                "EmploymentStarted" => (string) $EmploymentStarted,
                "IncomeSource" => (int) $post->Employer->incomeSource,
                "PayFrequency" =>  (int) $post->Employer->incomeCycle,
                "PayAmount" => (int) $post->Employer->monthlyIncome,
                "IncomePaymentType" => (int) $post->Employer->incomePaymentType,

                "NextPayDate" => (string) $nextPayDate,
                "FollowingPayDate" => (string) $followingPayDate,

                "LoanAmount" => (int) $post->Loan->loanAmount,
                "Term" => (int) $post->Loan->loanTerms,
                "ResidentialStatus" => (int) $post->Residence->residentialStatus,
                "HouseNumber" => (string) $post->Residence->houseNumber,
                "HouseName" =>  (string) $post->Residence->houseName,
                "AddressStreet1" => (string) $post->Residence->addressStreet1,
                "AddressCity" => (string) $post->Residence->city,
                "AddressState" => (string) $post->Residence->state,
                "AddressMoveIn" => (string) $AddressMoveIn ?? '10-11-2018',
                "AddressPostcode" =>  (string) $post->Residence->zip,
                "BankName" =>  (string) $post->Bank->bankName,
                "BankAccountNumber" => (string) $post->Bank->bankAccountNumber,
                "BankRoutingNumber" => (string) $post->Bank->bankRoutingNumber,
                "BankAccountType" =>  (int) $post->Bank->bankAccountType,
                "BankAccountOpened" => (string) $BankAccountOpened,

                "MaritalStatus" =>  (int) $post->Applicant->maritalStatus ?? 1,
                "NumberOfDependents" => (int) $post->Applicant->dependants,
                "CombinedMonthlyHouseholdIncome" => (float) $post->Applicant->dependants,

                "DriversLicenseNumber" => (string) $post->Applicant->drivingLicenseNumber,
                "DriversLicenseState" => (string) $post->Applicant->drivingLicenseState,
                "NationalIdentityNumber" => (string) $post->Applicant->ssn,
                "MilitaryService" => (int) $post->Applicant->inMilitary,

                "ConsentToMarketingEmails" => (boolean) $post->Consent->consentThirdPartyEmails,
//                "MinimumCommissionAmount" => (float) $client_detail->min_price ?? '',
//                "MaximumCommissionAmount" => (float) $client_detail->max_price ?? '',
            )
        );



        $this->response['timeout'] = $client_detail->timeout;
        $this->response['post_url'] = ($client_detail->status == '0') ? $client_detail->post_url_test : $client_detail->post_url_live;

        $validation_result = true;
        if ($validation_result == true) {

            try {
                $application_status = Http::post( $this->response['post_url'], $lead);
                $application_status = $application_status->object();
                Log::debug('STATUS::', (array)$application_status);
            } catch (Exception $e) {
                Log::debug($e);
            }

//            if($application_status)



            $this->response['application_response'] = $application_status;

        } else {
            $this->response['application_response'] = $validation_result;
            $this->response['validated'] = false;
        }
    }

    public function returnresponse()
            {
                $appResponse = $this->response['application_response'];
                Log::debug('APP RESP::', (array)$appResponse);


                Log::debug('APP RESP::', (array)$appResponse->CorrelationId);
                $CorrelationId = $appResponse->CorrelationId;


                $this->response['validated'] = true;
                if ($this->response['validated'] === true) {
                    $status = new PingYo\Status('202', null, $CorrelationId, null);
                    Log::debug('RESP STATUS::', (array)$status);

                    $counter = 0;
                    while (true) {
                        $res = $status->refresh();
                        Log::debug('STATUS REFRESH::', (array)$res);
                        $counter++;
                        if ($status->percentagecomplete == 100) {
                            break;
                        }

                        sleep(3);
                    }

                    $this->response['post_res'] = json_encode($res);
                    $this->response['correlationid'] = $status->correlationid;
                    Log::debug('POST RES :: ', (array)$this->response);
                    Log::debug('RESP3 :: ', (array)$status);
                    //print_r($price); print_r($status);exit;

                    if ($status->status == 'LenderMatchFound') {
                        $this->response['accept'] = 'ACCEPTED';
                        $this->response['post_price'] = $status->estimatedcommission->Amount;
                        $this->response['post_status'] = '1';
                        try {
                            $this->response['redirect_url'] = $status->redirecturl;
                        } catch (Exception $e) {
                            $this->response['redirect_url'] = $status->redirectionurl;
                        }
                        $this->response['post_time'] = $appResponse->post_time;
                    }
                    elseif($status->status == 'ConditionalLenderMatchFound') {
                        $this->response['accept'] = 'ACCEPTED';
                        $this->response['post_status'] = '0';
                        $this->response['post_price'] = '0';
                        $this->response['post_time'] = $appResponse->post_time;
                    }
                    elseif($status->status == 'NoLenderMatchFound') {
                        $this->response['accept'] = 'REJECTED';
                        $this->response['post_status'] = '0';
                        $this->response['post_price'] = '0';
                        $this->response['post_time'] = $appResponse->post_time;
                    }
                    return $this->response;
                } else {
                    $this->response['accept'] = 'Validation Failed';
                    $this->response['post_status'] = '0';
                    $this->response['post_price'] = '0';
                    $this->response['post_time'] = $appResponse->post_time;
                    return $this->response;
                }

            }

    private function manageDependencies()
            {
                require_once dirname(__DIR__) . '/vendor/PingYo/Application.php';
                require_once dirname(__DIR__) . '/vendor/PingYo/SourceDetails.php';
                require_once dirname(__DIR__) . '/vendor/PingYo/ApplicationDetails.php';
                require_once dirname(__DIR__) . '/vendor/PingYo/Status.php';
                require_once dirname(__DIR__) . '/vendor/PingYo/TitleType.php';
                require_once dirname(__DIR__) . '/vendor/PingYo/BankCardType.php';
                require_once dirname(__DIR__) . '/vendor/PingYo/ResidentialStatusType.php';
                require_once dirname(__DIR__) . '/vendor/PingYo/IncomePaymentType.php';
                require_once dirname(__DIR__) . '/vendor/PingYo/PayFrequencyType.php';
                require_once dirname(__DIR__) . '/vendor/PingYo/IncomeSourceType.php';
                require_once dirname(__DIR__) . '/vendor/PingYo/EmployerIndustryType.php';
                require_once dirname(__DIR__) . '/vendor/PingYo/NationalIdentityNumberType.php';
                require_once dirname(__DIR__) . '/vendor/autoload.php';
                require_once dirname(__DIR__) . '/vendor/PingYo/ExtendedValidator.php';

            }


}
