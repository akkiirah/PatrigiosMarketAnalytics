export function toggleFavoriteItem() {
    document.querySelectorAll('.item-pin').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            const itemId = this.id.split('-')[2];
            const formData = new FormData();
            formData.append('item_id', itemId);
            this.classList.toggle('active');

            fetch('/?controller=Item&action=toggleFavorite', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.textContent = data.message;
                    } else {
                        console.error('Fehler:', data.message);
                    }
                })
                .catch(error => console.error('Fehler:', error));
        });
    });

}