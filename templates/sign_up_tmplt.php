    <nav class="nav">
      <ul class="nav__list container">
        <?php foreach ($categories as $category): ?>
          <li class="nav__item">
            <a href="all_lots.php?category=<?= $category['name_ru']; ?>"><?= $category['name_ru']; ?></a>
          </li>
        <?php endforeach; ?>
      </ul>
    </nav>
    <?php $classname = isset($errors) ? 'form--invalid' : ''; ?>
    <form class="form container <?= $classname; ?>" action="sign_up.php" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
      <h2>Регистрация нового аккаунта</h2>
      <?php $classname = isset($errors['email']) ? 'form__item--invalid' : ''; ?>
      <div class="form__item <?= $classname; ?>"> <!-- form__item--invalid -->
        <label for="email">E-mail*</label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?= $values['email'] ?? ''; ?>" <?= $required; ?>>
        <span class="form__error"><?= $classname ? $errors['email'] : ''; ?></span>
      </div>
      <?php $classname = isset($errors['password']) ? 'form__item--invalid' : ''; ?>
      <div class="form__item <?= $classname; ?>">
        <label for="password">Пароль*</label>
        <input id="password" type="password" name="password" placeholder="Введите пароль" <?= $required; ?>>
        <span class="form__error"><?= $classname ? 'Введите пароль' : ''; ?></span>
      </div>
      <?php $classname = isset($errors['name']) ? 'form__item--invalid' : ''; ?>
      <div class="form__item <?= $classname; ?>">
        <label for="name">Имя*</label>
        <input id="name" type="text" name="name" placeholder="Введите имя" <?= $required; ?> value="<?= $values['name'] ?? ''; ?>">
        <span class="form__error"><?= $classname ? 'Введите имя' : ''; ?></span>
      </div>
      <?php $classname = isset($errors['message']) ? 'form__item--invalid' : ''; ?>
      <div class="form__item <?= $classname; ?>">
        <label for="message">Контактные данные*</label>
        <textarea id="message" name="message" placeholder="Напишите как с вами связаться" <?= $required; ?>><?= $values['message'] ?? ''; ?></textarea>
        <span class="form__error"><?= $classname ? 'Напишите как с вами связаться' : ''; ?></span>
      </div>
      <div class="form__item form__item--file form__item--last">
        <label>Аватар</label>
        <div class="preview">
          <button class="preview__remove" type="button">x</button>
          <div class="preview__img">
            <img src="img/avatar.jpg" width="113" height="113" alt="Ваш аватар">
          </div>
        </div>
        <div class="form__input-file">
          <input class="visually-hidden" type="file" id="photo2" name="photo2" value="">
          <label for="photo2">
            <span>+ Добавить</span>
          </label>
          <?php if (isset($errors['photo2'])): ?>  
            <span style="width: 200px; font-size: 11px; color: #f84646; position: absolute; top: 105px;">
              <?= $errors['photo2']; ?>
            </span>
          <?php endif; ?>
        </div>
      </div>
      <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
      <button type="submit" class="button">Зарегистрироваться</button>
      <a class="text-link" href="sign_in.php">Уже есть аккаунт</a>
    </form>