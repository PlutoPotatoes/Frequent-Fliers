/*
 * Last Edited By: Cael McDermott
 * Date: May 2nd, 2025
 * Course: CS 367 - Practicum
 * File: guest-lobby.js
 *
 * This script handles the leave button in the lobby. When clicked,
 * it retrieves the eventID and playerID from the button’s data attributes
 * and redirects the user to leave-lobby.php with the appropriate query
 * parameters to remove the player from the lobby.
 */

const leaveButton = document.querySelector("#leave-button")

leaveButton.addEventListener("click", ()=>{
    const eventID = leaveButton.dataset.eventid;
    const playerID = leaveButton.dataset.playerid;
    const php = "leave-lobby.php?eventID=" + eventID + "&userID=" + playerID;
    window.location.href = php;

});
