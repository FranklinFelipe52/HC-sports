export default function initModal() {
  const modalButtons = document.querySelectorAll('[data-modalId]');

  modalButtons.forEach((modalButton) => {
    if (modalButton.dataset.action === 'close') {
      modalButton.addEventListener('click', closeModal);
    } else if (modalButton.dataset.action === 'open') {
      modalButton.addEventListener('click', openModal);
    }
  });

  function closeModal({ currentTarget }) {
    const modal = document.getElementById(currentTarget.dataset.modalid);
    modal.classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
  }

  function openModal({ currentTarget }) {
    const modal = document.getElementById(currentTarget.dataset.modalid);
    modal.classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
  }
}
