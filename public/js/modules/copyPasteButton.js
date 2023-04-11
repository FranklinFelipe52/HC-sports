export default function initCopyPasteButton() {
  const copyPastebuttons = document.querySelectorAll('[data-copy="button"]');

  copyPastebuttons.forEach((copyPastebutton) => {
    copyPastebutton.addEventListener("click", handleCopy);
  });

  function handleCopy({ target }) {
    const codeToCopy = target.dataset.code;
    navigator.clipboard.writeText(codeToCopy).then(
      function () {
        console.log("Código copiado para a área de transferência");
      },
      function () {
        console.log("Erro ao copiar código para a área de transferência");
      }
    );
  }
}
