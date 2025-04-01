
//creates an array of all "accordion-title" elements
const accordionTitles = document.querySelectorAll(".accordion-title");

//add event listener to each accordionTitle on the site
accordionTitles.forEach((accordionTitle) => {
  accordionTitle.addEventListener("click", () => {
    const height = accordionTitle.nextElementSibling.scrollHeight;
    accordionTitle.classList.toggle("active-header");
    if(accordionTitle.classList.contains("active-header")){
      accordionTitle.nextElementSibling.style.maxHeight = `${height}px`;
    }else{
      accordionTitle.nextElementSibling.style.maxHeight = "0px";      
    }
  });
});
  
// testing if this is working properly... 