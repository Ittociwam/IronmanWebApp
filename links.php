<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
echo '  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>';
if (getenv('OPENSHIFT_MYSQL_DB_HOST')) {
    echo '<script type="text/javascript" src="/tablesorter-master/js/jquery.tablesorter.js"></script> 
        <link rel="stylesheet" type="text/css" href="/bootstrap/css/bootstrap.min.css"/>
        <script src="/tablesorter-master/js/jquery.tablesorter.widgets.js"></script>
        <link rel="stylesheet" href="/tablesorter-master/css/theme.blue.css"/>
        <script type="text/javascript" src="/bootstrap/js/bootstrap.js"></script>        
        <script type="text/javascript" src="/bootstrap/js/bootstrap-datepicker.js"></script>
        <link rel="stylesheet" href="/bootstrap/css/datepicker.css"/>';
} else {
    echo '<script type="text/javascript" src="/webengii/webengii/tablesorter-master/js/jquery.tablesorter.js"></script> 
        <link rel="stylesheet" type="text/css" href="/webengii/webengii/bootstrap/css/bootstrap.min.css"/>
        <script src="/webengii/webengii/tablesorter-master/js/jquery.tablesorter.widgets.js"></script>
        <link rel="stylesheet" href="/webengii/webengii/tablesorter-master/css/theme.blue.css"/>
        <script type="text/javascript" src="/webengii/webengii/bootstrap/js/bootstrap.js"></script>
        <script type="text/javascript" src="/webengii/webengii/bootstrap/js/bootstrap-datepicker.js"></script>
        <link rel="stylesheet" href="/webengii/webengii/bootstrap/css/datepicker.css"/>';
}
