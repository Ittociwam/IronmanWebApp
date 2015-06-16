

<!DOCTYPE html>
<html>
    <head>
        <?php
        require 'links.php';
        ?>
        <script>
            $(document).ready(function () {
                $('#start_date').datepicker({
                    format: "yyyy-mm-dd" // initilize the dates to sql format
                });

                $('#end_date').datepicker({
                    format: "yyyy-mm-dd"
                });
            });
        </script>

    </head>
    <body>
        <div class='well row'>
            <form action="insertNewEvent.php" method="GET" role="from">
                <div class=" form-group col-lg-12">
                    <label for="semester"> Semester: </label>
                    <div id="semester">
                        <select class="form-control" name="season" id="season">
                            <option value="FALL">Fall</option>
                            <option value="WINTER">Winter</option>
                            <option value="SPRING">Spring</option>
                        </select>
                        <select class="form-control" name="year" id="year">
                            <?php
                            foreach (range(date('Y'), 2010) as $x) {
                                print '<option value="' . $x . ' "' . ($x === date('Y') ? 'selected="selected"' : '') . '>' . $x . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class=" form-group col-lg-12">
                        <label for="start_date"> Start Date: </label>
                        <input type="text" required="required" placeholder="Click to choose a date" class="form-control" name="start_date" id="start_date">
                    </div>
                    <div class=" form-group col-lg-12">
                        <label for="end_date"> End Date: </label>
                        <input type="text" required="required" placeholder="Click to choose a date" class="form-control" name="end_date" id="end_date">
                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-primary" type="submit" > Send </button>
                    </div>
            </form>
            <div class='row'>
                <div class='col-lg-2 col-lg-offset-10'>
                    <a href="index.php"> <button type='button' class='btn btn-primary'>Return Home</button> </a>
                </div>
            </div>
        </div>
    </body>

</html>

