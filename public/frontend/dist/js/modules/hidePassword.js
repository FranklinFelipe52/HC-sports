export default function initHidePassword() {
  const hidePasswordButtons = document.querySelectorAll('[data-inputId]');

  hidePasswordButtons.forEach((hidePasswordButton) => {
    hidePasswordButton.addEventListener(
      'click',
      handleTogglePasswordVisibility
    );
  });

  function handleTogglePasswordVisibility(e) {
    e.currentTarget.classList.toggle('show');
    const inputPassword = document.getElementById(
      e.currentTarget.dataset.inputid
    );
        
    if (inputPassword.type === 'password') {
      console.log('entrou 1')
      inputPassword.type = 'text';
      inputPassword.focus();
    } else {
      console.log('entrou 2')
      inputPassword.type = 'password';
      inputPassword.focus();
    }
  }
}
