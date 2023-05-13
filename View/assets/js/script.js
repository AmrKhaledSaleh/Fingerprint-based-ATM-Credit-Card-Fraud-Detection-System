let closeBTN = document.getElementById("close")
let serviceBTN = document.getElementById("serviceBTN")
let servicePOP = document.querySelector(".serviceLogin")
let insert = document.querySelector(".insert")
//CHAT GPT Vars
const inputcc = document.getElementById("credit-card");
const pin = document.getElementById("PIN");
const fileInput = document.querySelector('input[type="file"]');
const popup = document.querySelector('.popup');
let allElems = document.querySelectorAll("body > div:not(.popup)");

serviceBTN?.addEventListener("click", (e) => {
    servicePOP.classList.toggle("active")
    insert.classList.toggle("active")
})

closeBTN?.addEventListener("click", (e) => {
    servicePOP?.classList.toggle("active")
    insert.classList.toggle("active")
})

//**** CHAT GPT ****
if (window.location.pathname.endsWith("index.php")) {
    // Credit card format
    inputcc.addEventListener("input", function(event) {
        let cardNumber = this.value.replace(/\s/g, "");// Remove any existing spaces from the input value
        let formattedNumber = cardNumber.match(/.{1,4}/g).join(" ");// Split the input value into groups of 4 digits
        this.value = formattedNumber;// Set the formatted value back as the input value
    });

    // Digits only in the Credit card
    inputcc.addEventListener("keydown", function(event) {
        // Allow: backspace, delete, tab, escape, enter and .
        if (event.key === 'Backspace' || event.key === 'Delete' || 
            event.key === 'Tab' || event.key === 'Escape' || 
            event.key === 'Enter' || (event.key === 'c' && event.ctrlKey === true) || 
            (event.key === 'v' && event.ctrlKey === true) ||
            (event.key === 'a' && event.ctrlKey === true) ||
            (event.key === 'z' && event.ctrlKey === true) ||
            (event.key === 'y' && event.ctrlKey === true)) {
            return;
        } else {
            // Ensure that it is a number and stop the keypress
            if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105)) {
                event.preventDefault();
            }
        }
    });

    //Digits only in PIN input
    pin.addEventListener("input", function () {
        this.value = this.value.replace(/[^0-9]/g, "");
    });

    //Only accept images
    fileInput.addEventListener('change', () => {
        const files = fileInput.files;
        const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            if (!allowedTypes.includes(file.type)) {
                alert('Only images are allowed!');
                fileInput.value = ''; // Reset the file input
                return;
            }
        }
    });
}
//Close the popup window if pressed outside
Array.from(allElems).forEach(elem =>
elem.addEventListener("click", (e)=> {
    if(popup.classList.contains("active") && !serviceBTN.contains(e.target)){
        servicePOP?.classList.toggle("active")
        insert.classList.toggle("active")
    }
}));
