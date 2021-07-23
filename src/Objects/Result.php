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
    public function __construct(array $data, int $code = 200)
    {
       $this->data = $data;
       $this->code = $code;
    }
    
    public function getCode()
    {
        return $this->code;
    }

    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * Map instance
     * @param callable $fn
     * @return Result
     */
    public function map(callable $fn): Result
    {
        $data = array_map($fn, $this->data);
        return new self($data);
    }

    /**
     * Filter instance
     * @param callable $fn
     * @return Result
     */
    public function filter(callable $fn): Result
    {
        $data = array_filter($this->data,$fn);
        return new self($data);
    }

    /**
     * Returns the collection itself, not this
     * @return array
     */
    public function all(): array
    {
        return $this->data;
    }
}
