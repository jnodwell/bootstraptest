<?php
/**
 * Created by PhpStorm.
 * User: jennifernodwell
 * Date: 9/17/16
 * Time: 4:25 PM
 */

//set the message and encode it and return it
$start = 2;
if (!filter_var($_POST['get_primes_qty'], FILTER_VALIDATE_INT) === false) {
    $count = $_POST['get_primes_qty'];
    $type = 'success';
} else {
    $count = 100;
    $type = 'warning';
}
if ($count > 1000) {
    $count = 100;
}
$response = $count . " Primes<br />" . implode(', ', nextPrimes($start,$count));
$responseArray = array('type' => $type, 'message' => $response);
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $encoded = json_encode($responseArray);
    header('Content-Type: application/json');
    echo $encoded;
} else {
    echo $responseArray['message'];
}


/**
 * 	Check to see if a given integer is prime.
 *
 * 	Adapted from this Python implementation http://pthree.org/2007/09/05/prime-numbersin-	 python/
 *   This list of the first 10,000 prime numbers is also helpful http://primes.utm.edu/lists/small/10000.txt
 *
 *	 @param int $number the number to check to see if it is prime.
 *	 @return boolean true if the number is prime, false if not.
 */
function isPrime($number) {
    $n = abs($number);
    $i = 2;
    while ($i <= sqrt($n)) {
        if ($n % $i == 0) {
            return false;
        }
        $i++;
    }
    return true;
}
/**
 * 	Given a positive integer, find the next 10 prime numbers that are equal to it or greater.
 *
 *	 @param int $number the number to find the next time prime numbers.
 *	 @return array an array of the next ten prime numbers.
 */
function nextPrimes($number,$many) {
    $nextP = array();
    //Keep looping until we have an array of $many prime numbers.
    while ((sizeof($nextP) <= $many-1) && ($number <= 100000)) {
        if (isPrime($number)) {
            $nextP[] = $number;
        }
        $number++;
    }
    return $nextP;
}

//normally we use Sieve of Eratosthenes
/**
 * Find all the primes up to a given number using the sieve of Eratosthenes algorithm.
 *
 * @param $finish The last prime to provide.
 *
 * @return array The array of prime numbers.
 */
function find_primes($finish) {

    // Initialise the range of numbers.
    $number = 2;
    $range = range(2, $finish);
    $primes = array_combine($range, $range);

    // Loop through the numbers and remove the multiples from the primes array.
    while ($number*$number < $finish) {
        for ($i = $number; $i <= $finish; $i += $number) {
            if ($i == $number) {
                continue;
            }
            unset($primes[$i]);
        }
        $number = next($primes);
    }
    return $primes;
}