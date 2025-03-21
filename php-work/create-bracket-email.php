<!DOCTYPE html>
<html>


<head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">

</head>

<?php

    require "vendor/autoload.php";
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->SMTPAuth = true;

    $mail->Host = "smtp.gmail.com";
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->Username = "kitefightla@gmail.com";
    $mail->Password = "rrdp jbdy ttea dibq";
    $mail->setFrom("kitefightla@gmail.com", "Kite Fight LA");

    //FIXME uncomment when ready to use with actual events, will grab eventID from the url
    //$eventID = $_GET["eventID"];
    $eventID = 19;

    //server connection details
    $host = 'sql.cianci.io';
    $dbname = 'frequentfliers';
    $username = 'rmorrell';
    $password = 'e2VaSdfES6sU';

    $conn = new mysqli($host, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    //query database for event attendees
    $getAttendees = "SELECT * FROM attendee WHERE eventID = $eventID;";
    $result = $conn->query($getAttendees);  
    
    //convert query to array and store emails and names
    // $attendees[userID] = ['email' = email, 'name' = name]
    $attendees = [];
    while($row = $result->fetch_assoc()){
        $attendees[$row["userID"]] = array(
            "email" => $row["email"],
            "name" => $row["playerName"]
        );
    }

    //add rest round if needed
    $userIDs = array_keys($attendees);
    if(count($userIDs)%2 == 1){
        $sql = "INSERT INTO attendee (playerName, email, eventID) values ('Rest Round', '---', $eventID );";
        $conn->query($sql);
        $lastID = $conn->insert_id;
        $userIDs[-1] = $lastID;
    }

    $sql = "DELETE FROM eventMatch WHERE eventID = 19;";
    $conn->query($sql);
    //create master schedule array
    //each match is an array with 2 userIDs as values
    $matchNo = 1;
    $n = count($userIDs);
    $halfN = intdiv(count($userIDs),2);

    for($i = 0; $i < $n-1; ++$i){
        for($j = 0; $j < $halfN; ++$j){

            $p1 = $userIDs[$n-1-$j];
            $p2 = $userIDs[$j];
            $attackSide;
            if(rand(0,1)==1){
                $attackSide = 'top';
            }else{
                $attackSide = 'bot';
            }
            $sql = "INSERT INTO eventMatch (eventID, attackSide, matchNo, player1, player2) 
            VALUES ($eventID, '$attackSide', $matchNo, $p1, $p2);";
            $conn->query($sql);

            $matchNo+=1;
        }
        //pops from the front, pushes that value to the end
        array_splice( $userIDs, 1, 0, array_pop($userIDs)); 


    }

    //get newly created match information from DB
    $sql = "SELECT matchNo, player1, player2, attackSide from eventMatch where eventID=$eventID order by matchNo;";
    $result = $conn->query($sql);
   
    
      
    //format match information into an html table to be emailed
    $emailStr = '<table class="data-table" cellpadding="5" border="1" style= "border-collapse: collapse;"><tr class="data-heading">';

    //initialize table tag
    $emailStr = $emailStr . '</tr>'; //end tr tag
    $emailStr = $emailStr . '<td>' . "Match #" . '</td>';  //get field name for header
    $emailStr = $emailStr . '<td>' . "Flier 1" . '</td>';  //get field name for header
    $emailStr = $emailStr . '<td>' . "Flier 2" . '</td>';  //get field name for header
    $emailStr = $emailStr . '<td>' . "Attack Angle" . '</td>';  //get field name for header
    $emailStr = $emailStr . '</tr>'; //end tr tag

    //add all data to the table row by row
    while ($row = $result->fetch_assoc()) {
        //start new row
        $emailStr = $emailStr . "<tr>";

        //get row data
        $attackSide = $row["attackSide"];
        $matchNo = $row["matchNo"];
        $name1 = $attendees[$row["player1"]]["name"];
        $name2 = $attendees[$row["player2"]]["name"];

        //add data to the html email string
        $emailStr = $emailStr .'<td>' . $matchNo . '</td>'; //get items 
        $emailStr = $emailStr .'<td>' . $name1 . '</td>'; //get items 
        $emailStr = $emailStr .'<td>' . $name2 . '</td>'; //get items 
        $emailStr = $emailStr .'<td>' . $attackSide . '</td>'; //get items 

        //end row
        $emailStr = $emailStr .'</tr>';
    }
    $emailStr = $emailStr . "</table>";


    $email = "rmorrell@oxy.edu";
    $name = "Ryan";
    //change email address
    $mail->isHTML(true);
    $mail->addAddress($email, $name);
    //set subject line
    $mail->Subject = "Schedule";
    //add email contents
    $mail->Body = $emailStr;

    $mail->send();
    echo "Mail sent";


?>

<body>

</body>
</html>