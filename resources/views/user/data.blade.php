<?php

header('Content-Type: application/pdf');

$html = '
<html><head>
</head>
<body>
<h1>' . $user->name . ' data </h1>
<h4>your info</h4>
<table>
  <tr>
    <th>name</th>
    <th>age</th>
    <th>weight</th>
    <th>geneder</th>
    <th>start sleep</th>
    <th>end sleep</th>
  </tr>
  <tr>
      <td>' . $user->name . '</td>
      <td>' . $user->age . '</td>
      <td>' . $user->weight . '</td>
      <td>' . $user->geneder . '</td>
      <td>' . $user->start_sleep . '</td>
      <td>' . $user->end_sleep . '</td>
  </tr>
</table> ';



// if bpm exist
if(isset($data)){
$minute = '';
$hour = '';
$day = '';
foreach($data['minute'] as $item){
  $minute .=  '<tr><td>' . $item['bpm'] . '</td>';
  $minute .=  '<td>' . $item['created_at'] . '</td></tr>';
}
foreach($data['hour'] as $item){
  $hour .=  '<tr><td>' . $item['bpm'] . '</td>';
  $hour .=  '<td>' . $item['created_at'] . '</td></tr>';
}
foreach($data['day'] as $item){
  $day .=  '<tr><td>' . $item['bpm'] . '</td>';
  $day .=  '<td>' . $item['created_at'] . '</td></tr>';
}
$html .= '
<h4>heart data</h4>
<h5>min and max of bpm in :</h5>
<table>
  <tr>
    <th>time</th>
    <th>min</th>
    <th>max</th>
  </tr>
  <tr>
    <td>minute</td>
    <td>' . $data['info']['minute']['min'] . '</td>
    <td>' . $data['info']['minute']['max'] . '</td>
  </tr>
  <tr>
    <td>hour</td>
    <td>' . $data['info']['hour']['min'] . '</td>
    <td>' . $data['info']['hour']['max'] . '</td>
  </tr>
  <tr>
    <td>day</td>
    <td>' . $data['info']['day']['min'] . '</td>
    <td>' . $data['info']['day']['max'] . '</td>
  </tr>
</table>

<h5>last bpm</h5>
<table>
  <tr>
    <th>bpm</th>
    <th>date</th>
  </tr>
  <tr>
      <td>' . $data['last']['bpm'] . '</td>
      <td>' . $data['last']['created_at']->diffForHumans() . " ({$data['last']['created_at']})" . '</td>
  </tr>
</table>

<h5>last minute</h5>
<table>
  <tr>
    <th>bpm</th>
    <th>date</th>
  </tr>';
$html .= $minute;
$html .= '
</table>

<h5>last hour</h5>
<table>
  <tr>
    <th>bpm</th>
    <th>date</th>
  </tr>';
$html .= $hour;
$html .= '
</table>

<h5>last day</h5>
<table>
  <tr>
    <th>bpm</th>
    <th>date</th>
  </tr>';
$html .= $day;
$html .= '
</table>
';
}

$html .= '
</body>
</html>
';
//==============================================================
//==============================================================
//==============================================================

$mpdf = new \Mpdf\Mpdf([
    'mode' => 'en-GB-x',
    'margin_left' => 10,
    'margin_right' => 10,
    'margin_top' => 10,
    'margin_bottom' => 10,
    'margin_header' => 6,
    'margin_footer' => 3,
]);
$mpdf->SetDisplayMode('fullpage');
$mpdf->list_indent_first_level = 0;    // 1 or 0 - whether to indent the first level of a list
// LOAD a stylesheet
$stylesheet = file_get_contents('css/mpdf.css');
$mpdf->WriteHTML($stylesheet, 1);    // The parameter 1 tells that this is css/style only and no body/html/text
$mpdf->WriteHTML($html);
$mpdf->Output(preg_replace('/\s+/', '', $user->name). "_data.pdf",'I');
exit;
//==============================================================
//==============================================================
//==============================================================
