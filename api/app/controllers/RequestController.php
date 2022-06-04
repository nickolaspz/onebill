<?php
require WWW_ROOT . DS . 'app' . DS . 'controllers' . DS . 'Controller.php';
require WWW_ROOT . DS . 'app' . DS . 'models' . DS . 'Ticket.php';
use GuzzleHttp\Client;

class RequestController extends Controller
{
    public function table()
    {
        ## test url
        //iq74jeMT
        // http://onebill.ga/request/table?location=iE7xLRaT&id=1
        // o85945@mvrht.net // lmao1234

        if (!isset($this->request->query['location']) OR !isset($this->request->query['id'])) {
            echo json_encode(['error' => 'missing parameters "table id" or "location"']);
            exit();
        }

        $locationId = $this->request->query['location'];
        $tableId = $this->request->query['id'];
        $apiKey = 'b25e507855104de893faa0cdfe377d83';

        $client = new \GuzzleHttp\Client();

        $response = $client->get("https://api.omnivore.io/1.0/locations/" . $locationId . "/tickets/?where=and(eq(open,true),eq(@revenue_center.id,'" . $tableId . "'))", [
        'headers' => [
                'api-key' => $apiKey
            ]
        ]);

        $tickets = json_decode($response->getBody()->getContents(), true)['_embedded']['tickets'];

        $table = [];
        foreach ($tickets as $key => $ticket) {
            // Create tickets
            $ticketObj = new Ticket();

            // Set ticket totals
            $ticketObj->setTotals($ticket['totals']);

            // Get & Set additional fees
            foreach ($ticket['_embedded']['service_charges'] as $serviceCharge) {
                $ticketObj->addServiceCharge($serviceCharge);
            }

            // Get Items
            $itemsResponse = $client->get($ticket['_links']['items']['href'], [
                'headers' => [
                    'api-key' => $apiKey
                ]
            ]);

            $items = json_decode($itemsResponse->getBody()->getContents(), true)['_embedded']['items'];

            foreach ($items as $item) {
                $ticketObj->addItem($item);
            }

            // Add tickets to table
            $table[] = $ticketObj;
        }

        // echo '<pre>';
        // echo print_r($table, true);

        $this->view->set('json', json_encode($table));
    }

    public function pay()
    {
        if (!isset($this->request->query['location']) OR !isset($this->request->query['id'])) {
            echo json_encode(['error' => 'missing parameters "table id" or "location"']);
            exit();
        }

        $locationId = $this->request->query['location'];
        $tableId = $this->request->query['id'];
        $ticketId = $this->request->query['ticketid'];
        $apiKey = 'b25e507855104de893faa0cdfe377d83';

        // Card present payment
        // $payment = [
        //     'amount' => $this->request->query['amount'],
        //     'card_info' => [],
        //     'tip' => $this->request->query['tip'],
        //     'type' => $this->request->query['type']
        // ];
        
        // 3rd party payment
        $payment = [
            'amount' => $this->request->query['amount'],
            'tender_type' => '100',
            'tip' => $this->request->query['tip'],
            'type' => '3rd_party'
        ];

        //TEST
        $payment = [
            'amount' => 100,
            'tender_type' => '100',
            'tip' => 15,
            'type' => '3rd_party'
        ];

        $client = new \GuzzleHttp\Client();

        $response = $client->post("https://api.omnivore.io/1.0/locations/" . $locationId . "/tickets/" . $ticketId . "/payments/", [
            'headers' => [
                'api-key' => $apiKey
            ],
            'body' => [
                json_encode($payment)
            ]
        ]);


    }
}