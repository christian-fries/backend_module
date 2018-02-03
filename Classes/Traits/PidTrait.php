<?php
namespace CHF\BackendModule\Traits;

trait PidTrait
{
    /**
     * @var int
     */
    protected $pid;

    /**
     * @return int
     */
    public function getPid()
    {
        return $this->pid;
    }

    /**
     * @param int $pid
     */
    public function setPid($pid)
    {
        $this->pid = $pid;
    }
}
