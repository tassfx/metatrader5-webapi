<?php
namespace CrystalApps\MetaTrader5\Objects;

class Result
{
    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param array $criteria
     * @return array
     */
    public function only(array $criteria)
    {
        return array_intersect_key($this->data,array_flip($criteria));
    }
}