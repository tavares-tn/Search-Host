<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Rede
 *
 * @author tavares
 */
class Rede {

    private $ip = array();
    private $mac = array();
    private $hotname = array();
    private $rede = array();

    function tamanhoRede($mascara) {

        switch ($mascara) {
            case '9':
                return 8388606;
            case '10':
                return 4194302;
            case '11':
                return 2097150;
            case '12':
                return 1048574;
            case '13':
                return 524286;
            case '14':
                return 262142;
            case '15':
                return 131070;
            case '16':
                return 65534;
            case '17':
                return 32766;
            case '18':
                return 16382;
            case '19':
                return 8190;
            case '20':
                return 4094;
            case '21':
                return 2046;
            case '22':
                return 1022;
            case '23':
                return 510;
            case '24':
                return 254;
            case '25':
                return 126;
            case '26':
                return 62;
            case '27':
                return 30;
            case '28':
                return 14;
            case '29':
                return 6;
            case '30':
                return 2;
        }
    }

    function scanUm($inicio, $range) {

        $inicio = substr($inicio, 0, -2);

        for ($i = 0; $i < $range; $i++) {

            $tmp = shell_exec("arping $inicio.$i -c1");

            if ((strlen($tmp)) > 140) {

                $ip[$i] = substr($tmp, 61, -84); //ip
                $mac[$i] = substr($tmp, 72, -64); //mac
                $t = shell_exec("nslookup $ip[$i]");
                $t = substr($t, 77,-2); //hostname
                $hotname[$i] = $t;
            }
        }

        return (array_merge($ip, $mac, $hotname));
    }

    function scanDois($inicio, $range) {
        $inicio = substr($inicio, 0, -4);
        $p = 0;
        $x = 8;
        for ($i = 0; $i < $range; $i++) {


            if ($p < 255) {


                $tmp = shell_exec("arping $inicio.$x.$p -c1");


                if ((strlen($tmp)) > 150) {

                    $ip[$i] = substr($tmp, 60, -84); //ip
                    $mac[$i] = substr($tmp, 72, -64); //mac
                    $t = shell_exec("nslookup $ip[$i]");
                    $t = substr($t, 77); //hostname
                    $hotname[$i] = $t;
                }
            } else {
                $x = $x + 1;
                $p = 0;
            }
            $p = $p + 1;
        }
        return (array_merge($ip, $mac, $hotname));
    }

    function scanTres($inicio, $range) {
        $inicio = substr($inicio, 0, -6);
        $p = 0;
        $x = 0;
        $y = 0;
        for ($i = 0; $i < $range; $i++) {


            if ($p < 255) {


                $tmp = shell_exec("arping $inicio.$y.$x.$p -c1");


                if ((strlen($tmp)) > 150) {

                    $ip[$i] = substr($tmp, 62, -84); //ip
                    $mac[$i] = substr($tmp, 72, -64); //mac
                    $t = shell_exec("nslookup $ip[$i]");
                    $t = substr($t, 77); //hostname
                    $hotname[$i] = $t;
                }
            } else {
                if ($x > 254) {
                    $y = $y + 1;
                    $x = 0;
                    $p = 0;
                } else {
                    $x = $x + 1;
                    $p = 0;
                }
            }
            $p = $p + 1;
        }
        return (array_merge($ip, $mac, $hotname));
    }

}

//end
