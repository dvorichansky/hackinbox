<?php ini_set('default_charset', 'UTF-8'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>DEMO</title>

  <link rel="stylesheet" href="css/bootstrap-4.3.1.css" />
</head>

<body>

  <?php
  $json_object = file_get_contents('../hackinbox_data.json');
  $data = json_decode($json_object, true);
  ?>

  <div class="d-flex position-fixed w-100 h-100 justify-content-center align-items-center flex-column text-primary">
    <div class="spinner-border" role="status">
      <span class="sr-only">Loading...</span>
    </div>
    <div class="mt-2"><?php echo $data['display_delay'] ?> сек</div>
  </div>

  <script type="text/javascript" src="js/jquery-3.4.1.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      setTimeout(function() {
        var h = document.getElementsByTagName("link")[0];
        var css = document.createElement("link");
        css.rel = "stylesheet";
        css.href = "/hackinbox/css/hackinbox.css";
        h.parentNode.insertBefore(css, h);
        var h = document.getElementsByTagName("head")[0];
        var js = document.createElement("script");
        js.defer = true;
        js.async = true;
        js.setAttribute("nomaps", "");
        js.setAttribute("charset", "UTF-8");
        js.src = "/hackinbox/js/hackinbox.js";
        h.appendChild(js);
      }, 10);
    });
  </script>
</body>

</html>