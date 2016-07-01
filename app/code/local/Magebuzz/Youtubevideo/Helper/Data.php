<?php
/*
* Copyright (c) 2015 www.magebuzz.com
*/

class Magebuzz_Youtubevideo_Helper_Data extends Mage_Core_Helper_Abstract
{


	public function getConfigVideoThumbnailSize($config){
		if($config){
			$size = explode(',',trim($config));
			return $size;
		}else{
			return null;
		}
	}

	public function getVideoPerRow(){
		return (int)Mage::getStoreConfig('youtubevideo/display/video_per_row');
	}

	public function showFeaturedVideo() {
		return (int)Mage::getStoreConfig('youtubevideo/display/featured_video');
	}

  public function compareVideoList($newArray,$oldArray,$productId){
    $videoProductModel = Mage::getModel('youtubevideo/youtubevideoproduct');
    $insert = array_diff($newArray, $oldArray);
    $delete = array_diff($oldArray, $newArray);
    $resource = Mage::getSingleton('core/resource');
    $writeConnection = $resource->getConnection('core_write');
    if(isset($newArray)){
      if ($delete) {
        foreach($delete as $del)
        {
          $where='youtubevideo_product.product_id = '.$productId.' AND youtubevideo_product.video_id = '.$del;
          $writeConnection->delete('youtubevideo_product', $where);
        }
      }
      if ($insert) {
        $data = array();
        foreach ($insert as $videoId) {
          $data[] = array(
          'product_id'  => $productId,
          'video_id' => $videoId,
          );
        }
        if(count($data)>0)
        {
          $writeConnection->insertMultiple('youtubevideo_product', $data);
        }
      }
    } else {
       if ($oldArray) {
        foreach($oldArray as $del)
        {
          $where='youtubevideo_product.product_id = '.$productId.' AND youtubevideo_product.video_id = '.$del;
          $writeConnection->delete('youtubevideo_product', $where);
        }
      }
    }
  }

  public function getApiKey() {
    $storeId = Mage::app()->getStore()->getId();
    return (string) Mage::getStoreConfig('youtubevideo/settings/api_key', $storeId);
  }

  public function getVideoFromPlaylist($listId) {
    $api_key = $this->getApiKey();
    $client = new Google_Client();
    $client->setDeveloperKey($api_key);
    $youtube = new Google_Service_YouTube($client);
    $result = array();
    try {
      $response = $youtube->playlistItems->listPlaylistItems(
        'snippet',
        array(
          'playlistId' => $listId,
          'maxResults' => 50,
        )
      );
      $result = $response['items'];
    }
    catch (Exception $e) {
      return array();
    }
    return $result;
  }

  public function getVideoFromUserId($userId) {
    $api_key = $this->getApiKey();
    $client = new Google_Client();
    $client->setDeveloperKey($api_key);
    $youtube = new Google_Service_YouTube($client);
    $result = array();
    try {
      // find channels by user
      $channels = $youtube->channels->listChannels(
        'contentDetails',
        array(
          'forUsername' => $userId,
          'maxResults' => 50,
        )
      );
      $uploadId = $channels['modelData']['items'][0]['contentDetails']['relatedPlaylists']['uploads'];
      if ($uploadId) {
        $response = $youtube->playlistItems->listPlaylistItems(
          'snippet',
          array(
            'playlistId' => $uploadId,
            'maxResults' => 50,
          )
        );
        $result = $response['items'];
      }
    }
    catch (Exception $e) {
      return array();
    }
    return $result;
  }
    public function countview($videoIds,$videoApiKeyConfigs){
        $JSON = file_get_contents("https://www.googleapis.com/youtube/v3/videos?part=statistics&id={$videoIds}&key={$videoApiKeyConfigs}");
        $json_data = json_decode($JSON, true);
        $viewsct = $json_data['items'][0]['statistics']['viewCount'];
        return $viewsct;
    }
}