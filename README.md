# IronmanWebApp
This is the web app for the Ironman application including the php web service
## Simulating an HTTP request
 
Go to www.hurl.it
 
Select POST under destination and put http://robbise.no-ip.info/ironman/getContestants.php in the text box
 
Click add parameters and put in 'semester' for the name and 'FALL2015' for the value
 
click launch
In the body of the response you will see what will be returned from the web service. It will look something like this:
 
`[
{"pk_contestants_id":"5580c76b251eb","u_name":"Batman","register_date":"2015-06-17","percentage":"0.13453"}
,{"pk_contestants_id":"5580c7c77b1e9","u_name":"Eddy","register_date":"2015-06-17","percentage":"0.55830"}
,{"pk_contestants_id":"5580c79016727","u_name":"Finn","register_date":"2015-06-17","percentage":"0.25112"}
,{"pk_contestants_id":"557fc47ae2e3d","u_name":"Robbie Bise","register_date":"2015-06-16","percentage":"0.02242"}
]`
 
There will be several services available to us. Just replace getContestants.php in the URL with the service name and put in the right parameters and method
 
## SERVICES
 
### getContestants.php
method: GET
Function: returns a json array of objects that contain the contestants id, username, register_date and a percentage of completion.
Parameters:  'semester' ex. 'FALL2015'
Return example:

`[
{"pk_contestants_id":"5580c76b251eb","u_name":"Batman","register_date":"2015-06-17","percentage":"0.13453"}
,{"pk_contestants_id":"5580c7c77b1e9","u_name":"Eddy","register_date":"2015-06-17","percentage":"0.55830"}
,{"pk_contestants_id":"5580c79016727","u_name":"Finn","register_date":"2015-06-17","percentage":"0.25112"}
,{"pk_contestants_id":"557fc47ae2e3d","u_name":"Robbie Bise","register_date":"2015-06-16","percentage":"0.02242"}
]`
 
### getEntries.php
method: GET
Function: returns a json array of objects that contain the entries for a given user id
Parameters:  'semester' ex. 'FALL2015', 'id' ex. '5580c7c77b1e9'
Return example:

`[`
`{"pk_entries_id":"217","entry_date":"2015-08-28","distance":"112.0","fk_events":"16","fk_contestants":"5580c7c77b1e9","fk_mode":"1","pk_contestants_id":"5580c7c77b1e9","register_date":"2015-06-17","u_name":"Eddy","pk_events_id":"16","semester":"FALL2015 ","start_date":"2015-06-15","end_date":"2015-11-13","pk_mode_id":"1","mode":"Bike","units":"Miles"}`
 
`,{"pk_entries_id":"218","entry_date":"2015-08-29","distance":"12.0","fk_events":"16","fk_contestants":"5580c7c77b1e9","fk_mode":"2","pk_contestants_id":"5580c7c77b1e9","register_date":"2015-06-17","u_name":"Eddy","pk_events_id":"16","semester":"FALL2015 ","start_date":"2015-06-15","end_date":"2015-11-13","pk_mode_id":"2","mode":"Run","units":"Miles"}`
 
`,{"pk_entries_id":"219","entry_date":"2015-08-27","distance":"0.5","fk_events":"16","fk_contestants":"5580c7c77b1e9","fk_mode":"3","pk_contestants_id":"5580c7c77b1e9","register_date":"2015-06-17","u_name":"Eddy","pk_events_id":"16","semester":"FALL2015 ","start_date":"2015-06-15","end_date":"2015-11-13","pk_mode_id":"3","mode":"Swim","units":"Laps"}`
`]`

### getProgress.php
method: GET
Function: returns a json array of objects that contain the current progress in running(miles) swimming(laps) and biking(miles)
Parameters:  'semester' ex. 'FALL2015', 'id' ex. '5580c7c77b1e9'
Return example:

`[
	{"user":"Eddy","mode":"Bike","distance":"112.0"}
	,{"user":"Eddy","mode":"Run","distance":"12.0"}
	,{"user":"Eddy","mode":"Swim","distance":"0.5"} 
]`

 	
### newEntry.php
method: POST
Function: Inserts a new entry into the database for a given user and returns a json object that contains a code and a message. if the code is 0, everything is ok. If it is 1 then there was an issue.
Parameters:
mode ex. 1 2 or 3 (for bike swim and run respectively)
distance ex. 8.32, 1, .5
date ex. 2015-06-16 (SQL format)
user  ex. 5580c7c77b1e9
Return example:

`{"code":1, "message": "There was an error in the database: "exception 'PDOException' with message 'SQLSTATE[23000]: Integrity constraint violation: 1452 Cannot add or update a child row: a foreign key constraint fails (``iron_man``.``entries``, CONSTRAINT ``entries_ibfk_3`` FOREIGN KEY (``fk_mode``) REFERENCES ``mode`` (``pk_mode_id``))' in /var/www/html/ironman/newEntry.php:156`
`Stack trace:`
`\#0 /var/www/html/ironman/newEntry.php(156): PDOStatement->execute()`
`\#1 {main}"`
 
### newUser.php

method: POST
Function: Creates a new user in the database. Takes a username(optional) and checks to see if it exists already. This service relies on codes to communicate the result of trying to insert a new user. 

Parameters: 
username ex. "batman" (this is optional)

Return examples:

`{"code" : 2, "message": "There is no current IronMan in progress. Please check with the activities office for start dates."}`
`{"code" : 1, "message": "This username is a duplicate"}`
`{"code":-1, "message": "<<MESSAGE FROM DATABASE>> "} `
`{"code":0, "message": "<<13 digit user id>>"}`



