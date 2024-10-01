<?php
$x = array(
            'a' => 'b',
            'b' => 'c',
            'c' => 'd',
            'd' => 'e',
            'e' => 'f',
            'f' => 'g',
            'g' => 'h',
            'h' => null );

    $nested = parentChild($x);
    print_r($nested);

    function parentChild(&$x, $parent = false) {
      if( !$parent) { #первоначальный вывод
         $rootKey = array_search( null, $x);
         return array($rootKey => parentChild($x, $rootKey));
      }else { // через рекурсию 
        $keys = array_keys($x, $parent);
        $piece = array();
        if($keys) { // поиск дочерних
          if( !is_array($keys) ) { // только один дочерний
            $piece = parentChild($x, $keys);
           }else{ // несколько дочерних
             foreach( $keys as $key ){
               $piece[$key] = parentChild($x, $key);
             }
           }
        }else {
           return $parent; //вернуть родителя без дочерних элементов
        }
        return $piece; // вернуть массив построенный с помощью рекурсии
      }
    }
    ?>
