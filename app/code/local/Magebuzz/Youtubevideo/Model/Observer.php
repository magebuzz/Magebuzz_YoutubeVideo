<?php
/*
* Copyright (c) 2015 www.magebuzz.com 
*/

class Magebuzz_Youtubevideo_Model_Observer extends Mage_Core_Model_Abstract
{
  public function addTabYoutubevideo($observer) {
    $block = $observer->getEvent()->getBlock(); 
    if($block instanceof Mage_Adminhtml_Block_Catalog_Product_Edit_Tabs) {
      if(Mage::app()->getRequest()->getActionName()=='edit' || Mage::app()->getRequest()->getParam('type')) {
        $block->addTab('youtube_video',array(
        'label'  =>Mage::helper('youtubevideo')->__('Youtube Video'),
        'content' =>$block->getLayout()->createBlock('youtubevideo/adminhtml_product_youtubevideoTab')->toHtml())
        );
      }
    }
  }
  public function assignVideoToProduct($observer) {
    $videoIds = $observer->getEvent()->getRequest()->getPost('ids');
    $productId = $observer->getEvent()->getProduct()->getId();
    $videoProductCollection = Mage::getModel('youtubevideo/youtubevideoproduct')->getCollection()->addFieldToFilter('product_id',$productId)->getData() ;
    $videoIdsOld = array();
    if($videoProductCollection) {
      foreach($videoProductCollection as $video){
        $videoIdsOld[] =  $video['video_id'] ;
      }
    }
    //Zend_Debug::dump($videoIdsOld);die();
    Mage::helper('youtubevideo')->compareVideoList($videoIds,$videoIdsOld,$productId);
 
  }
}