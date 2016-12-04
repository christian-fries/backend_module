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

/**
 * ViewHelper to show sprite icon for a record
 *
 * # Example: Basic example
 * <code>
 * <bm:buttons.iconForRecord table="tx_myext_domain_model_mymodel" uid="{mymodel.uid}" title="" />
 * </code>
 * <output>
 * Icon of the record with the given uid
 * </output>
 *
 */
class IconForRecordViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\Be\AbstractBackendViewHelper
{
    /**
     * @var bool
     */
    protected $escapeOutput = false;

    /**
     * Render the sprite icon
     *
     * @param string $table table name
     * @param int $uid uid of record
     * @param string $title title
     * @return string sprite icon
     */
    public function render($table, $uid, $title = "")
    {
        $icon = '';
        $row = BackendUtility::getRecord($table, $uid);
        if (is_array($row)) {
            /** @var IconFactory $iconFactory */
            $iconFactory = GeneralUtility::makeInstance(IconFactory::class);
            $icon = '<span title="' . htmlspecialchars($title) . '">'
                . $iconFactory->getIconForRecord($table, $row, Icon::SIZE_SMALL)->render()
                . '</span>';
        }

        return $icon;
    }
}
