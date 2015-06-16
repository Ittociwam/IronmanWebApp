<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor. I am in a new branch????????
-->
<html>
    <head>
                <?php
        require 'links.php';
        ?>
        <link type="text/css" rel="stylesheet" href="ironman.css"/>
    </head>
    <body>
        <div class="container">
            <div class="row vertical-center-row">
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-6"><button onclick="parent.location = 'viewInfo.php'" type="button" class="btn btn-primary btn-lg"> Get Entries and Rankings </button></div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-6"><button onclick="parent.location = 'insertInfo.php'" type="button" class="btn btn-primary btn-lg"> Insert Entry </button></div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-6"><button onclick="parent.location = 'newEvent.php'" type="button" class="btn btn-primary btn-lg"> Create Event (Admin only) </button></div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
