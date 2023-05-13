const selectedAccountInput = document.querySelector('#selectedAccount');
const elements = document.querySelectorAll('#accountForm *');

elements.forEach((element) => {
  element.addEventListener('click', (e) => {
    const selectedAccount = e.currentTarget.getAttribute('data-value');
    selectedAccountInput.value = selectedAccount;
    document.querySelector('#accountForm').submit();
  });
});
