document.addEventListener('DOMContentLoaded', (event) => {
    const messageElement = document.getElementById('session-message');
    if (messageElement && messageElement.dataset.message) {
        alert(messageElement.dataset.message);
    }
});
