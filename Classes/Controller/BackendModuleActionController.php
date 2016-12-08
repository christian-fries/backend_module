<?php
namespace CHF\BackendModule\Controller;

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

use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;
use TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder;
use TYPO3\CMS\Backend\Template\Components\ButtonBar;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Backend\View\BackendTemplateView;
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Lang\LanguageService;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Utility\HttpUtility;
use TYPO3\CMS\Core\FormProtection\FormProtectionFactory;

/**
 * BackendModule Controller
 *
 * Extend this controller to get convenience methods for backend modules
 */
class BackendModuleActionController extends ActionController {

    /**
     * @var int
     */
    protected $pageUid = 0;

    /**
     * @var IconFactory
     */
    protected $iconFactory;

    /**
     * @var BackendTemplateView
     */
    protected $view;

    /**
     * @var BackendTemplateView
     */
    protected $defaultViewObjectName = BackendTemplateView::class;

    /**
     * The menu identifier for the backend module
     *
     * @var string
     */
    protected $menuIdentifier = 'menuidentifier';

    /**
     * The menu items for the backend module
     *
     * For each menu item, provide an array with these keys:
     * ['action' => 'actionName', 'controller' => 'ControllerName', 'label' => 'MenuItem Label']
     *
     * @var array
     */
    protected $menuItems = [];

    /**
     * The buttons for the backend module
     *
     * For each button, provide an array with these keys:
     * ['table' => 'table_name', 'label' => 'Button Label', 'action' => 'actionName', 'controller' => 'ControllerName']
     *
     * @var array
     */
    protected $buttons = [];

    /**
     * The extension key of the controller extending this class
     *
     * @var string
     */
    protected $extKey;

    /**
     * The module name of the backend module extending this class
     * @var string
     */
    protected $moduleName;

    /**
     * Set this flag to true to display a button linking to the extension configuration
     *
     * @var bool
     */
    protected $showConfigurationButton = false;

    /**
     * Function will be called before every other action
     *
     * @return void
     */
    public function initializeAction()
    {
        $this->pageUid = $this->settings['storagePid'];
        $this->iconFactory = GeneralUtility::makeInstance(IconFactory::class);
        parent::initializeAction();
    }

    /**
     * @param ViewInterface $view
     */
    protected function initializeView(ViewInterface $view)
    {
        if ($view instanceof BackendTemplateView) {
            /** @var BackendTemplateView $view */
            parent::initializeView($view);
            $view->getModuleTemplate()->getDocHeaderComponent()->setMetaInformation([]);

            $pageRenderer = $this->view->getModuleTemplate()->getPageRenderer();
            $pageRenderer->loadRequireJsModule('TYPO3/CMS/Backend/ClickMenu');
            $pageRenderer->loadRequireJsModule('TYPO3/CMS/Backend/Modal');
            $pageRenderer->loadRequireJsModule('TYPO3/CMS/Backend/Tooltip');
            $pageRenderer->loadRequireJsModule('TYPO3/CMS/Recordlist/Tooltip');

            $this->createMenu();
            $this->createButtons();
            $this->view->assign('T3_THIS_LOCATION', urlencode(GeneralUtility::getIndpEnv('REQUEST_URI')));
        }
        $this->view->assign('storagePid', $this->pageUid);
        $this->view->assign('returnUrl', rawurlencode(BackendUtility::getModuleUrl($this->moduleName)));
    }

    /**
     * Create menu for backend module
     *
     * @return void
     */
    protected function createMenu()
    {
        /** @var UriBuilder $uriBuilder */
        $uriBuilder = $this->objectManager->get(UriBuilder::class);
        $uriBuilder->setRequest($this->request);

        $menu = $this->view->getModuleTemplate()->getDocHeaderComponent()->getMenuRegistry()->makeMenu();
        $menu->setIdentifier($this->menuIdentifier);

        foreach ($this->menuItems as $menuItem) {
            $item = $menu->makeMenuItem()
                ->setTitle($menuItem['label'])
                ->setHref($uriBuilder->reset()->uriFor($menuItem['action'], [], $menuItem['controller']))
                ->setActive($this->request->getControllerActionName() === $menuItem['action'] && $this->request->getControllerName() === $menuItem['controller']);
            $menu->addMenuItem($item);
        }

        $this->view->getModuleTemplate()->getDocHeaderComponent()->getMenuRegistry()->addMenu($menu);
    }

    /**
     * Create the panel of buttons for the backend module
     *
     * @return void
     */
    protected function createButtons()
    {
        $buttonBar = $this->view->getModuleTemplate()->getDocHeaderComponent()->getButtonBar();
        $uriBuilder = $this->objectManager->get(UriBuilder::class);
        $uriBuilder->setRequest($this->request);

        foreach ($this->buttons as $key => $button) {
            if ($button === null) continue;

            $viewButton = $buttonBar->makeLinkButton()
                    ->setHref($button['href'])
                    ->setTitle($button['title'])
                    ->setIcon($button['icon']);

            if ($button['displayConditions'] === null ||
                (
                    array_key_exists($this->request->getControllerName(), $button['displayConditions']) &&
                    in_array($this->request->getControllerActionName(), $button['displayConditions'][$this->request->getControllerName()]))
            )
            {
                $buttonBar->addButton($viewButton, ButtonBar::BUTTON_POSITION_LEFT, $key);
            }
        }

        if ($this->extKey && $this->moduleName && $this->showConfigurationButton && $this->getBackendUser()->isAdmin())
        {
            $configurationLink = BackendUtility::getModuleUrl('tools_ExtensionmanagerExtensionmanager', [
                'tx_extensionmanager_tools_extensionmanagerextensionmanager' => [
                    'action' => 'showConfigurationForm',
                    'controller' => 'Configuration',
                    'extension' => ['key' => $this->extKey]
                ]
            ]);

            $returnUrl = 'index.php?M=' . $this->moduleName . '&id=' . $this->pageUid . $this->getToken('tools_ExtensionmanagerExtensionmanager');

            $configurationButton = $buttonBar->makeLinkButton()
                ->setHref($configurationLink . '&returnUrl=' . $returnUrl)
                ->setTitle($this->getLanguageService()->sL('LLL:EXT:backend_module/Resources/Private/Language/locallang.xlf:configuration.label'))
                ->setIcon($this->view->getModuleTemplate()->getIconFactory()->getIcon('actions-system-extension-configure',
                    Icon::SIZE_SMALL));
            $buttonBar->addButton($configurationButton, ButtonBar::BUTTON_POSITION_RIGHT);
        }
    }

    /**
     * Return button to create new record
     *
     * @param string $table Name of the table
     * @param string $title Title of the button
     * @param mixed $displayConditions An array configuring display conditions with key as controller name and action as array with actions
     * @param string $iconIdentifier Name of the icon to use. If no icon is defined, the icon of the record will be used.
     * @param string $returnUrl Url to return to after creating new record
     * @return array|null
     */
    protected function createNewRecordButton($table, $title, $displayConditions = null, $iconIdentifier = 'actions-document-new', $returnUrl = null)
    {
        if (!GeneralUtility::inList($this->getBackendUser()->groupData['tables_modify'], $table)
            && !$this->getBackendUser()->isAdmin()
        || $this->pageUid === 0) return null;

        $icon = $this->iconFactory->getIcon($iconIdentifier, Icon::SIZE_SMALL);

        if ($returnUrl === null) {
            $returnUrl = 'index.php?M=' . $this->moduleName . '&id=' . $this->pageUid . $this->getToken($this->moduleName);
        }

        $url =  BackendUtility::getModuleUrl('record_edit', [
            'edit[' . $table . '][' . $this->pageUid . ']' => 'new',
            'returnUrl' => $returnUrl
        ]);

        return [
            'type' => 'new',
            'href' => $url,
            'title' => $title,
            'icon' => $icon,
            'displayConditions' => $displayConditions
        ];
    }

    /**
     * Return button to call some extbase action
     *
     * @param string $action Name of the action
     * @param string $controller Name of the controller
     * @param string $title Title of the button
     * @param string $icon Icon of the button
     * @param mixed $displayConditions An array configuring display conditions with key as controller name and action as array with actions
     * @param array $arguments Arguments to add to the button
     * @return array
     */
    protected function createActionButton($action, $controller, $title, $icon, $displayConditions = null, $arguments = [])
    {
        $uriBuilder = $this->objectManager->get(UriBuilder::class);
        $uriBuilder->setRequest($this->request);

        $url = $uriBuilder->reset()->setRequest($this->request)->uriFor($action, $arguments, $controller);

        return [
            'type' => 'action',
            'href' => $url,
            'title' => $title,
            'icon' => $icon,
            'displayConditions' => $displayConditions
        ];
    }

    /**
     * Redirect to TCEFORM to create a new record
     *
     * @param string $table table name
     * @throws \Exception
     * @return void
     */
    protected function redirectToCreateNewRecord($table)
    {
        if (!isset($this->moduleName))
        {
            throw new \Exception('The module name is not defined. Define $this->moduleName in the initializeAction mehtod in your controller extending the BackendActionController.', '1471456225');
        }

        $returnUrl = 'index.php?M=' . $this->moduleName . '&id=' . $this->pageUid . $this->getToken($this->moduleName);
        $url = BackendUtility::getModuleUrl('record_edit', [
            'edit[' . $table . '][' . $this->pageUid . ']' => 'new',
            'returnUrl' => $returnUrl
        ]);
        HttpUtility::redirect($url);
    }

    /**
     * Redirect to TCEFORM to edit a record
     *
     * @param string $table table name
     * @throws \Exception
     * @return void
     */
    protected function redirectToEditRecord($table, $recordId)
    {
        if (!isset($this->moduleName))
        {
            throw new \Exception('The module name is not defined. Define $this->moduleName in the initializeAction mehtod in your controller extending the BackendActionController.', '1471456225');
        }

        $returnUrl = 'index.php?M=' . $this->moduleName . '&id=' . $this->pageUid . $this->getToken($this->moduleName);
        $url = BackendUtility::getModuleUrl('record_edit', [
            'edit[' . $table . '][' . $recordId . ']' => 'edit',
            'returnUrl' => $returnUrl
        ]);
        HttpUtility::redirect($url);
    }

    /**
     * Get a CSRF token
     *
     * @param string $moduleName The full name of the module e.g. tools_ExtensionnameModulename
     * @param bool $tokenOnly Set it to TRUE to get only the token, otherwise including the &moduleToken= as prefix
     * @return string
     */
    private function getToken($moduleName, $tokenOnly = false)
    {
        $token = FormProtectionFactory::get()->generateToken('moduleCall', $moduleName);
        if ($tokenOnly) {
            return $token;
        } else {
            return '&moduleToken=' . $token;
        }
    }

    /**
     * @param $menuIdentifier
     */
    public function setMenuIdentifier($menuIdentifier) {
        $this->menuIdentifier = $menuIdentifier;
    }

    /**
     * @param $menuItems
     */
    public function setMenuItems($menuItems)
    {
        $this->menuItems = $menuItems;
    }

    /**
     * @param $buttons
     */
    public function setButtons($buttons)
    {
        $this->buttons = $buttons;
    }

    /**
     * @return BackendUserAuthentication
     */
    protected function getBackendUser()
    {
        return $GLOBALS['BE_USER'];
    }

    /**
     * @return LanguageService
     */
    protected function getLanguageService()
    {
        return $GLOBALS['LANG'];
    }
}