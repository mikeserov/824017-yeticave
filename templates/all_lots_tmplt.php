    <nav class="nav">
      <ul class="nav__list container">
        <?php foreach ($categories as $category):
          $classname = $cur_category == $category['name_ru'] ? 'nav__item--current' : ''; ?>
          <li class="nav__item <?= $classname; ?>">
            <a href="all_lots.php?category=<?= $category['name_ru']; ?>"><?= $category['name_ru']; ?></a>
          </li>
        <?php endforeach; ?>
      </ul>
    </nav>
    <div class="container">
      <section class="lots">
        <h2>Все лоты в категории <span>«<?= $cur_category; ?>»</span></h2>
        <?php if ($pages_count): ?>
          <ul class="lots__list">
            <?php $i = 0;
              while (($lot = mysqli_fetch_assoc($lots)) && $i < 9): ?>
                <li class="lots__item lot">
                  <div class="lot__image">
                    <img src="<?= esc($lot['img']); ?>" width="350" height="260" alt="<?= esc($lot["name"]); ?>">
                  </div>
                  <div class="lot__info">
                    <span class="lot__category"><?= esc($lot["category"]); ?></span>
                    <h3 class="lot__title"><a class="text-link" href="lot.php?id=<?= $lot["id"]; ?>"><?= esc($lot["name"]); ?></a></h3>
                    <div class="lot__state">
                      <div class="lot__rate">
                        <span class="lot__amount">Стартовая цена</span>
                        <span class="lot__cost"><?= my_number_format(esc($lot["start_price"])); ?><b class="rub">р</b></span>
                      </div>
                      <div class="lot__timer timer">
                        <?= $lot['remaining_time']; ?>
                      </div>
                    </div>
                  </div>
                </li>
              <?php $i++;
            endwhile; ?>
          </ul>
        <?php else: ?>
          <h3>Лоты в данной категории отсутствуют</h3>
        <?php endif; ?>
      </section>
      <?php if ($pages_count > 1): ?> 
        <ul class="pagination-list">

          <?php if ($cur_page == 1):
                  $href = '';
                else:
                  $href = 'href=all_lots.php?page=' . ($cur_page - 1) . '&category=' . urlencode($cur_category);
                endif; ?>
          <li class="pagination-item pagination-item-prev"><a <?= $href; ?>>Назад</a></li>
              
          <?php  foreach ($pages as $page): ?>
            <?php if ($page == $cur_page):
                    $classname = 'pagination-item-active';
                    $href = '';
                  else:
                    $classname = '';
                    $href = 'href=all_lots.php?page=' . $page . '&category=' . urlencode($cur_category);
                  endif; ?>
            <li class="pagination-item <?= $classname; ?>"><a <?= $href; ?>><?= $page; ?></a></li>
          <?php endforeach; ?>

          <?php if ($cur_page == count($pages)):
                  $href = '';
                else:
                  $href = 'href=all_lots.php?page=' . ($cur_page + 1) . '&category=' . urlencode($cur_category);
                endif; ?>
          <li class="pagination-item pagination-item-next"><a <?= $href; ?>>Вперед</a></li>

        </ul>
      <?php endif; ?>
    </div>