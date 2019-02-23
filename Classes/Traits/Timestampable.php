<?php

namespace CHF\BackendModule\Traits;

/***
 *
 * This file is part of the "Backend Module" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2016 Christian Fries <hello@christian-fries.ch>, CF Webworks
 *
 ***/

trait Timestampable
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
