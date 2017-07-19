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
use TYPO3\CMS\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Fluid\Core\ViewHelper\Facets\CompilableInterface;

/**
 * Displays a 'Edit record' button with default icon to edit record
 */
class EditCoreRecordViewHelper extends AbstractViewHelper implements CompilableInterface
{

    /**
     * @var bool
     */
    protected $escapeOutput = false;

    /**
     * Returns a URL to link to FormEngine
     *
     * @param integer $record Uid of the record to edit
     * @param string $table The name of the table of the object
     * @param string $returnUrl The url to return to after editing record
     * @return string
     */
    public function render($record, $table, $returnUrl)
    {
        return static::renderStatic(
            [
                'record' => $record,
                'table' => $table,
                'returnUrl' => $returnUrl
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
        $returnUrl = $arguments['returnUrl'];
        $parameters = [
            rawurldecode('edit[' . $table . '][' . $record . ']') => 'edit',
            'returnUrl' => rawurldecode($returnUrl)
        ];

        /** @var IconFactory $iconFactory */
        $iconFactory = GeneralUtility::makeInstance(IconFactory::class);

        $url = BackendUtility::getModuleUrl('record_edit', $parameters);

        return '<a class="btn btn-default" href="' . htmlspecialchars($url) . '" title="' . htmlspecialchars($GLOBALS['LANG']->sL('LLL:EXT:lang/locallang_mod_web_list.xlf:edit')) . '">'
            . $iconFactory->getIcon('actions-document-open', Icon::SIZE_SMALL)->render() . '</a>';
    }
}
