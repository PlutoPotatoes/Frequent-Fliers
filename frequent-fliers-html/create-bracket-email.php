<?php
    /*
 * Last Edited By: Ryan Morrell
 * Date: May 3rd, 2025
 * File: create-bracket-email.php
 *
 * This file is called when a lobby starts.
 * It creates a round-robin tournament where each player plays every other player once.
 * 
 * Functionality:
 * 1. Creates and configures a new PHPMailer object.
 * 2. Connects to the database and retrieves the eventID from the URL.
 * 3. Runs MySQL commands to:
 *    - Retrieve attendees.
 *    - Create matchups (including placeholders if the number of players is odd).
 *    - Insert each matchup into the eventMatches table.
 * 4. Retrieves all attendee emails from the database.
 * 5. Builds an HTML table displaying the match schedule.
 * 6. Sends an email with the match table to all attendees.
 */

    
    include('database.php');
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

    //grab eventID from the url (www.kitefightLA/something?eventID=##)
    $eventID = $_GET["eventID"];
    $conn = dbConn();


    //clear database of any duplicates
    $sql = "DELETE FROM eventMatch WHERE eventID = $eventID;";
    $conn->query($sql);
    $sql = "DELETE FROM attendee WHERE userID=-1;";
    $conn->query($sql);

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
    $userIDs = array_keys($attendees);



    //add rest round to database and $userIDs if needed
    if(count($userIDs)%2 == 1){
        $sql = "INSERT INTO attendee (userID, playerName, email, eventID) values (-1, 'Rest Round', null, $eventID );";
        $conn->query($sql);
        //$userIDs[-1] = -1;
        array_push($userIDs, -1);
    }


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
   
    //variable for tracking round numbers
    $count = 1;  
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
        //skip round if it includes a Rest Round player id
        if($row["player2"] == -1 || $row["player1"] == -1){
            continue;
        }
        $name1 = $attendees[$row["player1"]]["name"];
        $name2 = $attendees[$row["player2"]]["name"];
        //start new row
        $emailStr = $emailStr . "<tr>";

        //get row data
        $attackSide = $row["attackSide"];
        $matchNo = $row["matchNo"];

        

        //add data to the html email string
        $emailStr = $emailStr .'<td>' . $count . '</td>'; //get items 
        $emailStr = $emailStr .'<td>' . $name1 . '</td>'; //get items 
        $emailStr = $emailStr .'<td>' . $name2 . '</td>'; //get items 
        $emailStr = $emailStr .'<td>' . $attackSide . '</td>'; //get items 

        //end row
        $emailStr = $emailStr .'</tr>';
        $count++;
    }
    $emailStr = $emailStr . "</table>";
    $mail->isHTML(true);
    $mail->Subject = "Schedule";
    $mail->Body = $emailStr;

    foreach($attendees as $a){
        $email = $a["email"];
        $name = $a["name"];
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $mail->addAddress($email, $name);
        }

    }

    try{
        $mail->send();
    }catch (Exception $e) {
        header("Location: dashboard.php?eventID=$eventID");
        exit();
    }
    header("Location: dashboard.php?eventID=$eventID");
    exit();

?>
