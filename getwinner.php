<?php
$sql = "SELECT u.name AS user_name, u.email, r1.user_id, r1.rate, r1.lot_id, l.name AS lot_name, l.dt_end, l.winner FROM rates r1 "
	. "JOIN (SELECT lot_id, MAX(rate) AS rate FROM rates GROUP BY lot_id) AS r2 ON r1.lot_id = r2.lot_id AND r1.rate = r2.rate "
	. "JOIN lots l ON l.id = r1.lot_id "
	. "JOIN users u ON u.id = r1.user_id "
	. "WHERE l.winner IS NULL "
	. "AND l.dt_end <= NOW()";
$res = mysqli_query($link, $sql);

if ($res && mysqli_num_rows($res) > 0) {
	$winners = mysqli_fetch_all($res, MYSQLI_ASSOC);
	
	$save_winners_sql = "UPDATE lots, "
			. "(SELECT r1.user_id, r1.lot_id FROM rates r1 "
			.	"JOIN ("
			.		"SELECT lot_id, MAX(rate) AS rate "
			.		"FROM rates "
			.		"GROUP BY lot_id"
			.	") AS r2 "
			.	"ON r1.lot_id = r2.lot_id AND r1.rate = r2.rate "
			.	"JOIN lots l ON l.id = r1.lot_id "
			.	"WHERE l.winner IS NULL "
			.	 "AND l.dt_end <= NOW()) "
			. "AS winners "
			. "SET lots.winner = winners.user_id "
			. "WHERE lots.id = winners.lot_id";
	mysqli_query($link, $save_winners_sql);

	foreach($winners as $winner) {
		$transport = new Swift_SmtpTransport('smtp.mailtrap.io', 25);
		$transport->setUsername("ae6f8d04a6c881");
		$transport->setPassword("7495680f733f97");

		$mailer = new Swift_Mailer($transport);

		$message = new Swift_Message();
		$message->setSubject('Ваша ставка победила');
		$message->setFrom(['keks@phpdemo.ru' => 'YetiCave']);
		$message->setTo([$winner['email'] => $winner['user_name']]);
		$msg_content = include_template('email.php', ['winner' => $winner]);
        $message->setBody($msg_content, 'text/html');

        $result = $mailer->send($message);
	}
}

