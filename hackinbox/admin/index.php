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
                <form enctype="multipart/form-data" action="" method="POST" class="form-image mb-3" name="formImage">
                  <div class="form-group">
                    <div class="custom-file">
                      <input type="hidden" name="MAX_FILE_SIZE" value="200000" />
                      <input type="file" class="custom-file-input" id="customFile" name="userfile" required>
                      <label class="custom-file-label" for="customFile">Выберите файл</label>
                      <small class="form-text text-muted">Формат - <span class="badge badge-primary">png</span>, размер - <span class="badge badge-primary">до 200 кб</span>, разрешение - <span class="badge badge-primary">650x500</span></small>
                      <div class="invalid-feedback">Неверный формат файла</div>
                    </div>
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn btn-primary">Заменить</button>
                  </div>
                </form>
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

          <div class="form-group">
            <button type="button" class="btn btn-outline-dark" data-toggle="modal" data-target="#widgetPreview">Открыть предпросмотр</button>
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <img src="../img/hackinbox_picture.png" alt="">
              </div>
              <div class="form-group">
                <button type="button" class="btn btn-outline-primary w-100" data-toggle="modal" data-target="#mainImage">Заменить зображение</button>
              </div>
            </div>
            <div class="col-md-8">
              <div class="form-group">
                <label for="hackinbox_content__background_color">Цвет фона</label>
                <input type="text" class="form-control pick-a-color" value="<?php echo $data['hackinbox_content']['background_color'] ?>" name="hackinbox_content__background_color" id="hackinbox_content__background_color">
              </div>
              <div class="form-group">
                <label for="hackinbox_appearance__box_shadow">Тень от окна</label>
                <select class="form-control" name="hackinbox_appearance__box_shadow" id="hackinbox_appearance__box_shadow">
                  <?php
                      $box_shadow = $data['hackinbox_appearance']['box_shadow'];

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
                    <label for="hackinbox_appearance__overlay__background_color">Цвет фона при затемнении</label>
                    <input type="text" class="form-control pick-a-color" value="<?php echo $data['hackinbox_appearance']['overlay']['background_color'] ?>" name="hackinbox_appearance__overlay__background_color" id="hackinbox_appearance__overlay__background_color">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="hackinbox_appearance__overlay__opacity">Прозрачность фона</label>
                    <input type="range" class="custom-range mt-2" min="0" max="1" step="0.1" value="<?php echo $data['hackinbox_appearance']['overlay']['opacity'] ?>" name="hackinbox_appearance__overlay__opacity" id="hackinbox_appearance__overlay__opacity">
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-9">
              <div class="form-group">
                <label for="hackinbox_content__title">Текст предложения</label>
                <input type="text" class="form-control" value="<?php echo $data['hackinbox_content']['title'] ?>" name="hackinbox_content__title" id="hackinbox_content__title">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="hackinbox_content__title_color">Цвет текста</label>
                <input type="text" class="form-control pick-a-color" value="<?php echo $data['hackinbox_content']['title_color'] ?>" name="hackinbox_content__title_color" id="hackinbox_content__title_color">
              </div>
            </div>
          </div>

          <button type="submit" class="btn btn-primary mt-3">Сохранить</button>

          <hr class="mt-5 mb-5">

          <h3 class="mb-4">Таймер</h3>

          <div class="form-group">
            <label for="hackinbox_counter__title">Текст над таймером</label>
            <input type="text" class="form-control" value="<?php echo $data['hackinbox_counter']['title'] ?>" name="hackinbox_counter__title" id="hackinbox_counter__title">
          </div>

          <div class="row">
            <div class="col-md-6">
              <label>Время до завершения акции</label>
              <div class="row">
                <div class="col form-group">
                  <input type="number" class="form-control" value="<?php echo $data['hackinbox_counter']['deadline']['hours'] ?>" name="hackinbox_counter__deadline__hours" id="hackinbox_counter__deadline__hours">
                  <small class="form-text text-muted">Часов</small>
                </div>
                <div class="col form-group">
                  <input type="number" class="form-control" value="<?php echo $data['hackinbox_counter']['deadline']['minutes'] ?>" name="hackinbox_counter__deadline__minutes" id="hackinbox_counter__deadline__minutes">
                  <small class="form-text text-muted">Минут</small>
                </div>
                <div class="col form-group">
                  <input type="number" class="form-control" value="<?php echo $data['hackinbox_counter']['deadline']['seconds'] ?>" name="hackinbox_counter__deadline__seconds" id="hackinbox_counter__deadline__seconds">
                  <small class="form-text text-muted">Секунд</small>
                </div>
              </div>

            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="hackinbox_counter__color">Цвет цифр</label>
                <input type="text" class="form-control pick-a-color" value="<?php echo $data['hackinbox_counter']['color'] ?>" name="hackinbox_counter__color" id="hackinbox_counter__color">
              </div>
              <div class="form-group">
                <label for="hackinbox_counter__background_color">Цвет фона</label>
                <input type="text" class="form-control pick-a-color" value="<?php echo $data['hackinbox_counter']['background_color'] ?>" name="hackinbox_counter__background_color" id="hackinbox_counter__background_color">
              </div>
            </div>
          </div>

          <button type="submit" class="btn btn-primary mt-3">Сохранить</button>

          <hr class="mt-5 mb-5">

          <h3 class="mb-4">Форма</h3>

          <div class="form-group">
            <label for="hackinbox_form__name">Название формы</label>
            <input type="text" class="form-control" value="<?php echo $data['hackinbox_form']['name'] ?>" name="hackinbox_form__name" id="hackinbox_form__name">
          </div>

          <div class="row">
            <div class="form-group col-md-6">
              <label for="hackinbox_form__placeholder">Заглушка номера (Placeholder)</label>
              <input type="text" class="form-control" value="<?php echo $data['hackinbox_form']['placeholder'] ?>" name="hackinbox_form__placeholder" id="hackinbox_form__placeholder">
            </div>

            <div class="form-group col-md-6">
              <label for="hackinbox_form__mask">Маска номера (Mask)</label>
              <input type="text" class="form-control" value="<?php echo $data['hackinbox_form']['mask'] ?>" name="hackinbox_form__mask" id="hackinbox_form__mask">
            </div>
          </div>
          <div class="row">
            <div class="form-group col-md-6">
              <label for="hackinbox_form__button">Текст кнопки</label>
              <input type="text" class="form-control" value="<?php echo $data['hackinbox_form']['button'] ?>" name="hackinbox_form__button" id="hackinbox_form__button">
            </div>

            <div class="form-group col-md-6">
              <label for="hackinbox_form__button_color">Цвет кнопки</label>
              <input type="text" class="form-control pick-a-color" value="<?php echo $data['hackinbox_form']['button_color'] ?>" name="hackinbox_form__button_color" id="hackinbox_form__button_color">
            </div>
          </div>

          <div class="form-group">
            <label for="hackinbox_form__userphone_message_error">Текст ошибки ввода номера</label>
            <input type="text" class="form-control" value="<?php echo $data['hackinbox_form']['userphone_message_error'] ?>" name="hackinbox_form__userphone_message_error" id="hackinbox_form__userphone_message_error">
          </div>

          <div class="form-group">
            <label for="hackinbox_form__success_text">Текст после отправки заявки</label>
            <input type="text" class="form-control" value="<?php echo $data['hackinbox_form']['success_text'] ?>" name="hackinbox_form__success_text" id="hackinbox_form__success_text">
          </div>

          <div class="row">
            <div class="form-group col-md-6">
              <label for="hackinbox_form__success_button">Текст кнопки согласия после отправки заявки</label>
              <input type="text" class="form-control" value="<?php echo $data['hackinbox_form']['success_button'] ?>" name="hackinbox_form__success_button" id="hackinbox_form__success_button">
            </div>

            <div class="form-group col-md-6">
              <label for="hackinbox_form__success_button_color">Цвет кнопки согласия после отправки заявки</label>
              <input type="text" class="form-control pick-a-color" value="<?php echo $data['hackinbox_form']['success_button_color'] ?>" name="hackinbox_form__success_button_color" id="hackinbox_form__success_button_color">
            </div>
          </div>

          <button type="submit" class="btn btn-primary mt-3">Сохранить</button>

          <hr class="mt-5 mb-5">

          <h3 class="mb-4">Поведение</h3>

          <div class="form-group">
            <label for="display_delay">Показывать при входе с задержкой</label>
            <input type="number" class="form-control" value="<?php echo $data['display_delay'] ?>" name="display_delay" id="display_delay">
            <small for="hackinbox_counter__deadline__seconds" class="form-text text-muted">Секунд</small>
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