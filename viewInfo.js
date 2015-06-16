/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor. branch
 */



function getEntries() {
    if (!localStorage.getItem("user")) {
        entriesError("You have not yet submitted any entries on this machine.");
    }
    else {
        var xmlhttp = new XMLHttpRequest();
        var url = "getEntries.php";
        var postData = "semester=" + document.getElementById("semester1").value
                + "&id=" + localStorage["user"];


        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                console.log(xmlhttp.responseText);
                var data = JSON.parse(xmlhttp.responseText);
                displayEntries(data);
            }
        };
        xmlhttp.open("POST", url, true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
//xmlhttp.setRequestHeader("Content-length", postData.length);
//xmlhttp.setRequestHeader("Connection", "close");
        xmlhttp.send(postData);
    }
}

function entriesError(message) {
    document.getElementById("entryResults").innerHTML = message;
}


function getContestants() {
    var xmlhttp = new XMLHttpRequest();
    var url = "getContestants.php";
    var postData = "semester=" + document.getElementById("semester").value;

    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            console.log(xmlhttp.responseText);
            var data = JSON.parse(xmlhttp.responseText);

            displayContestants(data);
        }
    };
    xmlhttp.open("POST", url, true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
//xmlhttp.setRequestHeader("Content-length", postData.length);
//xmlhttp.setRequestHeader("Connection", "close");
    xmlhttp.send(postData);


}

function displayContestants(data) {
    var out = "No Contestants";
    if (data.length != 0) {
        var semester = getSemester(document.getElementById("semester").value);
        out = "<h2>Students registered for the Lazy Man Iron Man </br> <small> " + semester + "</small></h2>";
        out += "<table id='table1' class='tablesorter table table-striped'>\n\
                    <thead>\n\
               <tr> <th> User Name </th> <th> Date Registered </th> <th> Percentage Complete </th> </tr>\n\
                    </thead>\n\
                        <tbody>";
        for (var i = 0; i < data.length; i++) {
            var username = "No Username";
            if (data[i].u_name != null)
                username = data[i].u_name;
            else
                username = data[i].pk_contestants_id;
            out += "<tr> \n\
                        <td>" + username + "</td>" +
                       "<td>" + data[i].register_date + "</td>\n\
                        <td>" + Math.floor(data[i].percentage * 100) + "%</td></tr>"; 
        }
                out + "</tbody>\n\
                    </table>";
    }

    document.getElementById("contestantResults").innerHTML = out;
    $("#table1").tablesorter({
        theme: 'blue',
        sortList: [[1, 0], [2, 0], [3, 0]],
        // header layout template; {icon} needed for some themes
        headerTemplate: '{content}{icon}',
        // initialize column styling of the table
        widgets: ["columns"],
        widgetOptions: {
            // change the default column class names
            // primary is the first column sorted, secondary is the second, etc
            columns: ["primary", "secondary", "tertiary"]
        }
    });
}

function displayEntries(data) {
    var out = "No Entries"
    if (data.length != 0) {
        var username = "No Username";
        if (data[0].u_name != null)
            username = data[0].u_name;
        var semester = getSemester(data[0].semester);
        out = "<h2>Entries For " + username + " for " + semester + "</h2>";
        out += "<table id='table2' class='tablesorter table table-striped'><thead>\n\
               <tr> <th> User Name </th> <th> Date  </th> <th> Action </th> \n\
               </tr> </thead> <tbody>";
        for (var i = 0; i < data.length; i++) {
           var date = new Date(data[i].entry_date + "T00:00:00-07:00");
            out += "<tr> <td>" + username + "</td>" +
                    "<td>" + date.toLocaleDateString() + "</td>"
                    + "<td>" + getAction(data[i]) + "</td></tr>";
        }
        out + "</tbody></table>";

    }
    document.getElementById("entryResults").innerHTML = out;
    $("#table2").tablesorter(
            {
                theme: 'blue',
                sortList: [[1, 0], [2, 0], [3, 0]],
                // header layout template; {icon} needed for some themes
                headerTemplate: '{content}{icon}',
                // initialize column styling of the table
                widgets: ["columns"],
                widgetOptions: {
                    // change the default column class names
                    // primary is the first column sorted, secondary is the second, etc
                    columns: ["primary", "secondary", "tertiary"]
                }
            });
}

function getAction(data) {
    var action = "";
    switch (data.mode) {
        case "Bike":
            action = "Biked ";
            break;
        case "Swim":
            action = "Swam ";
            break;
        case "Run":
            action = "Ran ";
            break;
    }
    action += data.distance + " " + data.units;
    return action;
}

function getSemester(semester) {
    var year = semester.replace(/\D/g, "");
    var sem = semester.replace(/[^a-z]/gi, "");

    // title case word?
    for (var i = 1; i < sem.length; i++) {

        sem[i] = sem[i].toLowerCase();
    }
    return sem + " " + year;
}

