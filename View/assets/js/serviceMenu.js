let closeMenu = document.getElementById("closeMenu")
let serviceMenu = document.querySelector(".serviceMenu")
let cashBTN = document.getElementById("cashBTN")
let insert = document.querySelector(".insert")
let allElems = document.querySelectorAll("body > div:not(.popup)")
const popup = document.querySelector('.popup');
let serviceBTN = document.querySelector('.btnMenu')

cashBTN?.addEventListener("click", (e) => {
    serviceMenu.classList.toggle("active")
    insert.classList.toggle("active")
})

closeMenu?.addEventListener("click", (e) => {
    serviceMenu?.classList.toggle("active")
    insert.classList.toggle("active")
})

//Close the popup window if pressed outside
Array.from(allElems).forEach(elem =>
    elem.addEventListener("click", (e)=> {
        if(popup.classList.contains("active") && !serviceBTN.contains(e.target)){
            insert.classList.toggle("active")
            serviceMenu?.classList.toggle("active")
        }
    }));