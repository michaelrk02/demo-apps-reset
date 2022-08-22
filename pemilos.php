 <?php

require 'lib/init.php';

$db = connect('pemilos');

execute($db, 'DROP DATABASE IF EXISTS '.$config['pemilos']['db_name']);
execute($db, 'CREATE DATABASE '.$config['pemilos']['db_name']);
execute($db, 'USE '.$config['pemilos']['db_name']);
execute_file($db, $config['pemilos']['db_name'], $config['pemilos']['db_file']);

function make_token($id) {
    return sprintf('%03d', $id);
}

$db->begin_transaction();
try {
    execute($db, 'INSERT INTO info (admin_password, year, theme, voters) VALUES ("21232f297a57a5a743894a0e4a801fc3", 2022, "We ARE the people!", 1500)');
    execute($db, 'INSERT INTO candidates (id, pair_name) VALUES (1, "Jokowi - Ma\'ruf"), (2, "Prabowo - Sandi"), (3, "Ganjar - Kamil")');
    for ($i = 0; $i < 1000; $i++) {
        $token = make_token($i);
        execute($db, 'INSERT INTO users (token, vote_id) VALUES ("'.$token.'", 0)');
    }
    $db->commit();
    echo 'PEMILOS has been reset'.PHP_EOL;
} catch (\Exception $e) {
    $db->rollback();
    echo 'Failed to reset PEMILOS : '.$e->getMessage();
}
