<?php

require_once(Mage::getModuleDir('controllers','Mage_Adminhtml').DS.'Catalog'.DS.'ProductController.php');

class Magebuzz_Youtubevideo_Adminhtml_Catalog_ProductController extends Mage_Adminhtml_Catalog_ProductController {
    /**
     * Get custom products grid
     */
    public function youtubevideoGridAction()
    {
        $this->_initProduct();
        $this->loadLayout();
        $this->getResponse()->setBody($this->getLayout()->createBlock('youtubevideo/adminhtml_catalog_product_edit_tabs_youtubevideoTab')->toHtml());
//            ->setProductsYoutubevideo($this->getRequest()->getPost('video_id', null));
//        $this->renderLayout();
    }

}