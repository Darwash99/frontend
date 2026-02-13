function showToast(message, type = 'danger', duration = 3000) {
    const toastElement = document.getElementById('liveToast');
    const toastMessage = document.getElementById('toastMessage');
    const toastTitle = document.getElementById('toastTitle');
    const toastIcon = document.getElementById('toastIcon');

    const types = {
        success: {
            class: 'toast-success',
            icon: 'bi bi-check-circle-fill text-success',
            title: 'Éxito'
        },
        danger: {
            class: 'toast-danger',
            icon: 'bi bi-x-circle-fill text-danger',
            title: 'Error'
        },
        warning: {
            class: 'toast-warning',
            icon: 'bi bi-exclamation-circle-fill text-warning',
            title: 'Advertencia'
        },
        info: {
            class: 'toast-info',
            icon: 'bi bi-info-circle-fill text-info',
            title: 'Información'
        }
    };

    const config = types[type] || types.danger;

    // Reset clases
    toastElement.className = 'toast shadow border-0';
    toastElement.classList.add(config.class);

    toastMessage.textContent = message;
    toastTitle.textContent = config.title;
    toastIcon.className = config.icon + " fs-4";

    const toast = new bootstrap.Toast(toastElement, {
        delay: duration
    });
    toast.show();
}