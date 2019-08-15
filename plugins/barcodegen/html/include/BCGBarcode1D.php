<?php
//WEBSC商城资源
if (!defined('IN_CB')) {
	exit('You are not allowed to access to this page.');
}

$default_value['thickness'] = 30;
$thickness = intval(isset($_POST['thickness']) ? $_POST['thickness'] : $default_value['thickness']);
registerImageKey('thickness', $thickness);
echo "                    <tr>\r\n                        <td><label for=\"thickness\">Thickness</label></td>\r\n                        <td>";
echo getInputTextHtml('thickness', $thickness, array('type' => 'number', 'min' => 20, 'max' => 90, 'step' => 5, 'required' => 'required'));
echo "</td>\r\n                    </tr>";

?>
