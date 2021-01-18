<?php

function lang($phrase){

    static $langs=array(
           /*Navbar links*/

        'HOME_Admin'=>'Admin Area',
        'CATEGORIES'=>'categories',
        'ITEMS'     =>'items',
        'MEMBERS'   =>'members',
        'STATISTICS'=>'statistics',
        'LOGS'      =>'logs'

    );
    return $langs[$phrase];
  
}

?>