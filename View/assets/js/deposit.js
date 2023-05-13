const depositForm = document.querySelector('#depositForm');
const amount = document.querySelector('#Amount');
const verifyingCashDiv = document.querySelector('.verifyingCash');

depositForm.addEventListener('submit', (e) => {//Waits 5 seconds before submitting form to show "veryfing cash"
    if(amount.value !== ''){

        e.preventDefault();
        verifyingCashDiv.style.display = 'block';
        document.querySelector('.loading').style.display = 'inline-block';
        setTimeout(() => {
            verifyingCashDiv.style.display = 'none';
            document.querySelector('.loading').style.display = 'none';
            
            //SWEET ALERTS//
            depositForm.submit();
        }, 3000); // 5 seconds
    }
});


amount.addEventListener('keydown', (event) => {
    // Allow: backspace, delete, tab, escape, enter and .
    if (event.key === 'Backspace' || event.key === 'Delete' || 
            event.key === 'Tab' || event.key === 'Escape' || 
            event.key === 'Enter' || (event.key === 'c' && event.ctrlKey === true) || 
            (event.key === 'v' && event.ctrlKey === true) ||
            (event.key === 'a' && event.ctrlKey === true) ||
            (event.key === 'z' && event.ctrlKey === true) ||
            (event.key === 'y' && event.ctrlKey === true)) {
            return;
    }

    // Allow only numeric keys
    if (!/[0-9]/.test(event.key)) {
        event.preventDefault();
    }
});