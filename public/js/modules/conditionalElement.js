export default function initConditionalElement() {
    const pcd_checkbox = document.getElementById("pcd_modalities");
    const sub_category_box = document.getElementById("sub_categorys_id");
    const sub_categorys_select = document.getElementById(
        "cadastro_sub_category_field"
    );

    pcd_checkbox.addEventListener("click", handleToggleCheckbox);

    function handleToggleCheckbox({ currentTarget }) {
        if (currentTarget.checked) {
            sub_category_box.classList.remove("hidden");
            sub_categorys_select.required = true;
            console.log(sub_categorys_select.required);
        } else {
            sub_category_box.classList.add("hidden");
            sub_categorys_select.required = false;
            console.log(sub_categorys_select.required);
        }
    }
}
