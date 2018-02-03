<?php
namespace CHF\BackendModule\Traits;

trait HiddenTrait
{
    /**
     * @var bool
     */
    protected $hidden;

    /**
     * @return bool
     */
    public function getHidden()
    {
        return $this->hidden;
    }

    /**
     * @param bool $hidden
     */
    public function setHidden($hidden)
    {
        $this->hidden = $hidden;
    }
}
