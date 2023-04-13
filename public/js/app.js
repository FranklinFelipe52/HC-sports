import initHidePassword from "./modules/hidePassword.js";
import initModal from "./modules/modal.js";
import initCpfMask from "./modules/cpfMask.js";
import initCopyPasteButton from "./modules/copyPasteButton.js";
import initConditionalElement from "./modules/conditionalElement.js";

initHidePassword();
initModal();
initCpfMask();
initCopyPasteButton();
initConditionalElement();

// var sub_categorys = document.getElementById("sub_categorys_id");
// var select_sub_categorys = document.getElementById("select_sub_categorys_id");

// document.getElementById("pcd_modalities").addEventListener("click", (e) => {
//     sub_categorys.classList.toggle("d-none");
//     if (sub_categorys.classList.contains("d-none")) {
//         select_sub_categorys.setAttribute("required", false);
//     } else {
//         select_sub_categorys.setAttribute("required", true);
//     }
// });
