<?php

namespace App\Helper;

use Twilio\Rest\Client;

class TwilioClient
{
    protected $accountSid = 'ACdc7c947893a177b3516e8d7d88d79a85';
    protected $authToken = '2ee10953c583eb152ed8ac36100e7b37';
    protected $client;
    public function __construct()
    {
        $this->client = new Client($this->accountSid, $this->authToken);
    }

    /**
     * @see https://www.twilio.com/docs/iam/api/account?code-sample=code-create-account&code-language=PHP&code-sdk-version=5.x#fetch-an-account-resource
     * @return \Twilio\Rest\Api\V2010\AccountInstance
     */
    public function getAccountDetails()
    {
        return $this->client->api->v2010->accounts($this->accountSid)
            ->fetch();
    }

    public function getBalance()
    {
        $accountDetails = $this->getAccountDetails();

        if (empty($accountDetails->subresourceUris['balance'])) {
            throw new \Exception('Cannot get account balance subsource URI');
        }

        $balanceUrl = 'https://api.twilio.com' . $accountDetails->subresourceUris['balance'];

        $balanceResponse = $this->client->request('GET', $balanceUrl);
        $responseContent = $balanceResponse->getContent();

        if (!isset($responseContent['balance'])) {
            throw new \Exception('Cannot get account balance details');
        }

        return round($responseContent['balance'], 2);
    }
}