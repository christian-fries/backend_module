<?php

namespace CHF\BackendModule\Traits;

trait TimestampableTrait
{
    /**
     * @var int
     */
    protected $crdate = 0;

    /**
     * @var int
     */
    protected $tstamp = 0;

    /**
     * @return int
     */
    public function getCrdate()
    {
        return $this->crdate;
    }

    /**
     * @param int $crdate
     */
    public function setCrdate($crdate)
    {
        $this->crdate = $crdate;
    }

    /**
     * @return int
     */
    public function getTstamp()
    {
        return $this->tstamp;
    }

    /**
     * @param int $tstamp
     */
    public function setTstamp($tstamp)
    {
        $this->tstamp = $tstamp;
    }

    /**
     * Get crdate as datetime
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        $createdAt = new \DateTime();
        $createdAt->setTimestamp($this->crdate);

        return $createdAt;
    }

    /**
     * Set crdate from datetime
     *
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->crdate = $createdAt->getTimestamp();
    }

    /**
     * Get tstamp as datetime
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        $updatedAt = new \DateTime();
        $updatedAt->setTimestamp($this->tstamp);

        return $updatedAt;
    }

    /**
     * Set tstamp from datetime
     *
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->tstamp = $updatedAt->getTimestamp();
    }
}
