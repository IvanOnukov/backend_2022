<!DOCTYPE html>

<style>
/* Сообщения об ошибках и поля с ошибками выводим с красным бордюром. */
.error {
  border: 2px solid red;
}
    </style>
  </head>
  <body>

<?php
if (!empty($messages)) {
  print('<div id="messages">');
  // Выводим все сообщения.
  foreach ($messages as $message) {
    print($message);
  }
  print('</div>');
}

// Далее выводим форму отмечая элементы с ошибками классом error
// и задавая начальные значения элементов ранее сохраненными.
?>

<head>
  <meta charset="utf-8">
  <title>Задание 6</title>
</head>

<body>

  <div id="main-aside-wrapper">
    <div id="cont" class="container">
      <div id="form" class="col-12 order-lg-3 order-sm-2">
      <div id="vhod">
          <?php 
          if (empty($_SESSION['login'])){
          ?>
          <a href="login.php" >Войти</a>
          
          <?php 
          }else { ?><a href="login.php" >Выйти</a><?php } ?>
          
        </div>
        <form action="" method="POST">
          ФИО:
          <label>
            <input name="name"  <?php if ($errors['name']) {print 'class="error"';} ?> value="<?php print $values['name']; ?>" placeholder="Введите ФИО">
          </label>
          <br>
          <br>
          E-mail:
          <label>
            <input type="email" name="email" placeholder="Введите e-mail" <?php if ($errors['email']) {print 'class="error"';} ?> value="<?php print $values['email']; ?>">
          </label>
          <p>Дата рождения:</p>
          <p>3. Дата рождения: <input name="birth_date" type="date" value="<?php print $values['birth_date']; ?>"></p>
          <p>Пол:</p>
          <label>
            <input type="radio" name="gender" value="M" <?php if($values['gender'] == 'M') {print 'checked';}?> <?php if ($errors['gender']) {print 'class="error"';} ?> />М
          </label>
          <label>
            <input type="radio" name="gender" value="W" <?php if($values['gender'] == 'W') {print 'checked';}?> <?php if ($errors['gender']) {print 'class="error"';} ?> />Ж
          </label>
          <p>Количество конечностей</p>
          <label>
            <input type="radio" name="number_of_limbs" value="0" <?php if($values['number_of_limbs'] == 0) {print 'checked';}?> <?php if ($errors['number_of_limbs']) {print 'class="error"';} ?> />0
          </label>
          <label>
            <input type="radio" name="number_of_limbs" value="1" <?php if($values['number_of_limbs'] == 1) {print 'checked';}?> <?php if ($errors['number_of_limbs']) {print 'class="error"';} ?>/>1
          </label>
          <label>
            <input type="radio" name="number_of_limbs" value="2" <?php if($values['number_of_limbs'] == 2) {print 'checked';}?> <?php if ($errors['number_of_limbs']) {print 'class="error"';} ?>/>2
          </label>
          <label>
            <input type="radio" name="number_of_limbs" value="3" <?php if($values['number_of_limbs'] == 3) {print 'checked';}?> <?php if ($errors['number_of_limbs']) {print 'class="error"';} ?>/>3
          </label>
          <label>
            <input type="radio" name="number_of_limbs" value="4" <?php if($values['number_of_limbs'] == 4) {print 'checked';}?> <?php if ($errors['number_of_limbs']) {print 'class="error"';} ?> />4
          </label>
          <label>
            <input type="radio" name="number_of_limbs" value="5" <?php if($values['number_of_limbs'] == 5) {print 'checked';}?> <?php if ($errors['number_of_limbs']) {print 'class="error"';} ?> />5
          </label>

          <p>Сверхспособности</p>
          <label>
            <select name="ability[]" multiple=multiple>
              <option value="1" <?php if ($errors['ability']) {print 'class="error"';} ?>
            <?php
              $arr = str_split($values['ability']);
              foreach($arr as $el)
                if ($el == 1)
                  print 'selected';
            ?>
              >Бессмертие</option>
              <option value="2" <?php if ($errors['ability']) {print 'class="error"';} ?>
              <?php
              $arr = str_split($values['ability']);
              foreach($arr as $el)
                if ($el == 2)
                  print 'selected';
            ?>
              > Прохождение сквозь стены</option>
              <option value="3" <?php if ($errors['ability']) {print 'class="error"';} ?>
              <?php
              $arr = str_split($values['ability']);
              foreach($arr as $el)
                if ($el == 3)
                  print 'selected';
            ?>
              >Левитация</option>
              <option value="4" <?php if ($errors['ability']) {print 'class="error"';} ?>
              <?php
              $arr = str_split($values['ability']);
              foreach($arr as $el)
                if ($el == 4)
                  print 'selected';
            ?>
              >Web</option>
            </select>
          </label>

          <p id="bio">Биография</p>
          <label>
            <textarea placeholder="Расскажите о себе" name="biography" rows="6" cols="60"></textarea>
          </label>
          <br>

          <label>
            С контрактом ознакомлен(-a)
            <input type="checkbox" name="ok" >
          </label>
          <br>
          <input type="submit" value="Отправить">
        </form>
      </div>
    </div>
  </div>
</body>

</html>
