export function loginRegister() {
    document.getElementById('loginForm').addEventListener('submit', function (event) {

        const formData = new FormData(this);

        fetch(this.action, {
            method: 'POST',
            body: formData
        })
            .then(response => response.text())
            .catch(error => console.error('Fehler:', error));
    });
}