<?php 
$x = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h'];
function tree($trees){
    print_r($trees);
}
class Recurse{
    public static function get($x){
        $y = array_pop($x);
        if (!empty($x)){
            return array( $y=>self::get($x));
        } else {
            return array($y=>false);
        }
    }
}
tree(Recurse::get($x));
?>