    <h1>Поздравляем с победой</h1>
    <p>Здравствуйте, <?= esc($winner['user_name']); ?></p>
    <p>Ваша ставка для лота <a href="http://824017-yeticave/lot.php?id=<?= $winner['lot_id']; ?>"><?= esc($winner['lot_name']); ?></a> победила.</p>
    <p>Перейдите по ссылке <a href="http://824017-yeticave/my_rates.php">мои ставки</a>,
    чтобы связаться с автором объявления</p>

    <small>Интернет Аукцион "YetiCave"</small>