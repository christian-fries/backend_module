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
class DisableRecordViewHelper extends AbstractViewHelper implements CompilableInterface
{

    /**
     * @var bool
     */
    protected $escapeOutput = false;

    /**
     * Returns a URL to link to hide/unhide element
     *
     * @param AbstractDomainObject $object Object to hide
     * @param string $table The name of the table of the object
     * @param string $returnUrl The url to return to after hiding record
     * @return string
     */
    public function render(AbstractDomainObject $object, $table, $returnUrl)
    {
        return static::renderStatic(
            [
                'object' => $object,
                'table' => $table,
                'returnUrl' => $returnUrl
            ],
            $this->buildRenderChildrenClosure(),
            $this->renderingContext
        );
    }

    /**
     * @param array $arguments
     * @param callable|\Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return string
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        /** @var AbstractDomainObject $object */
        $object = $arguments['object'];
        $table = $arguments['table'];

        /** @var IconFactory $iconFactory */
        $iconFactory = GeneralUtility::makeInstance(IconFactory::class);

        $labelUnhide = htmlspecialchars(LocalizationUtility::translate('LLL:EXT:lang/Resources/Private/Language/locallang_mod_web_list.xlf:unHide'));
        $labelHide = htmlspecialchars(LocalizationUtility::translate('LLL:EXT:lang/Resources/Private/Language/locallang_mod_web_list.xlf:hide'));

        if ($object->getHidden() === 1) {
            $params = 'data[' . $table . '][' . $object->getUid() . '][hidden]=0';
            return '<a class="btn btn-default t3js-record-hide" data-state="hidden" href="#"'
                . ' data-params="' . htmlspecialchars($params) . '"'
                . ' title="' . $labelUnhide . '"'
                . ' data-original-title="' . $labelUnhide . '"'
                . ' data-toggle-title="' . $labelHide . '">'
                . $iconFactory->getIcon('actions-edit-unhide', Icon::SIZE_SMALL)->render() . '</a>';
        } else {
            $params = 'data[' . $table . '][' . $object->getUid() . '][hidden]=1';
            return '<a class="btn btn-default t3js-record-hide" data-state="visible" href="#"'
                . ' data-params="' . htmlspecialchars($params) . '"'
                . ' title="' . $labelHide . '"'
                . ' data-originaltitle="' . $labelHide . '"'
                . ' data-toggle-title="' . $labelUnhide . '">'
                . $iconFactory->getIcon('actions-edit-hide', Icon::SIZE_SMALL)->render() . '</a>';
        }

    }

}
