<?php
namespace CrystalApps\MetaTrader5\Objects;

class Result
{
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Map instance
     * @param callable $fn
     * @return Result
     */
    public function map(callable $fn)
    {
        $data = array_map($fn, $this->data);

        return new Result($data);
    }

    /**
     * Filter instance
     * @param callable $fn
     * @return Result
     */
    public function filter(callable $fn)
    {
        $data = array_filter($this->data,$fn);

        return new Result($data);
    }

    /**
     * Returns the collection itself, not this
     * @return array
     */
    public function all()
    {
        return $this->data;
    }
}