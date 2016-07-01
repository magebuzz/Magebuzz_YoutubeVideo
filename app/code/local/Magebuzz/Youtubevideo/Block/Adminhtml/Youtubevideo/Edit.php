<?php
/*
* Copyright (c) 2015 www.magebuzz.com 
*/

class Magebuzz_Youtubevideo_Block_Adminhtml_Youtubevideo_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'youtubevideo';
        $this->_controller = 'adminhtml_youtubevideo';
        
        $this->_updateButton('save', 'label', Mage::helper('youtubevideo')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('youtubevideo')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('youtubevideo_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'youtubevideo_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'youtubevideo_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('youtubevideo_data') && Mage::registry('youtubevideo_data')->getId() ) {
            return Mage::helper('youtubevideo')->__("Edit Video '%s'", $this->htmlEscape(Mage::registry('youtubevideo_data')->getVideoTitle()));
        } else {
            return Mage::helper('youtubevideo')->__('Add Item');
        }
    }
}