<?php
namespace CrystalApps\MetaTrader5\Objects;

class Result
{
    /**
     * MT5 Response
     * @var array
     */
    private array $data;

    /**
     * Result constructor.
     * @param array $data
     * @param bool $unusedFields
     */
    public function __construct(array $data, bool $unusedFields = true)
    {
        if (!$unusedFields)
        {
            $this->data = $data['answer'];
        }
        else
        {
            $this->data = array_diff_key($data['answer'], array_flip(['ApiData']));
        }
    }

    /**
     * Map instance
     * @param callable $fn
     * @return Result
     */
    public function map(callable $fn)
    {
        $data = array_map($fn, $this->data);
        return new self($data);
    }

    /**
     * Filter instance
     * @param callable $fn
     * @return Result
     */
    public function filter(callable $fn)
    {
        $data = array_filter($this->data,$fn);
        return new self($data);
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