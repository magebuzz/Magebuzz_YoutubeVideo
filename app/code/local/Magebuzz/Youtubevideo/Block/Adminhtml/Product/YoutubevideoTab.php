<?php
/*
* Copyright (c) 2014 www.magebuzz.com 
*/

class Magebuzz_Youtubevideo_Block_Adminhtml_Product_YoutubevideoTab extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct()
	{
	  parent::__construct();
	  $this->setId('youtubevideoGrid');
	  $this->setDefaultSort('id');
	  $this->setDefaultDir('ASC');
	  $this->setSaveParametersInSession(true);
	}

	protected function _prepareCollection()
	{
	  $collection = Mage::getModel('youtubevideo/youtubevideo')->getCollection();
	  $this->setCollection($collection);
	  return parent::_prepareCollection();
	}

	protected function _prepareColumns()
	{
    $this->addColumn('id', array(
    'header_css_class' => 'a-center',       
    'header'    => Mage::helper('youtubevideo')->__('ID'),
    'field_name' => 'ids[]',        
    'align'     =>'center',
    'type'      =>'checkbox',
    'width'     => '50px', 
    'index'     => 'id',
    'values'    => $this->getVideoIds()
    ));

    

	  $this->addColumn('video_id', array(
		  'header'    => Mage::helper('youtubevideo')->__('Video ID'),
		  'align'     =>'left',
		  'index'     => 'video_id',
	  ));

	  $this->addColumn('playlist_id', array(
		  'header'    => Mage::helper('youtubevideo')->__('Playlist ID'),
		  'align'     =>'left',
		  'index'     => 'playlist_id',
	  ));

  	$this->addColumn('user_id', array(
		  'header'    => Mage::helper('youtubevideo')->__('User/Channel ID'),
		  'align'     =>'left',
		  'index'     => 'user_id',
	  ));
	  
	  $this->addColumn('video_title', array(
		  'header'    => Mage::helper('youtubevideo')->__('Title'),
		  'align'     =>'left',
		  'width'			=> '300px',
		  'index'     => 'video_title',
	  ));
	  $this->addColumn('video_duration', array(
		  'header'    => Mage::helper('youtubevideo')->__('Duration(second)'),
		  'align'     =>'left',
		  'index'     => 'video_duration',
	  ));
	  
	  $this->addColumn('video_view_count', array(
		  'header'    => Mage::helper('youtubevideo')->__('Views'),
		  'align'     =>'left',
		  'index'     => 'video_view_count',
	  ));

	  $this->addColumn('is_featured', array(
		  'header'    => Mage::helper('youtubevideo')->__('Featured Video'),
		  'align'     => 'left',
		  'width'     => '80px',
		  'index'     => 'is_featured',
		  'type'      => 'options',
		  'options'   => array(
			  1 => 'Yes',
			  0 => 'No',
		  ),
	  ));
	  
	  $this->addColumn('show_on_home', array(
		  'header'    => Mage::helper('youtubevideo')->__('Show on Home page'),
		  'align'     => 'left',
		  'width'     => '80px',
		  'index'     => 'show_on_home',
		  'type'      => 'options',
		  'options'   => array(
			  1 => 'Yes',
			  0 => 'No',
		  ),
	  ));

	  $this->addColumn('status', array(
		  'header'    => Mage::helper('youtubevideo')->__('Status'),
		  'align'     => 'left',
		  'width'     => '80px',
		  'index'     => 'status',
		  'type'      => 'options',
		  'options'   => array(
			  1 => 'Enabled',
			  0 => 'Disabled',
		  ),
	  ));
	  return parent::_prepareColumns();
	}
  public function getVideoIds(){
    $productId = $this->getRequest()->getParam('id');
    $videoProductModel = Mage::getSingleton('youtubevideo/youtubevideoproduct')->getCollection()
    ->addFieldToFilter('product_id',$productId)->getData();
    $videoIds = array();
    if($videoProductModel){
      foreach($videoProductModel as $video) {
        $videoIds[]= $video['video_id'];
      }
      return $videoIds;
    } else
    {
      return;
    }
  }
}