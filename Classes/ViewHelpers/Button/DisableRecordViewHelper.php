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

use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\DomainObject\AbstractDomainObject;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Displays a 'Delete record' button with sprite icon to remove record
 */
class DisableRecordViewHelper extends AbstractViewHelper
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
        $this->registerArgument('object', 'mixed', 'The object to hide.', true);
        $this->registerArgument('table', 'string', 'The table name of the record to disable.', true);
        $this->registerArgument('returnUrl', 'string', 'The return url.', true);
        $this->registerArgument('disableField', 'string', 'The field containing the disable state.', false, 'hidden');
    }

    /**
     * @return string
     */
    public function render()
    {
        /** @var AbstractDomainObject $object */
        $object = $this->arguments['object'];
        $table = $this->arguments['table'];
        $disableField = $this->arguments['disableField'];

        /** @var IconFactory $iconFactory */
        $iconFactory = GeneralUtility::makeInstance(IconFactory::class);

        $labelUnhide = htmlspecialchars(LocalizationUtility::translate('LLL:EXT:core/Resources/Private/Language/locallang_mod_web_list.xlf:unHide'));
        $labelHide = htmlspecialchars(LocalizationUtility::translate('LLL:EXT:core/Resources/Private/Language/locallang_mod_web_list.xlf:hide'));

        $getMethod = 'get' . GeneralUtility::underscoredToUpperCamelCase($disableField);
        $setMethod = 'set' . GeneralUtility::underscoredToUpperCamelCase($disableField);

        if ($object->$getMethod() === 1 || $object->$getMethod() === true) {
            $params = 'data[' . $table . '][' . $object->getUid() . '][' . $disableField . ']=0';
            return '<a class="btn btn-default t3js-record-hide" data-state="hidden" href="#"'
                . ' data-params="' . htmlspecialchars($params) . '"'
                . ' title="' . $labelUnhide . '"'
                . ' data-original-title="' . $labelUnhide . '"'
                . ' data-toggle-title="' . $labelHide . '">'
                . $iconFactory->getIcon('actions-edit-unhide', Icon::SIZE_SMALL)->render() . '</a>';
        }
        $params = 'data[' . $table . '][' . $object->getUid() . '][' . $disableField . ']=1';
        return '<a class="btn btn-default t3js-record-hide" data-state="visible" href="#"'
                . ' data-params="' . htmlspecialchars($params) . '"'
                . ' title="' . $labelHide . '"'
                . ' data-originaltitle="' . $labelHide . '"'
                . ' data-toggle-title="' . $labelUnhide . '">'
                . $iconFactory->getIcon('actions-edit-hide', Icon::SIZE_SMALL)->render() . '</a>';
    }
}
