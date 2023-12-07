const modal = document.querySelector('#notification-modal')
const openModal = document.querySelector('#open-modal')
const closeModal = document.querySelector('#close-modal')

openModal.addEventListener('click', () => {
    modal.classList.replace('hidden', 'grid')
})

closeModal.addEventListener('click', () => {
    modal.classList.replace('grid', 'hidden')
})