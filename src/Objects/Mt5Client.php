<?php
namespace CrystalApps\MetaTrader5\Objects;
use CrystalApps\MetaTrader5\Traits\Response;
use GuzzleHttp\Client;

class Mt5Client
{
    use Response;

    private Client $client;

    //Params
    private $ip;
    private $port;
    private $login;
    private $password;
    private $agent;
    private $build;
}