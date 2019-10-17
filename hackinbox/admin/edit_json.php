<?php
$json_object = file_get_contents('../hackinbox_data.json');
$data = json_decode($json_object, true);

$data['exception_pages'] = array();

foreach ($_POST as $key => $value) {

  if (!is_string($value)) {
    continue;
  }

  $str = strip_tags($value);

  switch ($key) {

    case 'name':
      $data['name'] = $str;
      break;

    case 'description':
      $data['description'] = $str;
      break;

    case 'status':
      $data['status'] = $str;
      break;

    case 'hackinbox_content__title':
      $data['hackinbox_content']['title'] = $str;
      break;

    case 'hackinbox_content__title_color':
      $data['hackinbox_content']['title_color'] = $str;
      break;

    case 'hackinbox_content__background_color':
      $data['hackinbox_content']['background_color'] = $str;
      break;

    case 'hackinbox_appearance__box_shadow':
      if ($str == "strong") {
        $data['hackinbox_appearance']['box_shadow'] = "0 21px 32px 0 rgba(0, 0, 0, 0.25)";
      } else if ($str == "faint") {
        $data['hackinbox_appearance']['box_shadow'] = "0 10px 15px 0 rgba(0, 0, 0, 0.15)";
      } else if ($str == "without") {
        $data['hackinbox_appearance']['box_shadow'] = "";
      }
      break;

    case 'hackinbox_appearance__overlay__background_color':
      $data['hackinbox_appearance']['overlay']['background_color'] = $str;
      break;

    case 'hackinbox_appearance__overlay__opacity':
      $data['hackinbox_appearance']['overlay']['opacity'] = $str;
      break;

    case 'hackinbox_counter__title':
      $data['hackinbox_counter']['title'] = $str;
      break;
    case 'hackinbox_counter__deadline__hours':
      $data['hackinbox_counter']['deadline']['hours'] = $str;
      break;
    case 'hackinbox_counter__deadline__minutes':
      $data['hackinbox_counter']['deadline']['minutes'] = $str;
      break;
    case 'hackinbox_counter__deadline__seconds':
      $data['hackinbox_counter']['deadline']['seconds'] = $str;
      break;
    case 'hackinbox_counter__color':
      $data['hackinbox_counter']['color'] = $str;
      break;
    case 'hackinbox_counter__background_color':
      $data['hackinbox_counter']['background_color'] = $str;
      break;

    case 'hackinbox_form__name':
      $data['hackinbox_form']['name'] = $str;
      break;
    case 'hackinbox_form__placeholder':
      $data['hackinbox_form']['placeholder'] = $str;
      break;
    case 'hackinbox_form__mask':
      $data['hackinbox_form']['mask'] = $str;
      break;
    case 'hackinbox_form__button':
      $data['hackinbox_form']['button'] = $str;
      break;
    case 'hackinbox_form__button_color':
      $data['hackinbox_form']['button_color'] = $str;
      break;
    case 'hackinbox_form__userphone_message_error':
      $data['hackinbox_form']['userphone_message_error'] = $str;
      break;
    case 'hackinbox_form__success_text':
      $data['hackinbox_form']['success_text'] = $str;
      break;
    case 'hackinbox_form__success_button':
      $data['hackinbox_form']['success_button'] = $str;
      break;
    case 'hackinbox_form__success_button_color':
      $data['hackinbox_form']['success_button_color'] = $str;
      break;

    case 'display_delay':
      $data['display_delay'] = $str;
      break;

      // should be the last
    case $key:
      array_push($data['exception_pages'], $str);
      break;

    default:
      break;
  }
}

$json_object = json_encode($data);
file_put_contents('../hackinbox_data.json', $json_object);
