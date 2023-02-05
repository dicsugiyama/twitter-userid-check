<?php
#*******************************************#
# Twitter IDチェックツール                   #
# 使用方法：                                 #
# $ php twitter-id-check.php [ツイッターID]  #
#*******************************************#
require_once(__DIR__ . '/config.php');
require_once(__DIR__ . '/classes/HttpClient.php');
require_once(__DIR__ . '/classes/Twitter.php');
require_once(__DIR__ . '/classes/Slack.php');

$twitter_id = $argv[1];
$twitter = new Twitter();
$slack = new Slack();
if($twitter->ExistsUsername($twitter_id))
{
    $slack->Notify('Twitter ID(' . $twitter_id . ')を取得することができません。', false);
}
else
{
    $slack->Notify('Twitter ID(' .  $twitter_id . ')を取得することができます。', true);
}