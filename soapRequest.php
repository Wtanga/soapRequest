<?php
class Person
{
    public $INSURER_FIRSTNAME;
    public $INSURER_LASTNAME;
    public $INSURER_SURNAME;
    public $INSURER_EMAIL;
    public $INSURER_BIRTHDAY;
    public $INSURER_PHONE;
    public $INSURER_ADRESS;
    public $PASSPORT_NUMBER;
}            

class Request
{
    public $productId;
    public $applicationId;
    public $person;
}

$authenticationData = array('login'         =>'testForUser',
                            'password'      =>'testUser520',
                            );

$client = new SoapClient("https://soapdev.d2insur.ru/pay/PolicyPay.wsdl", $authenticationData);

$req = new Request();
$req->person    = new Person();
$req->productId = '3523309775';
$req->applicationId = '89898989';
$req->person->INSURER_FIRSTNAME = "asd";
$req->person->INSURER_LASTNAME  = "asd";
$req->person->INSURER_SURNAME   = "asd";
$req->person->INSURER_EMAIL     = "ivan@ivanov.ru";
$req->person->INSURER_BIRTHDAY  = "11.11.1999";
$req->person->INSURER_PHONE     = "78005553535";
$req->person->PASSPORT_NUMBER   = "1231231234";   
$req->person->INSURER_ADRESS    = "г Москва Троицкий д Романцево (Краснопахорское с/п) ул Рябиновая д. 1 корп. 2 стр. 1 кв. 45";     

$result = $client->obtainCertificate($req);

$file = 'test.pdf';
print_r("Страховая сумма: "               . $result->cert->insur_summa .
        "\nСтраховая премия: "            . $result->cert->insur_premium . 
        "\nСтраховая стоимость: "         . $result->cert->insur_cost .        
        "\nНомер полиса: "                . $result->cert->number .
        "\nСсылка для онлайн оплаты: "    . $result->cert->returnurl . 
        "\nИдентификатор онлайн оплаты: " . $result->cert->payid);

$binary = base64_decode($result->cert->certFile);

file_put_contents($file, $binary);
