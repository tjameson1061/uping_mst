<?php
namespace PingYo;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Application
{

    public $Campaign;
    public $AffiliateId;
    public $SubAffiliate;
    public $Timeout;
    public $TestOnly;

    public $Application;
    public $SourceDetails;

    private $connection_status = false;
    private $logger = null;

    private $validation_rules = [
        'required' => [
            [['AffiliateId', 'Timeout', 'Application', 'SourceDetails']]
        ],
        'integer' => [
            [['Timeout']]
        ],
        'in' => [
            [['TestOnly'], [false, true]]
        ],
        'min' => [
            [['Timeout'], 45]
        ],
        'max' => [
            [['Timeout'], 120]
        ],
        'instanceOf' => [
            [['Application'], 'PingYo\ApplicationDetails'],
            [['SourceDetails'], 'PingYo\SourceDetails'],
        ]
    ];

    public function attachLogger(\Psr\Log\LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function setApplicationDetails(ApplicationDetails $Application)
    {
        if (!is_null($this->logger)) {
            Log::debug("Application::setApplicationDetails() called with ApplicationDetails=" . var_export($Application,
                    true));
        }
        $this->Application = $Application;
        if (!is_null($this->logger)) {
            $Application->attachLogger($this->logger);
        }
    }

    public function setSourceDetails(SourceDetails $SourceDetails)
    {
        if (!is_null($this->logger)) {
            Log::debug("Application::setSourceDetails() called with SourceDetails=" . var_export($SourceDetails,
                    true));
        }
        $this->SourceDetails = $SourceDetails;
        if (!is_null($this->logger)) {
            $SourceDetails->attachLogger($this->logger);
        }
    }

    public function get_connection_status()
    {
        if (!is_null($this->logger)) {
            Log::debug("Application::get_connection_status() called");
        }
        return $this->connection_status;
    }

    public function send($application)
    {
        if (!is_null($this->logger)) {
            Log::debug("Application::send() called");
        }
        $r = $application->validate();
        Log::debug('PRE_POST::', (array) $r);

        if ($r === true) {
            Log::debug('PRE_POST::', (array) $application);

            $application = $application->toArray();
            Log::info("application sent: " . $application);
            dd('here');


            $output = Http::post("https://leads.pingyo.co.uk/application/submit", $application);
//            $server_output = $output->object();

            Log::debug('POST::', (array) $application);
            Log::debug('PingYo::', (array) $output->object());

                Log::info("got response with code " . $output->status() . ': ' . $output);

//            $this->connection_status = $info;
            return new Status($output->status(), $output, null, $this->logger);
        } else {
            Log::debug('PingYo, INVALID Application');
            return false;
        }
    }

    public function validate($full_validation = true)
    {
        if (!is_null($this->logger)) {
            Log::debug("Application::validate() called with full_validation=$full_validation");
        }

        $validator = new ExtendedValidator(array(
            'Campaign' => $this->Campaign,
            'AffiliateId' => $this->AffiliateId,
            'SubAffiliate' => $this->SubAffiliate,
            'Timeout' => $this->Timeout,
            'TestOnly' => $this->TestOnly,
            'Application' => $this->Application,
            'SourceDetails' => $this->SourceDetails
            ));
        $validator->rules($this->validation_rules);
        if ($validator->validate()) {
            if ($full_validation) {
                if (($this->Application->validate()) && ($this->SourceDetails->validate())) {
                    if (!is_null($this->logger)) {
                        Log::info("Application validation passed");
                    }
                    //echo " valido 1";
                    return true;
                } else {
                    if (!is_null($this->logger)) {
                        Log::warning("Application validation errors found in child object");
                    }
                    //echo "NO valido 1";
                    return false;
                }
            } else {
				//echo " valido 2";
                return true;
            }
        } else {
			//echo "NO valido 2";
            if (!is_null($this->logger)) {
                Log::warning("Application validation errors found in main object: ",
                    array('errors' => $validator->errors()));
            }
            return $validator->errors();
        }
    }

    public function toJson()
    {
        if (!is_null($this->logger)) {
            Log::debug("Application::toJson() called");
        }
        $r = $this->validate();
        if ($r === true) {
            return json_encode($this->toArray());
        } else {
            return false;
        }
    }

    public function toArray()
    {
        if (!is_null($this->logger)) {
            Log::debug("Application::toArray() called");
        }
        $r = $this->validate();
        if ($r === true) {
//            dd($this->applicationdetails);
             return [
                 'Campaign' => $this->Campaign,
                 'AffiliateId' => $this->AffiliateId,
                 'SubAffiliate' => $this->SubAffiliate,
                 'Timeout' => $this->Timeout,
                 'TestOnly' => $this->TestOnly,
                 'Application' => $this->Application,
                 'SourceDetails' => $this->SourceDetails
            ];

        } else {
            return false;
        }
    }
}
