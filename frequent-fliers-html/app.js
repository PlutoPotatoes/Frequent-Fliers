
//creates an array of all "accordion-title" elements
const accordionTitles = document.querySelectorAll(".accordion-title");

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




const incrementButtons = document.querySelectorAll(".increment-button");

incrementButtons.forEach((button) => {
  button.addEventListener("click", () =>{
    const scoreID = button.id + "Score";
    document.getElementById(scoreID).readOnly = false;
    const val = Math.min(parseInt(document.getElementById(scoreID).valueAsNumber, 10) + 1, 99);
    //val = val+1;
    document.getElementById(scoreID).value = `${val}`;
    document.getElementById(scoreID).readOnly = true;

  });
});
  
const decrementButtons = document.querySelectorAll(".decrement-button");

decrementButtons.forEach((button) => {
  button.addEventListener("click", () =>{
    const scoreID = button.id + "Score";
    document.getElementById(scoreID).readOnly = false;
    const val = Math.max(parseInt(document.getElementById(scoreID).valueAsNumber, 10) - 1, 0 );
    //val = val+1;
    document.getElementById(scoreID).value = `${val}`;
    document.getElementById(scoreID).readOnly = true;

  });
});
