<?php
/*
* Copyright (c) 2015 www.magebuzz.com
*/
require_once Mage::getBaseDir('lib') . "/Google/Client.php";
require_once Mage::getBaseDir('lib') . "/Google/Service/YouTube.php";

class Magebuzz_Youtubevideo_IndexController extends Mage_Core_Controller_Front_Action
{

  public function indexAction() {
    $this->loadLayout();
    $this->getLayout()->getBlock('head')->setTitle(Mage::getStoreConfig('youtubevideo/display/heading'));
    $this->renderLayout();
  }

  public function testAction() {
    $DEVELOPER_KEY = 'AIzaSyCawjlIIae904jwzXFrUTmt0JwowWYhYkk';
    $key = Mage::helper('youtubevideo')->getApiKey();

    $client = new Google_Client();

    $client->setDeveloperKey($DEVELOPER_KEY);

    // $client->setClientId($OAUTH2_CLIENT_ID);
    // $client->setClientSecret($OAUTH2_CLIENT_SECRET);
    // $client->setScopes('https://www.googleapis.com/auth/youtube');

    $youtube = new Google_Service_YouTube($client);
    $listId = 'PL8fVUTBmJhHITxZ2AlYoL-fi9tBNRfc_D';
    $userId = 'MageBuzz';
    try {
      //search
      $searchResponse = $youtube->search->listSearch('id,snippet', array(
        'q' => 'Ninja Turtle',
        'maxResults' => '5',
      ));

      //playlist
      $result = $youtube->playlistItems->listPlaylistItems(
        'snippet',
        array(
          'playlistId' => $listId,
          'maxResults' => 50,
        )
      );

      //user
      $result1 = $youtube->channels->listChannels(
        'contentDetails',
        array(
          'forUsername' => $userId,
          'maxResults' => 50,
        )
      );

      $channelId = 'UC6YfbMblc1_2vXZKPeRQxfg';
     // $channel = new

      $uploadId = $result1['modelData']['items'][0]['contentDetails']['relatedPlaylists']['uploads'];

      $result = $youtube->playlistItems->listPlaylistItems(
        'snippet',
        array(
          'playlistId' => $uploadId,
          'maxResults' => 50,
        )
      );

      Zend_Debug::dump($result['items']);
      die('aaa');
    }
    catch (Exception $e) {

    }

    Zend_Debug::dump($accessToken);
    die('ssss');
  }
}