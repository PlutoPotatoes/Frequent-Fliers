
//creates an array of all "accordion-title" elements
const accordionTitles = document.querySelectorAll(".accordion-title");

//add event listener to each accordionTitle on the site
accordionTitles.forEach((accordionTitle) => {
  accordionTitle.addEventListener("click", () => {

    accordionTitles.forEach((close) =>{
      close.nextElementSibling.style.maxHeight = "0px";    
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
