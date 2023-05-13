let menuBTN = document.getElementById("menuBTN")
let bodyTAG = document.querySelector("body")
let createAccount = document.getElementById("createAccount")
let editAccount = document.getElementById("editAccount")
let deleteAccount = document.getElementById("deleteAccount")
let creditCard = document.getElementById("creditCard")
let createUser = document.getElementById("createUser")
let editUser = document.getElementById("editUser")
let deleteUser = document.getElementById("deleteUser")
let createATM = document.getElementById("createATM")
let deleteATM = document.getElementById("deleteATM")
let DashBoard = document.getElementById("DashBoard")
let CreateAdmin = document.getElementById("CreateAdmin")
let createAccountBTN = document.getElementById("createAccountBTN")
let editAccounBTN = document.getElementById("editAccountBTN")
let deleteAccountBTN = document.getElementById("deleteAccountBTN")
let creditCardBTN = document.getElementById("creditCardBTN")
let createUserBTN = document.getElementById("createUserBTN")
let editUserBTN = document.getElementById("editUserBTN")
let deleteUserBTN = document.getElementById("deleteUserBTN")
let createATMBTN = document.getElementById("createATMBTN")
let deleteATMBTN = document.getElementById("deleteATMBTN")
let DashBoardBTN = document.getElementById("DashBoardBTN")
let CreateAdminBTN = document.getElementById("CreateAdminBTN")
let screens = document.getElementsByClassName("screen")


menuBTN.addEventListener("click", () => {
    bodyTAG.classList.toggle("active")
    menuBTN.classList.toggle("fa-xmark")
})
/*
editAccounBTN?.addEventListener("click", (e) => {
    for (let i = 0; i < screens.length; i++) {
        screens[i].classList.add("d-none")
    }
    editAccount.classList.remove("d-none")
})

deleteAccountBTN?.addEventListener("click", (e) => {
    for (let i = 0; i < screens.length; i++) {
        screens[i].classList.add("d-none")
    }
    deleteAccount.classList.remove("d-none")
})

createAccountBTN?.addEventListener("click", (e) => {
    for (let i = 0; i < screens.length; i++) {
        screens[i].classList.add("d-none")
    }
    createAccount.classList.remove("d-none")
})

creditCardBTN?.addEventListener("click", (e) => {
    for (let i = 0; i < screens.length; i++) {
        screens[i].classList.add("d-none")
    }
    creditCard.classList.remove("d-none")
})

createUserBTN?.addEventListener("click", (e) => {
    for (let i = 0; i < screens.length; i++) {
        screens[i].classList.add("d-none")
    }
    createUser.classList.remove("d-none")
})

editUserBTN?.addEventListener("click", (e) => {
    for (let i = 0; i < screens.length; i++) {
        screens[i].classList.add("d-none")
    }
    editUser.classList.remove("d-none")
})

deleteUserBTN?.addEventListener("click", (e) => {
    for (let i = 0; i < screens.length; i++) {
        screens[i].classList.add("d-none")
    }
    deleteUser.classList.remove("d-none")
})

deleteATMBTN?.addEventListener("click", (e) => {
    for (let i = 0; i < screens.length; i++) {
        screens[i].classList.add("d-none")
    }
    deleteATM.classList.remove("d-none")
})

createATMBTN?.addEventListener("click", (e) => {
    for (let i = 0; i < screens.length; i++) {
        screens[i].classList.add("d-none")
    }
    createATM.classList.remove("d-none")
})

DashBoardBTN?.addEventListener("click", (e) => {
    for (let i = 0; i < screens.length; i++) {
        screens[i].classList.add("d-none")
    }
    DashBoard.classList.remove("d-none")
})

CreateAdminBTN?.addEventListener("click", (e) => {
    for (let i = 0; i < screens.length; i++) {
        screens[i].classList.add("d-none")
    }
    CreateAdmin.classList.remove("d-none")
})*/