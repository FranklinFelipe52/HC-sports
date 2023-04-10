export default function initCpfMask() {
    const cpfInputs = document.querySelectorAll('[data-mask="cpf"]');

    cpfInputs.forEach((cpf) => {
        cpf.addEventListener("input", handleInputChange);
        cpf.addEventListener("keydown", handleKeyDown);
    });

    function handleInputChange(e) {
        // remove all non-digits
        let inputValue = e.target.value.replace(/\D/g, "");
        inputValue = inputValue.substring(0, 11); // limit input to 11 characters
        const formattedValue = formatCPF(inputValue);
        e.target.value = formattedValue;
    }

    function handleKeyDown(e) {
        // allow only numbers, backspace, delete, arrow keys, and tab
        const allowedKeys = [
            "Backspace",
            "Delete",
            "ArrowLeft",
            "ArrowRight",
            "Tab",
        ];
        if (!/^\d$/.test(e.key) && !allowedKeys.includes(e.key)) {
            e.preventDefault();
        }
    }

    function formatCPF(cpf) {
        var cpfRegex = /^(\d{3})(\d{3})(\d{3})(\d{2})$/;
        return cpf.replace(cpfRegex, "$1.$2.$3-$4");
    }
}
