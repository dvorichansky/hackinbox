<?php
// create a folder "stuff" and add files with the names "user.txt" and "pass.txt" and save the data
$username = file_get_contents("stuff/user.txt");
$password = file_get_contents("stuff/pass.txt");
$nonsense = "supercalifragilisticexpialidocious";

if (isset($_COOKIE['PrivatePageLogin'])) {
  if ($_COOKIE['PrivatePageLogin'] == md5($password . $nonsense)) {
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title>Админ панель виджета Hackinbox</title>

      <link rel="stylesheet" href="css/bootstrap-4.3.1.css">
      <link rel="stylesheet" href="css/pick-a-color-1.2.3.css">
      <link rel="stylesheet" href="css/hackinbox-admin-main.css">

    </head>

    <body>
      <div class="container">
        <h1 class="mt-5 mb-5 text-center">Админ панель виджета Hackinbox</h1>

        <div class="modal fade" id="mainImage" tabindex="-1" role="dialog" aria-labelledby="mainImageLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="mainImageLabel">Замена основного изображения виджета</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form enctype="multipart/form-data" action="" method="POST" class="form-image__ru mb-3" name="formImage">
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend input-group-lang">
                        <span class="input-group-text">ru</span>
                      </div>
                      <div class="custom-file">
                        <input type="hidden" name="MAX_FILE_SIZE" value="200000" />
                        <input type="hidden" class="input-lang" name="lang" value="ru" />
                        <input type="file" class="custom-file-input" id="customFile__ru" name="userfile" required>
                        <label class="custom-file-label" for="customFile__ru">Выберите файл</label>
                        <div class="invalid-feedback">Неверный формат файла</div>
                      </div>
                      <div class="text-center ml-2">
                        <button type="submit" class="btn btn-primary">Заменить</button>
                      </div>
                    </div>
                  </div>
                </form>
                <form enctype="multipart/form-data" action="" method="POST" class="form-image__uk mb-3" name="formImage">
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend input-group-lang">
                        <span class="input-group-text">uk</span>
                      </div>
                      <div class="custom-file">
                        <input type="hidden" name="MAX_FILE_SIZE" value="200000" />
                        <input type="hidden" class="input-lang" name="lang" value="uk" />
                        <input type="file" class="custom-file-input" id="customFile__uk" name="userfile" required>
                        <label class="custom-file-label" for="customFile__uk">Выберите файл</label>
                        <div class="invalid-feedback">Неверный формат файла</div>
                      </div>
                      <div class="text-center ml-2">
                        <button type="submit" class="btn btn-primary">Заменить</button>
                      </div>
                    </div>
                  </div>
                </form>
                <hr>
                <div class="text-center">
                  <small class="form-text text-muted">Формат - <span class="badge badge-primary">png</span>, размер - <span class="badge badge-primary">до 200 кб</span>, разрешение - <span class="badge badge-primary">650x500</span></small>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="modal fade" id="widgetPreview" tabindex="-1" role="dialog" aria-labelledby="widgetPreviewLabel" aria-hidden="true">
          <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="widgetPreviewLabel">Предпросмотр</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <iframe src="demo.php" width="100%" height="600px" frameborder="0"></iframe>
              </div>
            </div>
          </div>
        </div>

        <hr class="mt-5 mb-5">

        <form action="" class="form mb-5">
          <?php
              $json_object = file_get_contents('../hackinbox_data.json');
              $data = json_decode($json_object, true);
              ?>

          <h3 class="mb-4">Информация о виджете</h3>

          <div class="form-group">
            <label for="name">Имя</label>
            <input type="text" class="form-control" value="<?php echo $data['name'] ?>" name="name" id="name">
          </div>

          <div class="form-group">
            <label for="description">Описание</label>
            <input type="text" class="form-control" value="<?php echo $data['description'] ?>" name="description" id="description">
          </div>

          <div class="form-group">
            <label for="status">Статус</label>
            <select class="form-control" name="status" id="status">
              <?php
                  $status = $data['status'];

                  if ($status == "ON") {
                    echo "<option>ON</option>
                  <option>OFF</option>";
                  } else if ($status == "OFF") {
                    echo "<option>OFF</option>
                  <option>ON</option>";
                  }
                  ?>
            </select>
            <small class="form-text text-muted">ON (включен), OFF (выключен)</small>
          </div>

          <button type="submit" class="btn btn-primary mt-3">Сохранить</button>

          <hr class="mt-5 mb-5">

          <h3 class="mb-4">Текст и внешний вид виджета</h3>



          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <button type="button" class="btn btn-outline-dark w-100" data-toggle="modal" data-target="#widgetPreview">Открыть предпросмотр</button>
              </div>
              <hr>
              <div class="row">
                <div class="col-6">
                  <div class="input-group mb-2 justify-content-center">
                    <div class="input-group-prepend">
                      <span class="input-group-text" style="border-radius: 0.25rem;">ru</span>
                    </div>
                  </div>
                  <img src="../img/hackinbox_picture__ru.png" alt="">
                </div>
                <div class="col-6">
                  <div class="input-group mb-2 justify-content-center">
                    <div class="input-group-prepend">
                      <span class="input-group-text" style="border-radius: 0.25rem;">uk</span>
                    </div>
                  </div>
                  <img src="../img/hackinbox_picture__uk.png" alt="">
                </div>
              </div>
              <hr>
              <div class="form-group">
                <button type="button" class="btn btn-outline-primary w-100" data-toggle="modal" data-target="#mainImage">Заменить зображение</button>
              </div>
            </div>
            <div class="col-md-8">
              <div class="form-group">
                <label for="content__background_color">Цвет фона</label>
                <input type="text" class="form-control pick-a-color" value="<?php echo $data['content']['background_color'] ?>" name="content__background_color" id="content__background_color">
              </div>
              <div class="form-group">
                <label for="appearance__box_shadow">Тень от окна</label>
                <select class="form-control" name="appearance__box_shadow" id="appearance__box_shadow">
                  <?php
                      $box_shadow = $data['appearance']['box_shadow'];

                      if ($box_shadow == "0 21px 32px 0 rgba(0, 0, 0, 0.25)") {
                        echo "<option>strong</option>
                  <option>faint</option>
                  <option>without</option>";
                      } else if ($box_shadow == "0 10px 15px 0 rgba(0, 0, 0, 0.15)") {
                        echo "<option>faint</option>
                  <option>strong</option>
                  <option>without</option>";
                      } else {
                        echo "<option>without</option>
                  <option>faint</option>
                  <option>strong</option>";
                      }
                      ?>
                </select>
                <small class="form-text text-muted">without (без тени), faint (слабая), strong (сильная)</small>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="appearance__overlay__background_color">Цвет фона при затемнении</label>
                    <input type="text" class="form-control pick-a-color" value="<?php echo $data['appearance']['overlay']['background_color'] ?>" name="appearance__overlay__background_color" id="appearance__overlay__background_color">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="appearance__overlay__opacity">Прозрачность фона</label>
                    <input type="range" class="custom-range mt-2" min="0" max="1" step="0.1" value="<?php echo $data['appearance']['overlay']['opacity'] ?>" name="appearance__overlay__opacity" id="appearance__overlay__opacity">
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-9">
              <div class="form-group">
                <label>Текст предложения</label>
                <div class="input-group mb-2">
                  <div class="input-group-prepend input-group-lang" for="content__title__ru">
                    <span class="input-group-text">ru</span>
                  </div>
                  <input type="text" class="form-control" value="<?php echo $data['content']['title']['ru'] ?>" name="content__title__ru" id="content__title__ru">
                </div>
                <div class="input-group">
                  <div class="input-group-prepend input-group-lang" for="content__title__uk">
                    <span class="input-group-text">uk</span>
                  </div>
                  <input type="text" class="form-control" value="<?php echo $data['content']['title']['uk'] ?>" name="content__title__uk" id="content__title__uk">
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="content__title_color">Цвет текста</label>
                <input type="text" class="form-control pick-a-color" value="<?php echo $data['content']['title_color'] ?>" name="content__title_color" id="content__title_color">
              </div>
            </div>
          </div>

          <button type="submit" class="btn btn-primary mt-3">Сохранить</button>

          <hr class="mt-5 mb-5">

          <h3 class="mb-4">Таймер</h3>

          <div class="form-group">
            <label for="counter__title">Текст над таймером</label>
            <div class="input-group mb-2">
              <div class="input-group-prepend input-group-lang" for="counter__title__ru">
                <span class="input-group-text">ru</span>
              </div>
              <input type="text" class="form-control" value="<?php echo $data['counter']['title']['ru'] ?>" name="counter__title__ru" id="counter__title__ru">
            </div>
            <div class="input-group">
              <div class="input-group-prepend input-group-lang" for="counter__title__uk">
                <span class="input-group-text">uk</span>
              </div>
              <input type="text" class="form-control" value="<?php echo $data['counter']['title']['uk'] ?>" name="counter__title__uk" id="counter__title__uk">
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <label>Время до завершения акции</label>
              <div class="row">
                <div class="col form-group">
                  <input type="number" class="form-control" value="<?php echo $data['counter']['deadline']['hours'] ?>" name="counter__deadline__hours" id="counter__deadline__hours">
                  <small class="form-text text-muted mb-2">Часов</small>

                  <div class="input-group mb-2">
                    <div class="input-group-prepend input-group-lang">
                      <span class="input-group-text">ru</span>
                    </div>
                    <input type="text" class="form-control" value="<?php echo $data['counter']['deadline']['hours_text']['ru'] ?>" name="counter__deadline__hours_text__ru" id="counter__deadline__hours_text__ru">
                  </div>

                  <div class="input-group">
                    <div class="input-group-prepend input-group-lang">
                      <span class="input-group-text">uk</span>
                    </div>
                    <input type="text" class="form-control" value="<?php echo $data['counter']['deadline']['hours_text']['uk'] ?>" name="counter__deadline__hours_text__uk" id="counter__deadline__hours_text__uk">
                  </div>
                </div>
                <div class="col form-group">
                  <input type="number" class="form-control" value="<?php echo $data['counter']['deadline']['minutes'] ?>" name="counter__deadline__minutes" id="counter__deadline__minutes">
                  <small class="form-text text-muted mb-2">Минут</small>

                  <div class="input-group mb-2">
                    <div class="input-group-prepend input-group-lang">
                      <span class="input-group-text">ru</span>
                    </div>
                    <input type="text" class="form-control" value="<?php echo $data['counter']['deadline']['minutes_text']['ru'] ?>" name="counter__deadline__minutes_text__ru" id="counter__deadline__minutes_text__ru">
                  </div>

                  <div class="input-group mb-2">
                    <div class="input-group-prepend input-group-lang">
                      <span class="input-group-text">uk</span>
                    </div>
                    <input type="text" class="form-control" value="<?php echo $data['counter']['deadline']['minutes_text']['uk'] ?>" name="counter__deadline__minutes_text__uk" id="counter__deadline__minutes_text__uk">
                  </div>
                </div>
                <div class="col form-group">
                  <input type="number" class="form-control" value="<?php echo $data['counter']['deadline']['seconds'] ?>" name="counter__deadline__seconds" id="counter__deadline__seconds">
                  <small class="form-text text-muted mb-2">Секунд</small>

                  <div class="input-group mb-2">
                    <div class="input-group-prepend input-group-lang">
                      <span class="input-group-text">ru</span>
                    </div>
                    <input type="text" class="form-control" value="<?php echo $data['counter']['deadline']['seconds_text']['ru'] ?>" name="counter__deadline__seconds_text__ru" id="counter__deadline__seconds_text__ru">
                  </div>

                  <div class="input-group mb-2">
                    <div class="input-group-prepend input-group-lang">
                      <span class="input-group-text">uk</span>
                    </div>
                    <input type="text" class="form-control" value="<?php echo $data['counter']['deadline']['seconds_text']['uk'] ?>" name="counter__deadline__seconds_text__uk" id="counter__deadline__seconds_text__uk">
                  </div>
                </div>
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="form-group">
                <label for="counter__color">Цвет цифр</label>
                <input type="text" class="form-control pick-a-color" value="<?php echo $data['counter']['color'] ?>" name="counter__color" id="counter__color">
              </div>
              <div class="form-group">
                <label for="counter__background_color">Цвет фона</label>
                <input type="text" class="form-control pick-a-color" value="<?php echo $data['counter']['background_color'] ?>" name="counter__background_color" id="counter__background_color">
              </div>
            </div>
          </div>

          <button type="submit" class="btn btn-primary mt-3">Сохранить</button>

          <hr class="mt-5 mb-5">

          <h3 class="mb-4">Форма</h3>

          <div class="form-group">
            <label for="form__configuration_file">Путь к конфигурационному файлу отправки заявки на CRM</label>
            <input type="text" class="form-control" value="<?php echo $data['form']['configuration_file'] ?>" name="form__configuration_file" id="form__configuration_file">
            <small class="form-text text-muted">Формат: /file_lead.php</small>
          </div>

          <div class="form-group">
            <label for="form__name">Название формы</label>
            <div class="input-group mb-2">
              <div class="input-group-prepend input-group-lang" for="form__name__ru">
                <span class="input-group-text">ru</span>
              </div>
              <input type="text" class="form-control" value="<?php echo $data['form']['name']['ru'] ?>" name="form__name__ru" id="form__name__ru">
            </div>
            <div class="input-group">
              <div class="input-group-prepend input-group-lang" for="form__name__uk">
                <span class="input-group-text">uk</span>
              </div>
              <input type="text" class="form-control" value="<?php echo $data['form']['name']['uk'] ?>" name="form__name__uk" id="form__name__uk">
            </div>
          </div>

          <div class="row">
            <div class="form-group col-md-6">
              <label for="form__placeholder">Заглушка номера (Placeholder)</label>
              <input type="text" class="form-control" value="<?php echo $data['form']['placeholder'] ?>" name="form__placeholder" id="form__placeholder">
            </div>

            <div class="form-group col-md-6">
              <label for="form__mask">Маска номера (Mask)</label>
              <input type="text" class="form-control" value="<?php echo $data['form']['mask'] ?>" name="form__mask" id="form__mask">
            </div>
          </div>
          <div class="row">

            <div class="form-group col-md-6">
              <label for="form__button">Текст кнопки</label>
              <div class="input-group mb-2">
                <div class="input-group-prepend input-group-lang" for="form__button__ru">
                  <span class="input-group-text">ru</span>
                </div>
                <input type="text" class="form-control" value="<?php echo $data['form']['button']['ru'] ?>" name="form__button__ru" id="form__button__ru">
              </div>
              <div class="input-group">
                <div class="input-group-prepend input-group-lang" for="form__button__uk">
                  <span class="input-group-text">uk</span>
                </div>
                <input type="text" class="form-control" value="<?php echo $data['form']['button']['uk'] ?>" name="form__button__uk" id="form__button__uk">
              </div>
            </div>

            <div class="form-group col-md-6">
              <label for="form__button_color">Цвет кнопки</label>
              <input type="text" class="form-control pick-a-color" value="<?php echo $data['form']['button_color'] ?>" name="form__button_color" id="form__button_color">
            </div>
          </div>

          <div class="form-group">
            <label for="form__userphone_message_error">Текст ошибки ввода номера</label>
            <div class="input-group mb-2">
              <div class="input-group-prepend input-group-lang" for="form__userphone_message_error__ru">
                <span class="input-group-text">ru</span>
              </div>
              <input type="text" class="form-control" value="<?php echo $data['form']['userphone_message_error']['ru'] ?>" name="form__userphone_message_error__ru" id="form__userphone_message_error__ru">
            </div>
            <div class="input-group">
              <div class="input-group-prepend input-group-lang" for="form__userphone_message_error__uk">
                <span class="input-group-text">uk</span>
              </div>
              <input type="text" class="form-control" value="<?php echo $data['form']['userphone_message_error']['uk'] ?>" name="form__userphone_message_error__uk" id="form__userphone_message_error__uk">
            </div>
          </div>

          <div class="form-group">
            <label for="form__success_text">Текст после отправки заявки</label>
            <div class="input-group mb-2">
              <div class="input-group-prepend input-group-lang" for="form__success_text__ru">
                <span class="input-group-text">ru</span>
              </div>
              <input type="text" class="form-control" value="<?php echo $data['form']['success_text']['ru'] ?>" name="form__success_text__ru" id="form__success_text__ru">
            </div>
            <div class="input-group">
              <div class="input-group-prepend input-group-lang" for="form__success_text__uk">
                <span class="input-group-text">uk</span>
              </div>
              <input type="text" class="form-control" value="<?php echo $data['form']['success_text']['uk'] ?>" name="form__success_text__uk" id="form__success_text__uk">
            </div>
          </div>

          <div class="row">
            <div class="form-group col-md-6">
              <label for="form__success_button">Текст кнопки согласия после отправки заявки</label>
              <div class="input-group mb-2">
                <div class="input-group-prepend input-group-lang" for="form__success_button__ru">
                  <span class="input-group-text">ru</span>
                </div>
                <input type="text" class="form-control" value="<?php echo $data['form']['success_button']['ru'] ?>" name="form__success_button__ru" id="form__success_button__ru">
              </div>
              <div class="input-group">
                <div class="input-group-prepend input-group-lang" for="form__success_button__uk">
                  <span class="input-group-text">uk</span>
                </div>
                <input type="text" class="form-control" value="<?php echo $data['form']['success_button']['uk'] ?>" name="form__success_button__uk" id="form__success_button__uk">
              </div>
            </div>

            <div class="form-group col-md-6">
              <label for="form__success_button_color">Цвет кнопки согласия после отправки заявки</label>
              <input type="text" class="form-control pick-a-color" value="<?php echo $data['form']['success_button_color'] ?>" name="form__success_button_color" id="form__success_button_color">
            </div>
          </div>

          <button type="submit" class="btn btn-primary mt-3">Сохранить</button>

          <hr class="mt-5 mb-5">

          <h3 class="mb-4">Поведение</h3>

          <div class="form-group">
            <label for="display_delay">Показывать при входе с задержкой</label>
            <input type="number" class="form-control" value="<?php echo $data['display_delay'] ?>" name="display_delay" id="display_delay">
            <small for="counter__deadline__seconds" class="form-text text-muted">Секунд</small>
          </div>

          <div class="form-group">
            <label>Страницы исключения</label>

            <div class="row" id="exceptionInputs">
              <?php foreach ($data['exception_pages'] as $key => $value) { ?>

                <div class="input-group mb-2 col-md-6">
                  <input type="text" class="form-control" value="<?php echo $value ?>" name="exception_pages__<?php echo $key ?>" data-exception="<?php echo $key ?>">
                  <span class="input-group-append">
                    <button class="btn btn-outline-secondary delete-input" type="button">×</button>
                  </span>
                </div>

              <?php } ?>
            </div>

            <button type="button" class="btn btn-secondary" id="addExceptionInput">+</button>
          </div>

          <button type="submit" class="btn btn-primary mt-3">Сохранить</button>
        </form>

      </div>

      <script src="js/jquery-3.4.1.js"></script>
      <script src="js/pick-a-color-1.2.3.js"></script>
      <script src="js/tinycolor-1.4.1.js"></script>
      <script src="js/bootstrap-4.3.1.js"></script>
      <script src="js/hackinbox-admin-main.js"></script>

    </body>

    </html>

<?php
    exit;
  } else {
    echo "Bad Cookie.";
    exit;
  }
}

if (isset($_GET['p']) && $_GET['p'] == "login") {
  if ($_POST['user'] != $username) {
    echo "Sorry, that username does not match.";
    exit;
  } else if ($_POST['keypass'] != $password) {
    echo "Sorry, that password does not match.";
    exit;
  } else if ($_POST['user'] == $username && $_POST['keypass'] == $password) {
    setcookie('PrivatePageLogin', md5($_POST['keypass'] . $nonsense));
    header("Location: $_SERVER[PHP_SELF]");
  } else {
    echo "Sorry, you could not be logged in at this time.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Вход в админ панель виджета Hackinbox</title>

  <link rel="stylesheet" href="css/bootstrap-4.3.1.css">

</head>

<body>

  <div class="d-flex position-fixed w-100 h-100 justify-content-center align-items-center">
    <div class="w-100">
      <div class="col-md-8 m-auto">

        <h1 class="text-center">Админ панель виджета Hackinbox</h1>

        <hr class="mt-5 mb-5">

      </div>
      <div class="col-xl-2 col-lg-3 col-md-4 col-sm-8 m-auto">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>?p=login" method="post">

          <div class="form-group">
            <label for="exampleInputLogin">Логин</label>
            <input type="text" class="form-control" id="exampleInputLogin" name="user" placeholder="Введите логин">
          </div>

          <div class="form-group">
            <label for="exampleInputPassword">Пароль</label>
            <input type="password" class="form-control" id="exampleInputPassword" name="keypass" placeholder="Введите пароль">
          </div>

          <button type="submit" id="submit" value="Login" class="btn btn-primary d-block m-auto">Войти</button>

        </form>
      </div>
    </div>
  </div>

</body>

</html>