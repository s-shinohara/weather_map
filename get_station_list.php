<?php
require_once('key.php');

mb_regex_encoding('UTF-8');
  //XMLデータ取得用ベースURL
$req = "http://api.wxbug.net/getStationsXML.aspx?ACode=" . ACODE;

//XMLデータ取得用リクエストURL生成
$req .= "&lat=" . $_GET['lat'] . "&long=" . $_GET['lng'];

//XMLファイルをパースし、オブジェクトを取得
$string = mb_ereg_replace(':','_',file_get_contents($req));
$xml = simplexml_load_string($string);

//jsonのデータを組み立て
$ret = '{"stations": [' . "\n";
//取得した観測地点ごと
foreach ($xml->aws_stations->aws_station as $station) {
//緯度、経度、観測地点名
  $ret .= '{"lat": ' . $station['latitude']
          . ', "lng": ' . $station['longitude']
          . ', "name": "' . $station['name'] . '"'
          . '},' . "\n";
}
$ret = mb_substr($ret, 0, -2);
$ret .= ']}';
echo $ret;

?>
