const amount = document.querySelectorAll('.input');

amount.forEach(el =>
    el.addEventListener('keydown', (event)=> {
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
    }
    ));