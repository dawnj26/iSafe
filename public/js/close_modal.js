const notifModal = document.querySelector('#notification-modal')
const appointmentModal = document.querySelector('#appointment-modal')
const openNotification = document.querySelector('#open-notification')
const openAppointment = document.querySelector('#open-appointment')
const closeAppointment = document.querySelector('#close-appointment')
const closeNotification = document.querySelector('#close-notification')

openNotification.addEventListener('click', () => {
    notifModal.classList.replace('hidden', 'grid')
})

closeNotification.addEventListener('click', () => {
    notifModal.classList.replace('grid', 'hidden')
})

openAppointment.addEventListener('click', () => {
    appointmentModal.classList.replace('hidden', 'grid')
})

closeAppointment.addEventListener('click', () => {
    appointmentModal.classList.replace('grid', 'hidden')
})