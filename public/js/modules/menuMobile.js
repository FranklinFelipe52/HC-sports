export default function initMenuMobile() {
    try {
        const toggleMenuButtons = document.querySelectorAll(
            '[data-button="toggle-menu"]'
        );

        toggleMenuButtons.forEach((button) => {
            button.addEventListener("click", handleToggleMenu);
        });

        function handleToggleMenu(e) {
            e.preventDefault();

            const menuId = e.currentTarget.dataset.menuid;

            const menu = document.getElementById(menuId);

            menu.classList.toggle("hidden");
        }

    } catch (e) {}
}
