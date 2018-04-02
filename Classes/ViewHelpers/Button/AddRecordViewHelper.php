<?php
namespace CHF\BackendModule\ViewHelpers\Button;

use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\VersionNumberUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Displays a 'Add record' button with default icon to add record
 */
class AddRecordViewHelper extends AbstractViewHelper
{
    /**
     * @var bool
     */
    protected $escapeOutput = false;

    /**
     * Initialize arguments.
     * @throws \TYPO3\CMS\Fluid\Core\ViewHelper\Exception
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('table', 'string', 'The table name of the new record.', true);
        $this->registerArgument('pid', 'int', 'The pid of the new record.', true);
        $this->registerArgument('returnUrl', 'string', 'The return url.', true);
    }

    /**
     * @return string
     */
    public function render()
    {
        $pid = $this->arguments['pid'];
        $table = $this->arguments['table'];
        $returnUrl = $this->arguments['returnUrl'];
        $parameters = [
            rawurldecode('edit[' . $table . '][' . $pid . ']') => 'new',
            'returnUrl' => rawurldecode($returnUrl)
        ];

        /** @var IconFactory $iconFactory */
        $iconFactory = GeneralUtility::makeInstance(IconFactory::class);
        $icon = $iconFactory->getIcon('actions-add', Icon::SIZE_SMALL)->render();
        $url = BackendUtility::getModuleUrl('record_edit', $parameters);
        if (VersionNumberUtility::convertVersionNumberToInteger(TYPO3_version) >= 8007000) {
            $title = htmlspecialchars(LocalizationUtility::translate('LLL:EXT:lang/Resources/Private/Language/locallang_mod_web_list.xlf:newRecordGeneral'));
        } else {
            $title = htmlspecialchars($GLOBALS['LANG']->sL('LLL:EXT:lang/locallang_mod_web_list.xlf:newRecordGeneral'));
        }

        return '<a class="btn btn-default" href="' . htmlspecialchars($url) . '" title="' . $title . '">' . $icon . '</a>';
    }
}
