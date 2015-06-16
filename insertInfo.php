<!DOCTYPE html>
<html>
    <head>
        <title>DB access</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php
        require 'links.php';
        ?>
        <script src="insertInfo.js"></script>

    </head>
    <body>
        <div class="well row">
            <h2> Put in an entry! </h2>
            <form id='entryForm' role="from">
                <div class=" form-group col-lg-12">
                    <label for="mode"> Mode: </label>
                    <select class="form-control" name="mode" id="mode">
                        <option value="Bike">Bike</option>
                        <option value="Swim">Swim</option>
                        <option value="Run">Run</option>
                    </select>
                </div>
                <div class=" form-group col-lg-12">
                    <label id="distLabel" for="distance"> Distance (miles): </label>
                    <input type="number" min="0" step="0.1" max="112" required="required" class="form-control" name="distance" id="distance">
                </div>
                <div class=" form-group col-lg-12">
                    <label for="date"> Date: </label>
                    <input type="text" required="required" placeholder="Click to choose a date" name="entryDate" class="form-control" id="entryDate">
                </div>
                <div class="col-md-6">
                    <button class="btn btn-primary" onclick='validateUser()' type="button"> Send </button>
                </div>
            </form>
            <div class='row'>
                <div class='col-lg-2 col-lg-offset-10'>
                    <a href="index.php"> <button class='btn btn-primary'>Return Home</button> </a>
                </div>
            </div>
        </div>

        <!-- Modals -->

        <div id="unameModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 id="unameModalTitle" class="modal-title">Your device is not in our system! Would you like a Username?</h4>
                    </div>
                    <div class="modal-body">
                        <div class=" form-group col-lg-12">
                            <input id='userName' type="text" autofocus placeholder='Enter a Username here.' class="form-control" >
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="submitNum" class=" modalSubmit btn btn-default">I'm OK with being just an ID number</button>
                        <button type="button" id="submitUname" class=" modalSubmit btn btn-primary">Sure</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div id="finishedModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close"  data-dismiss="modal">&times;</button>
                        <h4 id='finishedTitle' class="modal-title">There was a problem...</h4>
                    </div>
                    <div class="modal-body">
                        <p id="finishedBody"></p>
                    </div>
                    <div class="modal-footer">
                        <a href='viewInfo.php'> <button type="button" class="btn btn-default" >Go to rankings</button> </a>
                        <button type="button" class="btn btn-default" id='endButton' data-dismiss="modal">Insert another entry</button>
                    </div>
                </div>
            </div>
        </div>
        

    </body>
</html>


