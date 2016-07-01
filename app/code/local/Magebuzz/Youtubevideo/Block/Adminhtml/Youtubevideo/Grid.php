<?php
/*
* Copyright (c) 2015 www.magebuzz.com 
*/

class Magebuzz_Youtubevideo_Block_Adminhtml_Youtubevideo_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct()
	{
	  parent::__construct();
	  $this->setId('youtubevideoGrid');
	  $this->setUseAjax(true);
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
		  'header'    => Mage::helper('youtubevideo')->__('ID'),
		  'align'     =>'right',
		  'index'     => 'id',
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

		$this->addColumn('action',
			array(
				'header'    =>  Mage::helper('youtubevideo')->__('Action'),
				'width'     => '100',
				'type'      => 'action',
				'getter'    => 'getId',
				'actions'   => array(
					array(
						'caption'   => Mage::helper('youtubevideo')->__('Edit'),
						'url'       => array('base'=> '*/*/edit'),
						'field'     => 'id'
					)
				),
				'filter'    => false,
				'sortable'  => false,
				'index'     => 'stores',
				'is_system' => true,
		));
	
	  return parent::_prepareColumns();
	}

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('video_id');
        $this->getMassactionBlock()->setFormFieldName('youtubevideo');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('youtubevideo')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('youtubevideo')->__('Are you sure?')
        ));
        $statuses = array(
            '' => '',
            1 => Mage::helper('youtubevideo')->__('Enabled'),
            0 => Mage::helper('youtubevideo')->__('Disabled')
        );
//        $statuses = Mage::getSingleton('youtubevideo/status')->getOptionArray();

//        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('youtubevideo')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('youtubevideo')->__('Status'),
                         'values' => $statuses
                     )
             )
        ));
        return $this;
    }

	public function getRowUrl($row)
	{
	  return $this->getUrl('*/*/edit', array('id' => $row->getId()));
	}
	public function getGridUrl()
	{
		return $this->getUrl('*/*/grid', array('_current'=> true));
	}  

}