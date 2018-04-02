<?php
namespace CHF\BackendModule\Traits;

trait Deletable
{
    /**
     * @var bool
     */
    protected $deleted;

    /**
     * @return bool
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * @return bool
     */
    public function getDeleted()
    {
        return $this->isDeleted();
    }

    /**
     * @param bool $deleted
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
    }

    public function delete()
    {
        $this->deleted = true;
    }
}
