<?php
namespace CHF\BackendModule\ViewHelpers\Button;

/***
 *
 * This file is part of the "Backend Module" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2016 Christian Fries <hallo@christian-fries.ch>
 *
 ***/

use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\DomainObject\AbstractDomainObject;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Fluid\Core\ViewHelper\Facets\CompilableInterface;

/**
 * Displays a 'Delete record' button with sprite icon to remove record
 */
class RemoveRecordViewHelper extends AbstractViewHelper implements CompilableInterface
{
    /**
     * Render link with sprite icon to remove record
     *
     * @param AbstractDomainObject $object Object to remove
     * @param string $table The name of the table of the object
     * @param string $identifier The name of the property identifying this record
     * @return string
     */
    public function render(AbstractDomainObject $object, $table, $identifier = 'title')
    {
        return static::renderStatic(
            [
                'object' => $object,
                'table' => $table,
                'identifier' => $identifier
            ],
            $this->buildRenderChildrenClosure(),
            $this->renderingContext
        );
    }

    /**
     * @param array $arguments
     * @param callable $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     *
     * @return string
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        /** @var AbstractDomainObject $object */
        $object = $arguments['object'];
        $table = $arguments['table'];
        $identifier = $arguments['identifier'];

        /** @var IconFactory $iconFactory */
        $iconFactory = GeneralUtility::makeInstance(IconFactory::class);

        $urlParameters = [
            'cmd[' . $table . '][' . $object->getUid() . '][delete]' => 1,
            'prErr' => 1,
            'uPT' => 1,
            'redirect' => GeneralUtility::getIndpEnv('REQUEST_URI')
        ];
        $url = BackendUtility::getModuleUrl('tce_db', $urlParameters);

        return '<a class="btn btn-default t3js-modal-trigger" href="' . htmlspecialchars($url) . '"'
            . ' data-severity="warning"'
            . ' title="' . htmlspecialchars($GLOBALS['LANG']->sL('LLL:EXT:lang/locallang_mod_web_list.xlf:delete')) . '"'
            . ' data-title="' . htmlspecialchars($GLOBALS['LANG']->sL('LLL:EXT:lang/locallang_alt_doc.xlf:label.confirm.delete_record.title')) . '"'
            . ' data-content="' . htmlspecialchars(LocalizationUtility::translate('confirm', 'backend_module', [$object->_getProperty($identifier)])) . '" '
            . ' data-button-close-text="' . htmlspecialchars($GLOBALS['LANG']->sL('LLL:EXT:lang/locallang_common.xlf:cancel')) . '"'
            . '>' . $iconFactory->getIcon('actions-edit-delete', Icon::SIZE_SMALL)->render() . '</a>';
    }
}
