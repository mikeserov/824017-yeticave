    <nav class="nav">
      <ul class="nav__list container">
        <?php foreach($categories as $category): ?>
          <li class="nav__item">
            <a href="all_lots.php?category=<?= $category['name_ru']; ?>"><?= $category['name_ru']; ?></a>
          </li>
        <?php endforeach; ?>
      </ul>
    </nav>
    <section class="rates container">
      <h2>Мои ставки</h2>
      <table class="rates__list">

        <?php foreach ($rates as $rate): ?>
          
          <?php $is_time_finished = $rate['remaining_time'][0] === '-' ? true : false;
                if ($is_time_finished):
                  if ($rate['winner'] == $rate['user_id']):
                    $classname = 'rates__item--win';
                  else:
                    $classname = 'rates__item--end';
                  endif;
                else:
                  $classname = '';
                endif; ?>
          <tr class="rates__item <?= $classname; ?>">

            <td class="rates__info">
              <div class="rates__img">
                <img src="<?= $rate['img']; ?>" width="54" height="40" alt="<?= $rate['lot_name']; ?>">
              </div>
              <h3 class="rates__title"><a href="lot.php?id=<?= $rate['lot_id']; ?>"><?= $rate['lot_name']; ?></a></h3>
              <?php if ($classname == 'rates__item--win'): ?>
                <p><?= $rate['contacts']; ?></p>
              <?php endif; ?>
            </td>

            <td class="rates__category">
              <?= $rate['category']; ?>
            </td>
            
            <td class="rates__timer">
              <?php  
                    if ($is_time_finished):
                      if ($rate['winner'] == $rate['user_id']):
                        $classname = 'timer--win';
                        $timer_message = 'Ставка выиграла';
                      else:
                        $classname = 'timer--end';
                        $timer_message = 'Торги окончены';
                      endif;
                    else:
                      $isless_than_hour = explode(':', $rate['remaining_time'])[0] === '00' ? true : false;
                      $timer_message = $rate['remaining_time']; 
                      if ($isless_than_hour):
                        $classname = 'timer--finishing';
                      else:
                        $classname = '';
                      endif;
                    endif;
              ?>
              <div class="timer <?= $classname; ?>"><?= $timer_message; ?></div> 
            </td>

            <td class="rates__price">
              <?= $rate['rate']; ?>
            </td>

            <td class="rates__time">
              <?= time_passed($rate['dt_rate']); ?>
            </td> 

          </tr>

        <?php endforeach; ?>

      </table>
    </section>