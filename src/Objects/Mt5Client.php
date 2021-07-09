<?php
namespace CrystalApps\MetaTrader5\Objects;
use GuzzleHttp\Client;

class Mt5Client
{
    private Client $client;

    //Params
    private $ip;
    private $port;
    private $login;
    private $password;
    private $agent;
    private $build;

}