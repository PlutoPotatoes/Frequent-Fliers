const leaveButton = document.querySelector("#leave-button")

leaveButton.addEventListener("click", ()=>{
    const eventID = leaveButton.dataset.eventid;
    const playerID = leaveButton.dataset.playerid;
    const php = "leave-lobby.php?eventID=" + eventID + "&userID=" + playerID;
    window.location.href = php;

});
