<?php
namespace CHF\BackendModule\Traits;

trait UidTrait
{
    /**
     * @var int
     */
    protected $uid;

    /**
     * @return int
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * @param int $uid
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
    }
}
