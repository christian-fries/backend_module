<?php
namespace CHF\BackendModule\ViewHelpers\Button;

use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Fluid\Core\ViewHelper\Facets\CompilableInterface;

/**
 * Displays a 'Delete record' button with sprite icon to remove record
 */
class RemoveCoreRecordViewHelper extends AbstractViewHelper implements CompilableInterface
{
    /**
     * @var bool
     */
    protected $escapeOutput = false;

    /**
     * Render link with sprite icon to remove record
     *
     * @param int $record Uid of the record to remove
     * @param string $table The name of the table of the object
     * @param string $identifier The name of the property identifying this record
     * @return string
     */
    public function render($record, $table, $identifier = 'title')
    {
        return static::renderStatic(
            [
                'record' => $record,
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
        $record = $arguments['record'];
        $table = $arguments['table'];
        $identifier = $arguments['identifier'];

        /** @var IconFactory $iconFactory */
        $iconFactory = GeneralUtility::makeInstance(IconFactory::class);

        $urlParameters = [
            'cmd[' . $table . '][' . $record . '][delete]' => 1,
            'prErr' => 1,
            'uPT' => 1,
            'redirect' => GeneralUtility::getIndpEnv('REQUEST_URI')
        ];
        $url = BackendUtility::getModuleUrl('tce_db', $urlParameters);

        return '<a class="btn btn-default t3js-modal-trigger" href="' . htmlspecialchars($url) . '"'
            . ' data-severity="warning"'
            . ' title="' . htmlspecialchars($GLOBALS['LANG']->sL('LLL:EXT:lang/locallang_mod_web_list.xlf:delete')) . '"'
            . ' data-title="' . htmlspecialchars($GLOBALS['LANG']->sL('LLL:EXT:lang/locallang_alt_doc.xlf:label.confirm.delete_record.title')) . '"'
            . ' data-content="' . htmlspecialchars(LocalizationUtility::translate('confirm', 'backend_module', [$record])) . '" '
            . ' data-button-close-text="' . htmlspecialchars($GLOBALS['LANG']->sL('LLL:EXT:lang/locallang_common.xlf:cancel')) . '"'
            . '>' . $iconFactory->getIcon('actions-edit-delete', Icon::SIZE_SMALL)->render() . '</a>';
    }
}
