<?php
/*
* Copyright (c) 2015 www.magebuzz.com 
*/

class Magebuzz_Youtubevideo_ViewController extends Mage_Core_Controller_Front_Action
{
	public function indexAction() {	
		$this->loadLayout();  
		$this->renderLayout();
  }
	
	public function videoAction() {
		$id = $this->getRequest()->getParam('id');
		if($id){
			return $id;
		}
		return false;
	}
}