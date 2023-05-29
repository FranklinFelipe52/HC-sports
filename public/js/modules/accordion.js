export default function initAccordion() {
    try {
        const accordionsButtonArray = document.querySelectorAll(
            '[data-accordion="button"]'
        );

        accordionsButtonArray.forEach((button) => {
            button.addEventListener("click", handleAccordion);
        });

        function handleAccordion(e) {
            const accordion = document.getElementById(
                e.currentTarget.dataset.accordionId
            );

            const accordionBody = accordion.querySelector(
                '[data-accordion="body"]'
            );
            const accordionFooter = accordion.querySelector(
                '[data-accordion="footer"]'
            );

            accordionBody.classList.toggle("hidden");
            accordionFooter.classList.toggle("hidden");
            accordion.classList.toggle("active");
        }
    } catch (e) {}
}
