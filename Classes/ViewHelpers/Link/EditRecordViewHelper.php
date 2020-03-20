<?php

namespace CHF\BackendModule\ViewHelpers\Link;

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

use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\DomainObject\AbstractDomainObject;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Creates 'Edit record' link
 */
class EditRecordViewHelper extends AbstractViewHelper
{
    /**
     * @var bool
     */
    protected $escapeOutput = false;

    /**
     * Initialize arguments.
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('object', 'mixed', 'The object to edit.', true);
        $this->registerArgument('table', 'string', 'The table name of the record to edit.', true);
        $this->registerArgument('returnUrl', 'string', 'The return url.', true);
    }

    /**
     * @return string
     * @throws \TYPO3\CMS\Backend\Routing\Exception\RouteNotFoundException
     */
    public function render()
    {
        /** @var AbstractDomainObject $object */
        $object = $this->arguments['object'];
        $table = $this->arguments['table'];
        $returnUrl = $this->arguments['returnUrl'];
        $parameters = [
            rawurldecode('edit[' . $table . '][' . $object->getUid() . ']') => 'edit',
            'returnUrl' => rawurldecode($returnUrl)
        ];

        $uriBuilder = GeneralUtility::makeInstance(UriBuilder::class);
        $url = $uriBuilder->buildUriFromRoute('record_edit', $parameters);

        $title = htmlspecialchars(LocalizationUtility::translate('LLL:EXT:core/Resources/Private/Language/locallang_mod_web_list.xlf:edit'));

        return '<a href="' . $url . '" title="' . $title . '">' . $this->renderChildren() . '</a>';
    }
}
