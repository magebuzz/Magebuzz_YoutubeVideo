<?php
/*
* Copyright (c) 2015 www.magebuzz.com
*/

class Magebuzz_Youtubevideo_Block_Playlist extends Mage_Core_Block_Template
{
    protected function _getVideoCollection()
    {
        $playlistId = Mage::getStoreConfig('youtubevideo/display/youtube_playlist');
        if (!empty($playlistId)) {
            $youtube = new Zend_Gdata_YouTube();
            $youtube->setMajorProtocolVersion(2);
            $feedUrl = 'http://gdata.youtube.com/feeds/api/playlists/' . $playlistId . '';
            try {
                $playlist = $youtube->getPlaylistVideoFeed($feedUrl);

                return $playlist;
            } catch (Exception $e) {
                Mage::helper('youtubevideo')->__("<p>Retriving videos errors</p>");
            }
        } else {
            Mage::helper('youtubevideo')->__("<p>Missing 'playlist_id' parameter</p>");
        }
    }

    protected function _getVideoSidebarCollection()
    {
        $playlistId = Mage::getStoreConfig('youtubevideo/display/youtube_playlist_sidebar');

        if (!empty($playlistId)) {
            $helper = Mage::helper('youtubevideo');
            $items = $helper->getVideoFromPlaylist($playlistId);
            if (count($items)) {
                return $items;
            } else {
                Mage::getSingleton('adminhtml/session')->addError($helper->__('There are no videos found in this playlist.'));
            }
        }
    }

    protected function _getBlockTitle()
    {
        $title = $this->getBlockTitle();
        return (is_null($title)) ? 'Youtube videos' : $title;
    }

}