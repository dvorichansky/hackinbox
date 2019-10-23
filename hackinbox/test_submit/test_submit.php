<?php
$json_object = file_get_contents('test_submit.json');
$data = json_decode($json_object, true);

$cont = $data['cont'];

foreach ($_POST as $key => $value) {

  if (!is_string($value)) {
    continue;
  }

  $str = strip_tags($value);

  switch ($key) {

    case 'phone':
      array_push($data['arr_number'], $str);
      $data['cont'] = $cont+1;
      break;   

    default:
      break;
  }
}

$json_object = json_encode($data);
file_put_contents('test_submit.json', $json_object);