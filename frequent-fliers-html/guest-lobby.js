const leaveButton = document.querySelector(".leave-button")

leaveButton.addEventListener("click", ()=>{
    const eventID = leaveButton.data-eventID;
    const playerID = leaveButton.data-playerID;
    const php = "leaveLobby.php?eventID=" + eventID + "&userID=" + playerID;
    console.log(php);

});

/*
function getButtons(){
    kickButtons = document.querySelectorAll(".kick-button");
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
      */