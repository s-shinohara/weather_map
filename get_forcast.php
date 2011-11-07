<?php
require_once('key.php');
mb_regex_encoding('UTF-8');

//XML�f�[�^�擾�p�x�[�XURL
$req = "http://api.wxbug.net/getForecastRSS.aspx?ACode=" . ACODE . "&unittype=1&outputType=1";

//XML�f�[�^�擾�p���N�G�X�gURL����
$req .= "&lat=" . $_GET['lat'] . "&long=" . $_GET['lng'];

//XML�t�@�C�����p�[�X���A�I�u�W�F�N�g���擾
$string = mb_ereg_replace(':','_',file_get_contents($req));
$xml = simplexml_load_string($string);
$forcasts = $xml->aws_forecasts;

// json�̃f�[�^��g�ݗ��Ă�
// �ʒu
$ret = '{"location": "' . $forcasts->aws_location->aws_city . '",' . "\n"
         . '"forcasts": [' . "\n";
// 2�����擾
for ($i = 0; $i < 2; $i++) {
  $icon_url = mb_ereg_replace('http_', 'http:', $forcasts->aws_forecast[$i]->aws_image);

  $ret .= '{"title": "' . $forcasts->aws_forecast[$i]->aws_title . '",'; // �j��
  $ret .= ' "sp": "' . $forcasts->aws_forecast[$i]->{'aws_short-prediction'} . '",'; // �\��i������j
  $ret .= ' "icon": "' . $icon_url . '"},' . "\n"; // �\��i�A�C�R���j
}
$ret = mb_substr($ret, 0, -2);
$ret .= ']}';
echo $ret;

?>
