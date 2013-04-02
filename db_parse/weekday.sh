#! /bin/bash


echo "Ontario Keno\n"
php on_test_db_web_keno.php update
echo "Ontario Pick 3\n"
php on_test_db_web_pick3.php update
echo "Ontario Pick 4\n"
php on_test_db_web_pick4.php update
echo "Ontario Poker\n"
php on_test_db_web_poker.php update
