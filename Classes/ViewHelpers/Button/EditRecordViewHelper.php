<?php

namespace CHF\BackendModule\ViewHelpers\Button;

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
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\DomainObject\AbstractDomainObject;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Displays a 'Edit record' button with default icon to edit record
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

        /** @var IconFactory $iconFactory */
        $iconFactory = GeneralUtility::makeInstance(IconFactory::class);
        $icon = $iconFactory->getIcon('actions-document-open', Icon::SIZE_SMALL)->render();

        $uriBuilder = GeneralUtility::makeInstance(UriBuilder::class);
        $url = $uriBuilder->buildUriFromRoute('record_edit', $parameters);

        if (\TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger(TYPO3_version) >= 8007000) {
            $title = htmlspecialchars(LocalizationUtility::translate('LLL:EXT:lang/Resources/Private/Language/locallang_mod_web_list.xlf:edit'));
        } else {
            $title = htmlspecialchars($GLOBALS['LANG']->sL('LLL:EXT:lang/locallang_mod_web_list.xlf:edit'));
        }

        return '<a class="btn btn-default" href="' . htmlspecialchars($url) . '" title="' . $title . '">' . $icon . '</a>';
    }
}
