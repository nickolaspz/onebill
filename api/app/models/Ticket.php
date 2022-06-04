<?php
// namespace Models;

class Ticket
{
    var $totals;
    var $items;
    var $service_charges;
    var $open;
    var $opened_at;
    var $closed_at;
    var $ticket_number;
    private $payment;

    function __construct()
    {
        $this->totals = new Totals;

        $this->items = array();

        $this->service_charges = array();

        $this->payment = new Payment;
    }

    public function addItem(array $array)
    {
        $item = new Item;
        foreach (get_object_vars($item) as $property => $var) {
            if (array_key_exists($property, $array)) {
                $item->$property = $array[$property];
            }
        }
        $this->items[] = $item;
    }

    public function getItems()
    {
        return $this->items;
    }

    public function addServiceCharge(array $array)
    {
        $service_charge = new ServiceCharge;
        foreach ($service_charge as $key => $value) {
            if (array_key_exists($key, $array)) {
                $service_charge->$key = $array[$key];
            }
        }
        $this->service_charges[] = $service_charge;
    }

    public function getServiceCharges()
    {
        return $this->service_charges;
    }

    public function setTotals(array $array)
    {
        foreach (get_object_vars($this->totals) as $property => $var) {
            if (array_key_exists($property, $array)) {
                $this->totals->$property = $array[$property];
            }
        }
    }

    public function getTotals()
    {
        return $this->totals;
    }

    public function setPayment(array $array)
    {
        foreach (get_object_vars($this->payment) as $property => $var) {
            if ($array[$property] !== null) {
                $this->payment->$property = $array[$property];
            }
        }
    }

    public function getPayment()
    {
        return $this->payment;
    }
}

class Payment
{
    var $amount;
    var $card_info;
    var $tip;
    var $type;

    function __construct()
    {
        $this->card_info = array(
            'exp_month' => null, #int
            'exp_year' => null, #int
            'cvc2' => null, #string
            'number' => null #string
        );
    }
}

class Totals
{
    var $total;
    var $tips;
    var $tax;
    var $sub_total;
    var $service_charges;
    var $paid;
    var $other_charges;
    var $items;
    var $due;
    var $discounts;
}

class Item
{
    var $id;
    var $name;
    var $price;
    var $quantity;
    var $sent;
    var $sent_at;
    var $commentvar;
}

class ServiceCharge
{
    var $id;
    var $name;
    var $price;
    var $comment;
}