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

            accordionBody.classList.toggle("expanded");
            accordionFooter.classList.toggle("hidden");
            accordion.classList.toggle("active");

            if (accordionBody.classList.contains("expanded")) {
                accordionBody.style.maxHeight = accordionBody.scrollHeight + "px";
            } else {
                accordionBody.style.maxHeight = "0";
            }
        }
    } catch (e) {}
}
