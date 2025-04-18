
//creates an array of all "accordion-title" elements
const accordionTitles = document.querySelectorAll(".accordion-title");
const eventID = document.querySelector(".accordion").id;

//add event listener to each accordionTitle on the site
accordionTitles.forEach((accordionTitle) => {
  accordionTitle.addEventListener("click", () => {
    const P1Score = parseInt(document.getElementById(accordionTitle.id + "P1Score").value, 10);
    const P2Score = parseInt(document.getElementById(accordionTitle.id + "P2Score").value, 10);


    accordionTitles.forEach((close) =>{
      if(close.classList.contains("active-header"))
      {
        close.readOnly=false;
        if(P1Score != 0 || P2Score != 0){
          console.log("P1: " + P1Score + " P2: " + P2Score);
        }
        close.readOnly=true;
        if(close != accordionTitle){
          close.nextElementSibling.style.maxHeight = "0px";   
          close.classList.toggle("active-header");
        }
      } 


    });

    const height = accordionTitle.nextElementSibling.scrollHeight;
    accordionTitle.classList.toggle("active-header");
    if(accordionTitle.classList.contains("active-header")){
      accordionTitle.nextElementSibling.style.maxHeight = `${height}px`;

    }else{
      accordionTitle.nextElementSibling.style.maxHeight = "0px";    
  
    }
  });
});




const incrementButtons = document.querySelectorAll(".touch-button");

incrementButtons.forEach((button) => {
  button.addEventListener("click", () =>{
    const scoreID = button.id + "Score";
    document.getElementById(scoreID).readOnly = false;
    const val = Math.min(parseInt(document.getElementById(scoreID).valueAsNumber, 10) + 1, 3);
    //val = val+1;
    document.getElementById(scoreID).value = `${val}`;
    document.getElementById(scoreID).readOnly = true;
    const match = scoreID.split("M")[1].split("P")[0];
    const player = scoreID.split("P")[1].split("S")[0];

    const php = "updateDB.php?eventID=" + eventID + "&matchID=" + match  + "&player="+ player + "&score=" + val;
    console.log(php);
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
       // MANAGE THE RESPONSE
       var response = this.responseText;
      }
    }
    xmlhttp.open("POST", php, true);
    xmlhttp.send();

  });
});
  
const decrementButtons = document.querySelectorAll(".crash-button");

decrementButtons.forEach((button) => {
  button.addEventListener("click", () =>{
    const scoreID = button.id + "Score";
    document.getElementById(scoreID).readOnly = false;

    //val = val+1;
    document.getElementById(scoreID).value = 3;
    document.getElementById(scoreID).readOnly = true;
    const match = scoreID.split("M")[1].split("P")[0];
    const player = scoreID.split("P")[1].split("S")[0];

    const php = "updateDB.php?eventID=" + eventID + "&matchID=" + match  + "&player="+ player + "&score=" + 3;
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

const resetButtons = document.querySelectorAll(".reset-button");

resetButtons.forEach((button) => {
  button.addEventListener("click", () =>{
    const score1 = button.id + "P1" + "Score";
    const score2 = button.id + "P2" + "Score";

    document.getElementById(score1).readOnly = false;
    document.getElementById(score2).readOnly = false;

    document.getElementById(score1).value = 0;
    document.getElementById(score2).value = 0;

    document.getElementById(score1).readOnly = true;
    document.getElementById(score2).readOnly = true;

    const match = button.id.split("M")[1];

    const php = "resetMatch.php?eventID=" + eventID + "&matchID=" + match;

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
 
