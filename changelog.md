# Change log

## dev-master
- Don't show configuration button in TYPO3 9
- Adjust php-cs-fixer configuration

## Version 0.9.1
- Register missing argument in IconForRecordViewHelper

## Version 0.9.0
- Register arguments of view helpers
- Add traits UidAware, PidAware, Hideable, Deletable and Timestampable to easyly add TYPO3 specific properties to domain models. Deprecate old traits.

## Version 0.8.0
- Add UidTrait, PidTrait, HiddenTrait and TimestampableTrait to easily add TYPO3 specific properties to models

## Version 0.7.6
- Use old language service in TYPO3 7.6

## Version 0.7.5
- Bugfix in viewhelper "disableRecord"

## Version 0.7.3
- Add viewhelper for generating hide/unhide button

## Version 0.7.2
- Add viewhelpers for generating links to edit/remove records which are not objects

## Version 0.7.1
- Set storage pid from settings only if it is defined

## Version 0.7.0
- Show flash message if no storage pid is defined

        You don't have to create this flash message manually anymore

- Add german translation for common labels

## Version 0.6.1
- Use ContextMenu instead of removed ClickMenu in TYPO3 8

## Version 0.6.0
- Add new button type _JS button_
- Add data attributes to link buttons

## Version 0.5.2
- Don't escape output of viewhelpers

## Version 0.5.1
- Compatibility for TYPO3 8 & TYPO3 7 (loading different js files with requireJS)

## Version 0.5.0
- Compatibility for TYPO3 8

## Version 0.4.0
- Add button type clipboard for pasting records from the clipboard
- Change icon of extension

## Version 0.3.0
- Add BackendSession object to store user settings
- Add controller context to return url for better usability

## Version 0.2.1
- Access BackendTemplateView properties only if view is instance of BackendTemplateView

## Version 0.2.0
- Provide PageRenderer as a property of BackendModuleActionController
- Bugfix for IconForRecord view helper

## Version 0.1.0
- Improve usability by adding tooltips to buttons and links