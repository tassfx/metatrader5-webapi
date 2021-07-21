<?php
namespace CrystalApps\MetaTrader5\Objects;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

/**
 * Class Mt5Client
 * @package CrystalApps\MetaTrader5\Objects
 */
class Mt5Client
{
    private Client $client;

    //Params
    private string $ip;
    private int $port;
    private int $login;
    private string $password;
    private string $agent;
    private int $build;


    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function __construct(string $ip, int $port, int $login, string $password, string $agent, int $build)
    {
        $this->ip = $ip;
        $this->port = $port;
        $this->password = $password;
        $this->agent = $agent;
        $this->login = $login;
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
            return new Result(['message' => 'Generic error: guzzle is not init'],500);
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
            return new Result(['message' => 'Generic error'],$result->getStatusCode());
        }

        $result = json_decode($result->getBody(), true);

        if ($result['retcode'] != '0 Done')
        {
            return new Result(['message' => $result['retcode'].':'.$result['answer']],500);
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
            return new Result(['message' => 'Generic error'],$result->getStatusCode());
        }

        $result = json_decode($result->getBody(), true);

        if ($result['retcode'] != '0 Done')
        {
            return new Result(['message' => $result['retcode'].':'.$result['answer']],500);
        }

        /**
         * Calculating the correct server response for a random client sequence
         */
        $cliRandAnswer = md5(md5($password_hash, true) . $cli_rand_buf);

        if ($cliRandAnswer != $result['cli_rand_answer'])
        {
            return new Result(['message' => 'Auth answer error: rand buffs missmatch'],500);
        }

        return new Result(['message' => 'Auth OK']);
    }


    /**
     * Send command to mt5
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sendCommand(Command $command)
    {
        /**
         * Передаю привет дегенератам с метаквотс
         */
        if ($command->method == 'GET')
        {
            $request = $this->client->request($command->method, $command->path,['query' => $command->params]);
        }
        else
        {
            $request = $this->client->request($command->method,$command->path,[RequestOptions::JSON => $command->params]);
        }


        if ($request->getStatusCode() != 200)
        {
            return new Result(['message' => 'Command error'],$request->getStatusCode());
        }

        return new Result(json_decode($request->getBody(), true));
    }
}