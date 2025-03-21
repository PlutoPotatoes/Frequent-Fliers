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


    $eventID = $_GET["eventID"];
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
    
    //convert query to array
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
        $userIDs[-1] = 00000;
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
        //array_push($userIDs, array_shift($userIDs));  
        array_splice( $userIDs, 1, 0, array_pop($userIDs)); 


    }


    $sql = "SELECT matchNo, player1, player2, attackSide from eventMatch where eventID=$eventID order by matchNo;";
    $result = $conn->query($sql);

    //display table  

    echo '<table class="data-table">
        <tr class="data-heading">';  //initialize table tag
    while ($property = mysqli_fetch_field($result)) {
        echo '<td>' . htmlspecialchars($property->name) . '</td>';  //get field name for header
    }
    echo '</tr>'; //end tr tag

    //showing all data
    while ($row = mysqli_fetch_row($result)) {
        echo "<tr>";
        foreach ($row as $item) {
            echo '<td>' . htmlspecialchars($item) . '</td>'; //get items 
        }
        echo '</tr>';
    }
    echo "</table>";

    /*
    $email = "email here";
    $name = "name here";
    //change email address
    $mail->addAddress($email, $name);
    //set subject line
    $mail->Subject = "BOO";
    //add email contents
    $mail->Body = "Hellooooooo";

    $mail->send();
    echo "Mail sent";
    */

?>

<body>

</body>
</html>