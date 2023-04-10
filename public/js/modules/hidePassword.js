export default function initHidePassword() {
    const hidePasswordButtons = document.querySelectorAll("[data-inputId]");

    hidePasswordButtons.forEach((hidePasswordButton) => {
        hidePasswordButton.addEventListener(
            "click",
            handleTogglePasswordVisibility
        );
    });

    function handleTogglePasswordVisibility(e) {
        e.currentTarget.classList.toggle("show");
        const inputPassword = document.getElementById(
            e.currentTarget.dataset.inputid
        );

        if (inputPassword.type === "password") {
            inputPassword.type = "text";
            inputPassword.focus();
        } else {
            inputPassword.type = "password";
            inputPassword.focus();
        }
    }
}
