
/*
 * Last Edited By: Cael McDermott
 * Date: May 2nd, 2025
 * Course: CS 367 - Practicum
 * File: lobby.js
 *
 * This JavaScript file manages the dynamic behavior of the Host-Lobby page.
 * It repeatedly fetches all kick buttons every 500 milliseconds and attaches
 * click event listeners to them. When a kick button is clicked, it sends an
 * XMLHttpRequest to kickPlayer.php with the eventID and userID to remove the
 * specified player from the lobby.
 */


//need to get kickButtons every few seconds instead of just at the start, list in static
//either set an interval or include this in the getTable.php script
const interval = setInterval(getButtons, 500);
let kickButtons = document.querySelectorAll(".kick-button");
const eventID = document.querySelector(".table-spacer").id


function getButtons(){
    kickButtons = document.querySelectorAll(".kick-button");
    kickButtons.forEach((button) => {
        const id = button.id;
        button.addEventListener("click", () =>{
          
          const php = "ff.cianci.io/kickPlayer.php?eventID=" + eventID + "&userID="+ id;
          console.log(php);
          const xmlhttp = new XMLHttpRequest();
          xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
             // MANAGE THE RESPONSE
             const response = this.responseText;
            }
          }
          xmlhttp.open("POST", php, true);
          xmlhttp.send();
      
        });
      });
}

