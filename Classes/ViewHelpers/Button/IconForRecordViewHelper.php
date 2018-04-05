<?php
namespace CHF\BackendModule\ViewHelpers\Button;

use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\VersionNumberUtility;
use TYPO3\CMS\Fluid\ViewHelpers\Be\AbstractBackendViewHelper;

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
 */
class IconForRecordViewHelper extends AbstractBackendViewHelper
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
        $this->registerArgument('table', 'string', 'The table name of the record.', true);
        $this->registerArgument('uid', 'int', 'The uid of the record.', true);
        $this->registerArgument('enableContextMenu', 'bool', 'Whether or not the context menu should be opend when clicking the icon.', false, true);
        $this->registerArgument('enableClickMenu', 'bool', 'Whether or not the context menu should be opend when clicking the icon.', false, true);
    }

    /**
     * @return string
     */
    public function render()
    {
        $table = $this->arguments['table'];
        $uid = $this->arguments['uid'];
        $enableContextMenu = $this->arguments['enableContextMenu'];
        $enableClickMenu = $this->arguments['enableClickMenu'];

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
                } else {
                    $iconTag .= ' onclick="TYPO3.ClickMenu.show(\'' . $table . '\', \'' . $uid . '\', \'1\', \'\', \'\', \'\'); return false;"';
                }
            }
            $icon = $iconFactory->getIconForRecord($table, $row, Icon::SIZE_SMALL)->render();
            $iconTag .= '><span>' . $icon . '</span></a>';
        }

        return $iconTag;
    }
}
