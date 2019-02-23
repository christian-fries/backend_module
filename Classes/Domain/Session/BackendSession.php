<?php

namespace CHF\BackendModule\Domain\Session;

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

use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;

class BackendSession
{
    /**
     * The backend session object
     *
     * @var BackendUserAuthentication
     */
    protected $sessionObject = null;

    /**
     * Unique key to store data in the session.
     * Overwrite this key in your initializeAction method.
     *
     * @var string
     */
    protected $storageKey = 'backend_module';

    public function __construct()
    {
        $this->sessionObject = $GLOBALS['BE_USER'];
    }

    public function setStorageKey($storageKey)
    {
        $this->storageKey = $storageKey;
    }

    /**
     * Store a value in the session
     *
     * @param string $key
     * @param mixed $value
     */
    public function store($key, $value)
    {
        $sessionData = $this->sessionObject->getSessionData($this->storageKey);
        $sessionData[$key] = $value;
        $this->sessionObject->setAndSaveSessionData($this->storageKey, $sessionData);
    }

    /**
     * Delete a value from the session
     *
     * @param string $key
     */
    public function delete($key)
    {
        $sessionData = $this->sessionObject->getSessionData($this->storageKey);
        unset($sessionData[$key]);
        $this->sessionObject->setAndSaveSessionData($this->storageKey, $sessionData);
    }

    /**
     * Read a value from the session
     *
     * @param string $key
     * @return mixed
     */
    public function get($key)
    {
        $sessionData = $this->sessionObject->getSessionData($this->storageKey);
        return isset($sessionData[$key]) ? $sessionData[$key] : null;
    }
}
