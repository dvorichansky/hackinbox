<?php
$json_object = file_get_contents('../hackinbox_data.json');
$data = json_decode($json_object, true);

$data['exception_pages'] = array();

// reset to overwrite
$data['display_time']['day_week'] = array("off", "off", "off", "off", "off", "off", "off");
$data['display_out_page_focus'] = "off";

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

    case 'display_time__day_week__0':
      $data['display_time']['day_week']['0'] = "on";
      break;
    case 'display_time__day_week__1':
      $data['display_time']['day_week']['1'] = "on";
      break;
    case 'display_time__day_week__2':
      $data['display_time']['day_week']['2'] = "on";
      break;
    case 'display_time__day_week__3':
      $data['display_time']['day_week']['3'] = "on";
      break;
    case 'display_time__day_week__4':
      $data['display_time']['day_week']['4'] = "on";
      break;
    case 'display_time__day_week__5':
      $data['display_time']['day_week']['5'] = "on";
      break;
    case 'display_time__day_week__6':
      $data['display_time']['day_week']['6'] = "on";
      break;

    case 'display_time__clock__with':
      $data['display_time']['clock']['with'] = $str;
      break;
    case 'display_time__clock__on':
      $data['display_time']['clock']['on'] = $str;
      break;

    case 'content__title__ru':
      $data['content']['title']['ru'] = $str;
      break;
    case 'content__title__uk':
      $data['content']['title']['uk'] = $str;
      break;

    case 'content__title_color':
      $data['content']['title_color'] = $str;
      break;

    case 'content__background_color':
      $data['content']['background_color'] = $str;
      break;

    case 'appearance__box_shadow':
      if ($str == "strong") {
        $data['appearance']['box_shadow'] = "0 21px 32px 0 rgba(0, 0, 0, 0.25)";
      } else if ($str == "faint") {
        $data['appearance']['box_shadow'] = "0 10px 15px 0 rgba(0, 0, 0, 0.15)";
      } else if ($str == "without") {
        $data['appearance']['box_shadow'] = "";
      }
      break;

    case 'appearance__overlay__background_color':
      $data['appearance']['overlay']['background_color'] = $str;
      break;

    case 'appearance__overlay__opacity':
      $data['appearance']['overlay']['opacity'] = $str;
      break;

    case 'counter__title__ru':
      $data['counter']['title']['ru'] = $str;
      break;
    case 'counter__title__uk':
      $data['counter']['title']['uk'] = $str;
      break;

    case 'counter__deadline__hours':
      $data['counter']['deadline']['hours'] = $str;
      break;
    case 'counter__deadline__minutes':
      $data['counter']['deadline']['minutes'] = $str;
      break;
    case 'counter__deadline__seconds':
      $data['counter']['deadline']['seconds'] = $str;
      break;

    case 'counter__deadline__hours_text__ru':
      $data['counter']['deadline']['hours_text']['ru'] = $str;
      break;
    case 'counter__deadline__hours_text__uk':
      $data['counter']['deadline']['hours_text']['uk'] = $str;
      break;

    case 'counter__deadline__minutes_text__ru':
      $data['counter']['deadline']['minutes_text']['ru'] = $str;
      break;
    case 'counter__deadline__minutes_text__uk':
      $data['counter']['deadline']['minutes_text']['uk'] = $str;
      break;

    case 'counter__deadline__seconds_text__ru':
      $data['counter']['deadline']['seconds_text']['ru'] = $str;
      break;
    case 'counter__deadline__seconds_text__uk':
      $data['counter']['deadline']['seconds_text']['uk'] = $str;
      break;

    case 'counter__color':
      $data['counter']['color'] = $str;
      break;
    case 'counter__background_color':
      $data['counter']['background_color'] = $str;
      break;

    case 'form__configuration_file':
      $data['form']['configuration_file'] = $str;
      break;

    case 'form__name__ru':
      $data['form']['name']['ru'] = $str;
      break;
    case 'form__name__uk':
      $data['form']['name']['uk'] = $str;
      break;

    case 'form__placeholder':
      $data['form']['placeholder'] = $str;
      break;
    case 'form__mask':
      $data['form']['mask'] = $str;
      break;

    case 'form__button__ru':
      $data['form']['button']['ru'] = $str;
      break;
    case 'form__button__uk':
      $data['form']['button']['uk'] = $str;
      break;

    case 'form__button_color':
      $data['form']['button_color'] = $str;
      break;

    case 'form__userphone_message_error__ru':
      $data['form']['userphone_message_error']['ru'] = $str;
      break;
    case 'form__userphone_message_error__uk':
      $data['form']['userphone_message_error']['uk'] = $str;
      break;

    case 'form__success_text__ru':
      $data['form']['success_text']['ru'] = $str;
      break;
    case 'form__success_text__uk':
      $data['form']['success_text']['uk'] = $str;
      break;

    case 'form__success_button__ru':
      $data['form']['success_button']['ru'] = $str;
      break;
    case 'form__success_button__uk':
      $data['form']['success_button']['uk'] = $str;
      break;

    case 'form__success_button_color':
      $data['form']['success_button_color'] = $str;
      break;

    case 'display_delay':
      $data['display_delay'] = $str;
      break;
    case 'display_out_page_focus':
      $data['display_out_page_focus'] = 'on';
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
