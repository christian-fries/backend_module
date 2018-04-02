<?php
namespace CHF\BackendModule\Traits;

trait Hideable
{
    /**
     * @var bool
     */
    protected $hidden;

    /**
     * @return bool
     */
    public function isHidden()
    {
        return $this->hidden;
    }

    /**
     * @return bool
     */
    public function getHidden()
    {
        return $this->isHidden();
    }

    /**
     * @param bool $hidden
     */
    public function setHidden($hidden)
    {
        $this->hidden = $hidden;
    }
}
