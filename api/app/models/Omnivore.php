<?php
class Omnivore
{
    private $key;
    private $requestType;
    var $url;
    var $callType;
    var $subCallType;
    var $callId;
    var $location;
    var $query;
    var $postfields;
    var $errors;

    function __construct()
    {
        $this->url = 'https://api.omnivore.io/1.0/locations/';
        $this->key = '7fe6f5b3652d4325b1f66d0efadae3e8';
        $this->requestType = 'GET';
    }

    public function apiCall()
    {
        $this->_validateSettings();

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->buildURL(),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $this->requestType,
            CURLOPT_POSTFIELDS => $this->postfields,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'api-key: ' . $this->key,
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo 'cURL Error #:' . $err;
        } else {
            $this->_unsetCallSettings();
            return json_decode($response, true);
        }

        return false;
    }

    /**
     * Verifies if all variables are set.
     * Outputs errors if needed.
     */
    private function _validateSettings()
    {
        if (!$this->url) {
            $this->errors[] = 'URL is not set.';
        }

        if (!$this->key) {
            $this->errors[] = 'API key is not set.';
        }

        if (!$this->location) {
            $this->errors[] = 'Location is not set.';
        }

        if ($this->errors) {
            foreach ($this->errors as $error) {
                echo 'Error: ' . $error;
            }

            $this->errors = null;
            exit();
        }

        return;
    }

    /**
     * Reset object variables after a call.
     * Prevents conflicts.
     */
    private function _unsetCallSettings()
    {
        $except = array('key', 'url', 'location');

        foreach (get_object_vars($this) as $property => $var) {
            if (!in_array($property, $except)) {
                $this->$property = null;
            }
        }

        $this->requestType = 'GET';
    }

    /**
     * Builds a URL with all the set variables.
     * @return $url
     */
    private function buildURL()
    {
        $url = $this->url;
        debug($url);

        if (isset($this->location)) {
            $url .= $this->location;
        }

        if (isset($this->callType)) {
            $url .= '/' . $this->callType;
        }

        if (isset($this->callId)) {
            $url .= '/' . $this->callId;
        }

        if (isset($this->subCallType)) {
            $url .= '/' . $this->subCallType;
        }

        if (isset($this->query)) {
            $url .= '?' . $this->query;
        }

        return $url;
    }

    /**
     * Get a store by location.
     * @param $location
     * @return JSON location
     */
    public function getLocation($location)
    {
        $this->location = $location;
        return $this->apiCall();
    }

    /**
     * Get all tickets for location.
     * @return JSON tickets
     */
    public function getTickets()
    {
        $this->callType = 'tickets';
        return $this->apiCall();
    }

    /**
     * Get a specific ticket by id.
     * @param $callId
     * @return JSON ticket
     */
    public function getTicket($ticketId)
    {
        $this->callType = 'tickets';
        $this->callId = $ticketId;
        return $this->apiCall();
    }

    /**
     * Get ticket's items.
     * @param $callId
     * @return JSON items
     */
    public function getTicketItems($ticketId)
    {
        $this->callType = 'tickets';
        $this->subCallType = 'items';
        $this->callId = $ticketId;
        return $this->apiCall();
    }

    public function payTicket($ticketId, Payment $payment)
    {
        $this->callType = 'tickets';
        $this->subCallType = 'payments';
        $this->callId = $ticketId;
        $this->requestType = 'POST';
        $this->postfields = json_encode($payment);
        return $this->apiCall();
    }

    /**
     * Get all tables for location.
     * @return JSON tables
     */
    public function getTables()
    {
        $this->callType = 'tables';
        return $this->apiCall();
    }

    /**
     * Get all tables for location.
     * @return JSON table
     */
    public function getTable($tableId)
    {
        $this->callType = 'tables';
        $this->callId = $tableId;
        return $this->apiCall();
    }
}