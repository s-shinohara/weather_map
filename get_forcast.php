<?php
require_once('key.php');
mb_regex_encoding('UTF-8');

//XMLデータ取得用ベースURL
$req = "http://api.wxbug.net/getForecastRSS.aspx?ACode=" . ACODE . "&unittype=1&outputType=1";

//XMLデータ取得用リクエストURL生成
$req .= "&lat=" . $_GET['lat'] . "&long=" . $_GET['lng'];

//XMLファイルをパースし、オブジェクトを取得
$string = mb_ereg_replace(':','_',file_get_contents($req));
$xml = simplexml_load_string($string);
$forcasts = $xml->aws_forecasts;

// jsonのデータを組み立てる
// 位置
$ret = '{"location": "' . $forcasts->aws_location->aws_city . '",' . "\n"
         . '"forcasts": [' . "\n";
// 2日分取得
for ($i = 0; $i < 2; $i++) {
  $icon_url = mb_ereg_replace('http_', 'http:', $forcasts->aws_forecast[$i]->aws_image);

  $ret .= '{"title": "' . $forcasts->aws_forecast[$i]->aws_title . '",'; // 曜日
  $ret .= ' "sp": "' . $forcasts->aws_forecast[$i]->{'aws_short-prediction'} . '",'; // 予報（文字列）
  $ret .= ' "icon": "' . $icon_url . '"},' . "\n"; // 予報（アイコン）
}
$ret = mb_substr($ret, 0, -2);
$ret .= ']}';
echo $ret;

?>
