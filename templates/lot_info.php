    <nav class="nav">
      <ul class="nav__list container">
        <?php foreach($categories as $category): ?>
          <li class="nav__item">
            <a href="all_lots.php?category=<?= $category['name_ru']; ?>"><?= $category['name_ru']; ?></a>
          </li>
        <?php endforeach; ?>
      </ul>
    </nav>
    <section class="lot-item container">
      <h2><?= esc($lot_info['name']); ?></h2>
      <div class="lot-item__content">
        <div class="lot-item__left">
          <div class="lot-item__image">
            <img src="<?= esc($lot_info['URL']); ?>" width="730" height="548" alt="<?= esc($lot_info['name']); ?>">
          </div>
          <p class="lot-item__category">Категория: <span><?= esc($lot_info['category']); ?></span></p>
          <p class="lot-item__description"><?= esc($lot_info['description']); ?></p>
        </div>
        <div class="lot-item__right">
          <?php if ($allow_new_rate): ?>
            <div class="lot-item__state">
              <div class="lot-item__timer timer">
                <?= $lot_info['remaining_time']; ?>
              </div>
              <div class="lot-item__cost-state">
                <div class="lot-item__rate">
                  <span class="lot-item__amount">Текущая цена</span>
                  <span class="lot-item__cost"><?= my_number_format(esc($lot_info['current_price'])); ?></span>
                </div>
                <div class="lot-item__min-cost">
                  Мин. ставка <span><?= my_number_format(esc($lot_info['min_valid_rate'])).' р'; ?></span>
                </div>
              </div>
              <form class="lot-item__form" action="lot.php?id=<?= $lot_info['id']; ?>" method="post">
                <?php $classname = empty($error) ? '' : 'form__item--invalid'; ?>
                <p class="lot-item__form-item form__item <?= $classname; ?>">
                  <label for="cost">Ваша ставка</label>
                  <input id="cost" type="text" name="cost" placeholder="<?= my_number_format(esc($lot_info['min_valid_rate'])); ?>" value="<?= esc($value); ?>">
                  <span class="form__error"><?= $error; ?>  </span>
                </p>
                <button type="submit" class="button">Сделать ставку</button>
              </form>
            </div>
          <?php endif; ?>
          <div class="history">
            <h3>История ставок (<span><?= mysqli_num_rows($rates); ?></span>)</h3>
            <table class="history__list">
              <?php if ($rates):
                while($rate = mysqli_fetch_assoc($rates)): ?>
                  <tr class="history__item">
                    <td class="history__name"><?= esc($rate['name']); ?></td>
                    <td class="history__price"><?= my_number_format(esc($rate['rate'])).' р'; ?></td>
                    <td class="history__time"><?= time_passed(esc($rate['dt_rate'])); ?></td>
                  </tr>
                <?php endwhile;
              endif; ?>
            </table>
          </div>
        </div>
      </div>
    </section>