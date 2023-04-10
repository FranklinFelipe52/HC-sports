/*
  - o módulo tem a função de desabilitar botões com base em um checkbox condicional
  - em um checkbox, informe a propriedade data-conditional="<id do botão>"
  - no botão, é necessário passar a propriedade data-conditional-button
  - no botão, deve-se passar um id único que também deve ser informado no ponto anterior
*/

export default function initDisableButton() {
  const condicionalCheckboxList =
    document.querySelectorAll('[data-conditional]');

  const conditionalButtons = document.querySelectorAll(
    '[data-conditional-button]'
  );

  condicionalCheckboxList.forEach((checkbox) => {
    checkbox.addEventListener('click', handleCheckbox);

    if (!checkbox.checked) {
      const button = document.getElementById(checkbox.dataset.conditional);

      button.disabled = true;
    }
  });

  function handleCheckbox({ target }) {
    const button = document.getElementById(target.dataset.conditional);

    if (target.checked) {
      button.disabled = false;
    } else {
      button.disabled = true;
    }
  }
}
