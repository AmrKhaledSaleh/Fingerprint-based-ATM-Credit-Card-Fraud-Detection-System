const transactionDivs = document.querySelectorAll('.transaction');
let popupId;
let insert = document.querySelector('.insert');
// add click event listener to each transaction div
transactionDivs.forEach(div => {
    div.addEventListener('click', () => {
    // get the id of the corresponding popup
    popupId = div.id + '-popup';    // show the popup with the matching id
    console.log(popupId);
    document.getElementById(popupId).classList.toggle('active');
    insert.classList.toggle('active');
});
});

// add click event listener to each close button
const closeButtons = document.querySelectorAll('.fa-xmark');
closeButtons.forEach(btn => {
    btn.addEventListener('click', () => {
    // hide the corresponding popup when close button is clicked
    // const popupId = btn.closest('.popup').id;
    document.getElementById(popupId).classList.toggle('active');
    insert.classList.toggle('active');
});
});