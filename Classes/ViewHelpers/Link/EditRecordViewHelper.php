<?php
namespace CHF\BackendModule\ViewHelpers\Link;

use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Utility\VersionNumberUtility;
use TYPO3\CMS\Extbase\DomainObject\AbstractDomainObject;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

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

        $url =  BackendUtility::getModuleUrl('record_edit', $parameters);

        if (VersionNumberUtility::convertVersionNumberToInteger(TYPO3_version) >= 8007000) {
            $title = htmlspecialchars(LocalizationUtility::translate('LLL:EXT:lang/Resources/Private/Language/locallang_mod_web_list.xlf:edit'));
        } else {
            $title = htmlspecialchars($GLOBALS['LANG']->sL('LLL:EXT:lang/locallang_mod_web_list.xlf:edit'));
        }
        return '<a href="' . $url . '" title="' . $title . '">' . $this->renderChildren() . '</a>';
    }
}
