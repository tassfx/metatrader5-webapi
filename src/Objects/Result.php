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
     * Response Code
     * @var int
     */
    private int $code;

    /**
     * Result constructor.
     * @param array $data
     * @param bool $unusedFields
     */
    public function __construct(array $data, int $code = 200, bool $unusedFields = true)
    {
        if ($code == 200 && $unusedFields = true)
        {
            $this->data = array_diff_key($data['answer'], array_flip(['ApiData']));
        }

        if ($code != 200)
        {
            $this->data = $data;
        }

        if (!$unusedFields)
        {
            $this->data = $data['answer'];
        }
    }
    
    public function getCode()
    {
        return $this->code;
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
