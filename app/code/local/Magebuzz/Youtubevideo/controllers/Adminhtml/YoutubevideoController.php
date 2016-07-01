<?php
/*
* Copyright (c) 2015 www.magebuzz.com
*/

class Magebuzz_Youtubevideo_Adminhtml_YoutubevideoController extends Mage_Adminhtml_Controller_action
{
    // const XML_PATH_CONFIG_YOUTUBE_USERNAME = 'youtubevideo/general/youtube_username';
    protected function _initAction() {
        $this->loadLayout()
            ->_setActiveMenu('youtubevideo/items')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));

        return $this;
    }

    public function indexAction() {
        $this->_initAction()
            ->renderLayout();
    }

    public function editAction() {
        $id     = $this->getRequest()->getParam('id');
        $model  = Mage::getModel('youtubevideo/youtubevideo')->load($id);

        if ($model->getId() || $id == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data)) {
                $model->setData($data);
            }

            Mage::register('youtubevideo_data', $model);
            $this->loadLayout();
            $this->_setActiveMenu('youtubevideo/items');
            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
            $this->_addContent($this->getLayout()->createBlock('youtubevideo/adminhtml_youtubevideo_edit'))
                ->_addLeft($this->getLayout()->createBlock('youtubevideo/adminhtml_youtubevideo_edit_tabs'));

            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('youtubevideo')->__('Item does not exist'));
            $this->_redirect('*/*/');
        }
    }

    public function importAction() {
        $this->loadLayout();
        $this->_setActiveMenu('youtubevideo/items');
        $this->_title($this->__('Youtube Video'))
            ->_title($this->__('Import Videos'));
        $this->renderLayout();
    }

    public function videoFromPlaylistAction() {
        if ($playlistId = $this->getRequest()->getParam('playlist_id')) {
            $helper = Mage::helper('youtubevideo');
            $items = $helper->getVideoFromPlaylist($playlistId);
//            Zend_Debug::dump($items);die();
            if (count($items)) {
                $this->_processImport($items, $userId);
                $this->_redirect('*/*/index');
                return $this;
            }
            else {
                Mage::getSingleton('adminhtml/session')->addError($helper->__('There are no videos found in this playlist.'));
            }
        }
        $this->_redirect('*/*/import');
    }

    public function videoUploadByUserAction() {
        if ($userId = $this->getRequest()->getParam('user_id')) {
            $helper = Mage::helper('youtubevideo');
            $items = $helper->getVideoFromUserId($userId);
            if (count($items)) {
                $this->_processImport($items, $userId);
                $this->_redirect('*/*/index');
                return $this;
            }
            else {
                Mage::getSingleton('adminhtml/session')->addError($helper->__('There are no videos found in this playlist.'));
            }
        }
        $this->_redirect('*/*/import');
    }

    protected function _processImport($items = array(), $userId) {
        $helper = Mage::helper('youtubevideo');
        $newVideo = 0;
        $updateVideo = 0;
        foreach ($items as $item) {
            try {
                $videoId = $item['id'];
                $videoData = $item['modelData']['snippet'];
                $dataModel = Mage::getModel('youtubevideo/youtubevideo');

                $video = $dataModel->getVideoByYoutubeId($videoData['resourceId']['videoId']);
                $playlistId = $this->getRequest()->getParam('playlist_id');
                if (!$video) {
                    // Add new video to database
                    $model = Mage::getModel('youtubevideo/youtubevideo');
                    $model->setPlaylistId($playlistId)
                        ->setVideoTitle($videoData['title'])
                        ->setVideoDescription($videoData['description'])
                        ->setPlaylistId($playlistId)
                        ->setCreatedTime(now())
                        ->setUpdateTime(now())
                        ->setStatus(1)
                        ->setVideoId($videoData['resourceId']['videoId'])
                        ->setUserId($videoData['channelId'])
                        ->save();
                    $newVideo++;
                } else {
                    //update existing video
                    if ($video['id']) {
                        $videoModel = $dataModel->load($video['id']);
                        $videoModel->setVideoTitle($videoData['title'])
                            ->setVideoDescription($videoData['description'])
                            ->setUpdateTime(now())
                            ->save();
                        $updateVideo++;
                    }
                }

            }
            catch (Exception $e) {
                // silence is gold
            }
        }

        if ($newVideo != 0) {
            Mage::getSingleton('adminhtml/session')->addSuccess($helper->__('Total of %d new video(s) from playlist "%s" were successfully imported', $newVideo, $playlistId));
        }
        if ($updateVideo != 0) {
            Mage::getSingleton('adminhtml/session')->addSuccess($helper->__('Total of %d video(s) were successfully updated', $updateVideo));
        }
    }

    public function newAction() {
        $this->_forward('edit');
    }

    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody($this->getLayout()->createBlock('youtubevideo/adminhtml_youtubevideo_grid')->toHtml());
    }

    public function saveAction() {
        $id = $this->getRequest()->getParam('id');
        if ($data = $this->getRequest()->getPost()) {
            if(isset($_FILES['filename']['name']) && $_FILES['filename']['name'] != '') {
                try {
                    /* Starting upload */
                    $uploader = new Varien_File_Uploader('filename');

                    // Any extention would work
                    $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
                    $uploader->setAllowRenameFiles(false);

                    // Set the file upload mode
                    // false -> get the file directly in the specified folder
                    // true -> get the file in the product like folders
                    //	(file.jpg will go in something like /media/f/i/file.jpg)

                    $uploader->setFilesDispersion(false);

                    // We set media as the upload dir
                    $path = Mage::getBaseDir('media') . DS.'youtubevideo'.DS ;
                    $uploader->save($path, $_FILES['filename']['name'] );

                } catch (Exception $e) {

                }

                //this way the name is saved in DB
                $data['filename'] = $_FILES['filename']['name'];
            }

            $model = Mage::getModel('youtubevideo/youtubevideo');
            $model->setData($data)
                ->setId($this->getRequest()->getParam('id'));

            try {
                if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
                    $model->setCreatedTime(now())
                        ->setUpdateTime(now());
                } else {
                    $model->setUpdateTime(now());
                }

                $model->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('youtubevideo')->__('Item was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);

                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('youtubevideo')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
    }

    public function deleteAction() {
        if( $this->getRequest()->getParam('id') > 0 ) {
            try {
                $model = Mage::getModel('youtubevideo/youtubevideo');

                $model->setId($this->getRequest()->getParam('id'))
                    ->delete();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
        $this->_redirect('*/*/');
    }

    public function massDeleteAction() {
        $youtubevideoIds = $this->getRequest()->getParam('youtubevideo');
        if(!is_array($youtubevideoIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($youtubevideoIds as $youtubevideoId) {
                    $youtubevideo = Mage::getModel('youtubevideo/youtubevideo')->load($youtubevideoId);
                    $youtubevideo->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($youtubevideoIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    public function massStatusAction() {
        $youtubevideoIds = $this->getRequest()->getParam('youtubevideo');
        if(!is_array($youtubevideoIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($youtubevideoIds as $youtubevideoId) {
                    $youtubevideo = Mage::getSingleton('youtubevideo/youtubevideo')
                        ->load($youtubevideoId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($youtubevideoIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    protected function _isAllowed() {
        return Mage::getSingleton('admin/session')->isAllowed('youtubevideo/items');
    }
}