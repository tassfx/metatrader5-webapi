<?php
namespace CrystalApps\MetaTrader5\Traits;

trait Response
{
    /**
     * Basic response
     * @param string $retcode
     * @param string $answer
     * @param bool $isSuccess
     * @return array
     */
    public function basicResponse(string $retcode, string $answer,bool $isSuccess = true)
    {
        if (!$isSuccess)
        {
            return ['error' => true, 'retcode' => $retcode,'answer' => $answer,];
        }

        return ['error' => false, 'retcode' => $retcode, 'answer' => $answer];
    }

    /**
     * If success
     * @param string $retcode
     * @param string $answer
     * @return array
     */
    public function success(string $retcode,string $answer)
    {
        return $this->basicResponse($retcode,$answer);
    }

    /**
     * If fail
     * @param string $retcode
     * @param string $answer
     * @return array
     */
    public function fail(string $retcode, string $answer)
    {
        return $this->basicResponse($retcode,$answer,false);
    }
}