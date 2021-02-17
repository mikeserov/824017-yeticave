    <nav class="nav">
      <ul class="nav__list container">
        <?php foreach($categories as $category): ?>
          <li class="nav__item">
            <a href="all_lots.php?category=<?= $category['name_ru']; ?>"><?= $category['name_ru']; ?></a>
          </li>
        <?php endforeach; ?>
      </ul>
    </nav>
    <?php $classname = isset($errors) ? 'form--invalid' : ''; ?>
    <form class="form container <?= $classname; ?>" action="sign_in.php" method="post"> <!-- form--invalid -->
      <h2>Вход</h2>
      <?php $classname = isset($errors['email']) ? 'form__item--invalid' : ''; ?>
      <div class="form__item <?= $classname; ?>"> <!-- form__item--invalid -->
        <label for="email">E-mail*</label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?= $values['email'] ?? ''; ?>" <?= $required; ?>>
        <span class="form__error"><?= $classname ? $errors['email'] : ''; ?></span>
      </div>
      <?php $classname = isset($errors['password']) ? 'form__item--invalid' : ''; ?>
      <div class="form__item form__item--last <?= $classname; ?>">
        <label for="password">Пароль*</label>
        <input id="password" type="password" name="password" placeholder="Введите пароль" <?= $required; ?>>
        <span class="form__error"><?= $classname ? $errors['password'] : ''; ?></span>
      </div>
      <button type="submit" class="button">Войти</button>
    </form>