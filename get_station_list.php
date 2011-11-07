<?php
require_once('key.php');

mb_regex_encoding('UTF-8');
  //XML�f�[�^�擾�p�x�[�XURL
$req = "http://api.wxbug.net/getStationsXML.aspx?ACode=" . ACODE;

//XML�f�[�^�擾�p���N�G�X�gURL����
$req .= "&lat=" . $_GET['lat'] . "&long=" . $_GET['lng'];

//XML�t�@�C�����p�[�X���A�I�u�W�F�N�g���擾
$string = mb_ereg_replace(':','_',file_get_contents($req));
$xml = simplexml_load_string($string);

//json�̃f�[�^��g�ݗ���
$ret = '{"stations": [' . "\n";
//�擾�����ϑ��n�_����
foreach ($xml->aws_stations->aws_station as $station) {
//�ܓx�A�o�x�A�ϑ��n�_��
  $ret .= '{"lat": ' . $station['latitude']
          . ', "lng": ' . $station['longitude']
          . ', "name": "' . $station['name'] . '"'
          . '},' . "\n";
}
$ret = mb_substr($ret, 0, -2);
$ret .= ']}';
echo $ret;

?>
