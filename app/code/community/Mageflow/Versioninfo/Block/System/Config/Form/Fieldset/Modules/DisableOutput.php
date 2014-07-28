<?php
/**
 * DisableOutput.php
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@mageflow.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * If you wish to use the MageFlow Connect extension as part of a paid
 * service please contact licence@mageflow.com for information about
 * obtaining an appropriate licence.
 */

/**
 * This class adds extension version numbers to output in the backend module list
 *
 * @category   MFX
 * @package    Mageflow_Versioninfo
 * @subpackage Configuration
 * @author     MageFlow OÜ, Estonia <info@mageflow.com>
 * @copyright  Copyright (C) 2014 MageFlow OÜ, Estonia (http://mageflow.com) 
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link       http://mageflow.com/
 */
class Mageflow_Versioninfo_Block_System_Config_Form_Fieldset_Modules_DisableOutput
    extends Mage_Adminhtml_Block_System_Config_Form_Fieldset_Modules_DisableOutput
{

    /**
     * This method overloads parent's method and adds Magento Extension version number to output
     *
     * @param $fieldset
     * @param $moduleName
     *
     * @return mixed
     */
    protected function _getFieldHtml($fieldset, $moduleName)
    {
        $configData = $this->getConfigData();
        $path = 'advanced/modules_disable_output/' . $moduleName; //TODO: move as property of form
        if (isset($configData[$path])) {
            $data = $configData[$path];
            $inherit = false;
        } else {
            $data = (int)(string)$this->getForm()->getConfigRoot()->descend($path);
            $inherit = true;
        }

        $e = $this->_getDummyElement();

        $versionArr = Mage::getConfig()->getXpath('/*//modules/' . $moduleName . '/version/text()');

        if (is_array($versionArr) && sizeof($versionArr) > 0) {
            $version = (string)$versionArr[0];
        }

        $field = $fieldset->addField(
            $moduleName, 'select',
            array(
                'name'                  => 'groups[modules_disable_output][fields][' . $moduleName . '][value]',
                'label'                 => $moduleName . ' ' . $version,
                'value'                 => $data,
                'values'                => $this->_getValues(),
                'inherit'               => $inherit,
                'can_use_default_value' => $this->getForm()->canUseDefaultValue($e),
                'can_use_website_value' => $this->getForm()->canUseWebsiteValue($e),
            )
        )->setRenderer($this->_getFieldRenderer());

        return $field->toHtml();
    }
} 