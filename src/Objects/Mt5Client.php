<?php
namespace CrystalApps\MetaTrader5\Objects;
use CrystalApps\MetaTrader5\Helpers\CommandList;
use CrystalApps\MetaTrader5\Traits\Response;
use GuzzleHttp\Client;
use JetBrains\PhpStorm\ExpectedValues;

/**
 * Class Mt5Client
 * @package CrystalApps\MetaTrader5\Objects
 */
class Mt5Client
{
    use Response;

    private Client $client;

    //Params
    private string $ip;
    private int $port;
    private int $login;
    private string $password;
    private string $agent;
    private int $build;

    //Values
    private ExpectedValues $expectedValues;

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function __construct(string $ip, int $port, string $password, string $agent, int $build)
    {
        $this->ip = $ip;
        $this->port = $port;
        $this->password = $password;
        $this->agent = $agent;
        $this->build = $build;

        $this->client = new Client([
            'base_uri' => $this->ip . ':' . $this->port,
            'timeout' => 36000,
            'verify' => false,
        ]);

        $this->auth();
    }

    /**
     * MT5 Auth
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function auth()
    {
        if (!$this->client instanceof Client)
        {
            return $this->fail('Generic error', 'Guzzle is not initialized! R u ok?');
        }

        $params = [
            'version' => $this->build,
            'agent' => $this->agent,
            'login' => $this->login,
            'type' => 'manager'
        ];

        $result = $this->client->get('/auth_start', ['query' => $params]);

        if ($result->getStatusCode() != 200)
        {
            return $this->fail('Generic error', $result->getStatusCode());
        }

        $result = json_decode($result->getBody(), true);

        if ($result['retcode'] != '0 Done')
        {
            return $this->fail($result['retcode'],$result['answer']);
        }

        /**
         * MT5 Psyhodelic
         */
        $srv_rand = hex2bin($result['srv_rand']);
        $password_hash = md5(mb_convert_encoding($this->password, 'utf-16le', 'utf-8'), true) . 'WebAPI';
        $srv_rand_answer = md5(md5($password_hash, true) . $srv_rand);
        $cli_rand_buf = random_bytes(16);
        $cli_rand = bin2hex($cli_rand_buf);

        /**
         * Send anwser
         */
        $params = [
            'srv_rand_answer' => $srv_rand_answer,
            'cli_rand' => $cli_rand
        ];

        $result = $this->client->get('/auth_answer', ['query' => $params]);

        if ($result->getStatusCode() != 200)
        {
            return $this->fail('Generic error', $result->getStatusCode());
        }

        $result = json_decode($result->getBody(), true);

        if ($result['retcode'] != '0 Done')
        {
            return $this->fail($result['retcode'],$result['answer']);
        }

        /**
         * Calculating the correct server response for a random client sequence
         */
        $cliRandAnswer = md5(md5($password_hash, true) . $cli_rand_buf);

        if ($cliRandAnswer != $result['cli_rand_answer'])
        {
            return $this->fail('Generic error', 'Auth answer error: rand buffs missmatch');
        }

        return $this->success('0 Done','OK!');
    }

    public function sendCommand(string $command, array $params)
    {
        //$command = new Command('')
    }
}