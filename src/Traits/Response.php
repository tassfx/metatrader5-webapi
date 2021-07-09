<?php
namespace CrystalApps\MetaTrader5\Traits;

trait Response
{
    public function basicResponse(string $retcode, string $answer,bool $isSuccess = true)
    {
        if (!$isSuccess)
        {
            return ['error' => true, 'retcode' => $retcode,'answer' => $answer,];
        }

        return ['error' => false, 'retcode' => $retcode, 'answer' => $answer];
    }

    public function success(string $retcode,string $answer)
    {
        return $this->basicResponse($retcode,$answer);
    }

    public function fail(string $retcode, string $answer)
    {
        return $this->basicResponse($retcode,$answer,false);
    }
}