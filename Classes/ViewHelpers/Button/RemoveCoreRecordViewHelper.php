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
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Displays a 'Delete record' button with sprite icon to remove record
 */
class RemoveCoreRecordViewHelper extends AbstractViewHelper
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
        $this->registerArgument('record', 'int', 'The uid of the record to remove.', true);
        $this->registerArgument('table', 'string', 'The table name for the new record.', true);
    }

    /**
     * @return string
     * @throws \TYPO3\CMS\Backend\Routing\Exception\RouteNotFoundException
     */
    public function render()
    {
        $record = $this->arguments['record'];
        $table = $this->arguments['table'];

        /** @var IconFactory $iconFactory */
        $iconFactory = GeneralUtility::makeInstance(IconFactory::class);
        $icon = $iconFactory->getIcon('actions-edit-delete', Icon::SIZE_SMALL)->render();

        $urlParameters = [
            'cmd[' . $table . '][' . $record . '][delete]' => 1,
            'prErr' => 1,
            'uPT' => 1,
            'redirect' => GeneralUtility::getIndpEnv('REQUEST_URI')
        ];

        $uriBuilder = GeneralUtility::makeInstance(UriBuilder::class);
        $url = $uriBuilder->buildUriFromRoute('tce_db', $urlParameters);

        $title = htmlspecialchars(LocalizationUtility::translate('LLL:EXT:core/Resources/Private/Language/locallang_mod_web_list.xlf:delete'));
        $overlayTitle = htmlspecialchars(LocalizationUtility::translate('LLL:EXT:core/Resources/Private/Language/locallang_alt_doc.xlf:label.confirm.delete_record.title'));

        return '<a class="btn btn-default t3js-modal-trigger" href="' . htmlspecialchars($url) . '"'
            . ' data-severity="warning"'
            . ' title="' . $title . '"'
            . ' data-title="' . $overlayTitle . '"'
            . ' data-content="' . htmlspecialchars(LocalizationUtility::translate('confirm', 'backend_module', [$record])) . '" '
            . ' data-button-close-text="' . htmlspecialchars($GLOBALS['LANG']->sL('LLL:EXT:lang/locallang_common.xlf:cancel')) . '"'
            . '>' . $icon . '</a>';
    }
}
