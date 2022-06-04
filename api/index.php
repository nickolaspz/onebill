<?php
define('WWW_ROOT', dirname(__FILE__));
define('DS', DIRECTORY_SEPARATOR);

require __DIR__ . '/vendor/autoload.php';

require 'config' . DS . 'bootstrap.php';

// require 'app' . DS .'models' . DS . 'Omnivore.php';
// require 'app' . DS . 'models' . DS . 'ClientInvoice.php';

// Must inclue bootstrap or die
defined('onebill') or die('Y\'a can\'t be hurr see?');

// Set Controller Name & File
$controllerName = ucfirst(strtolower($request->controller)) . 'Controller';
$controllerFile = WWW_ROOT . DS . 'app' . DS . 'controllers' . DS . $controllerName . '.php';

// No controller found - Error 500
if (!file_exists($controllerFile)) {
    echo $view->render('error');
    return;
}

// Import Specified Controller
include $controllerFile;
$controller = new $controllerName($view, $session, $request);

// Set Action
$action = strtolower($request->action);

// No function found - Error 404
if (!method_exists($controller, $action)) {
    echo $view->render('error');
    return;
}

// Call Specified Controller Action
$controller->$action();

// Render view
echo $view->render($action, $view->vars);














// $omnivore = new Omnivore;

// Set restaurant location key
// $omnivore->location = 'cGEA8pji';

// Get ticket + item
// $ticket = $omnivore->getTicket(6531);
// $items = $omnivore->getTicketItems(6531);

// Assign values to invoice
// $invoice = new ClientInvoice;

// Set Totals
// $invoice->setTotals($ticket['totals']);

// Set Invoice Items
// foreach ($items['_embedded'] as $items) {
//     foreach ($items as $item) {
//         $invoice->addItem($item);
//     }
// }

// debug($invoice->getTotals());
// debug($invoice->getItems());

// $invoice->setPayment(array(
//     'amount' => 100, #double
//     'card_info' => array(
//         'exp_month' => 1, #int
//         'exp_year' => 2018, #int
//         'cvc2' => '123', #string
//         'number' => '4111111111111111' #string
//     ),
//     'tip' => 0, #int
//     'type' => 'card_not_present' #string
// ));


// // Make payment
// $payment = $omnivore->payTicket(6446, $invoice->getPayment());

// debug($payment);

// // Get error
// $errors = Nik::extract(Nik::extract($payment, 'errors'), 'error');

// debug($errors);

// $omnivore->getTable(3);
// echo json_encode($invoice);

## Tables ##
// Get table 3
// $table = $omnivore->getTable(2);

// // debug($table);
// $omnivore->url = "https://api.omnivore.io/1.0/locations/cGEA8pji/tickets/?where=and(eq(open,true),eq(@table.id,'3'))";
// $tableTickets = $omnivore->apiCall();
// debug($tableTickets);

// debug(Nik::extract($table, 'open_tickets'));