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
use TYPO3\CMS\Core\Utility\VersionNumberUtility;

/**
 * ViewHelper to show sprite icon for a record and ClickMenu
 *
 * # Example: Basic example
 * <code>
 * <bm:button.iconForRecord table="tx_myext_domain_model_mymodel" uid="{mymodel.uid}" enableContextMenu="true" />
 * </code>
 * <output>
 * Icon of the record with the given uid and ClickMenu if enabled.
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
     * @param boolean $enableContextMenu Whether or not the context menu should be opened when clicking on the icon
     * @param boolean $enableClickMenu Deprecated, use enableContextMenu instead. Will be removed in a future release.
     * @return string sprite icon
     */
    public function render($table, $uid, $enableContextMenu = true, $enableClickMenu = true)
    {
        // Compatibility for TYPO3 7: Check enableClickMenu param
        if (!$enableContextMenu && !$enableClickMenu) {
            $enableContextMenu = false;
        }

        $iconTag = '';
        $row = BackendUtility::getRecord($table, $uid);
        if (is_array($row)) {
            /** @var IconFactory $iconFactory */
            $iconFactory = GeneralUtility::makeInstance(IconFactory::class);
            $iconTag = '<a title="id=' . $uid . '"';
            if ($enableContextMenu) {
                if (VersionNumberUtility::convertVersionNumberToInteger(TYPO3_version) >= 8007000) {
                    $iconTag .= ' class="t3js-contextmenutrigger" data-table="' . $table . '" data-uid="' . $uid . '"';
                }
                else {
                    $iconTag .= ' onclick="TYPO3.ClickMenu.show(\'' . $table . '\', \'' . $uid . '\', \'1\', \'\', \'\', \'\'); return false;"';
                }
            }
            $iconTag .= '><span>'
                . $iconFactory->getIconForRecord($table, $row, Icon::SIZE_SMALL)->render()
                . '</span></a>';
        }

        return $iconTag;
    }
}
