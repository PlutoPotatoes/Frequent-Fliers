
//need to get kickButtons every few seconds instead of just at the start, list in static
//either set an interval or include this in the getTable.php script
const interval = setInterval(getButtons, 500);
let kickButtons = document.querySelectorAll(".deleteButton");
const eventID = document.querySelector(".table-spacer").id


function getButtons(){
    kickButtons = document.querySelectorAll(".deleteButton");
    kickButtons.forEach((button) => {
        const id = button.id;
        button.addEventListener("click", () =>{
          
          const php = "kickPlayer.php?eventID=" + eventID + "&userID="+ id;
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

