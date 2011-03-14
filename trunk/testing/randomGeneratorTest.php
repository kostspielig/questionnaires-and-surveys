<?php

function array_permutations($items, $perms = array()) {
    static $permuted_array;
    if (empty($items)) {
        $permuted_array[] = $perms;
    } else {
        for ($i = count($items) - 1; $i >= 0; --$i) {
            $newitems = $items;
            $newperms = $perms;
            list($foo) = array_splice($newitems, $i, 1);
            array_unshift($newperms, $foo);
            array_permutations($newitems, $newperms);
        }
        return $permuted_array;
    }
}
 
//To use:
$result=array_permutations(array("South","Africa","Rugby"));
var_dump($result);