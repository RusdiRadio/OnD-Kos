function showDetails(kostName) {
    alert("Detail untuk " + kostName);
}

function loginUser() {
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    alert("Login berhasil untuk " + username);
    return false; // Mencegah pengiriman form
}

function searchKost() {
    const query = document.getElementById('search').value.toLowerCase();
    const kostCards = document.querySelectorAll('.kost-card');

    kostCards.forEach(card => {
        const kostName = card.getAttribute('data-name').toLowerCase();
        if (kostName.includes(query)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}

function filterKost() {
    const selectedType = document.getElementById('jenis-kamar').value;
    const kostCards = document.querySelectorAll('.kost-card');

    kostCards.forEach(card => {
        const kostType = card.getAttribute('data-type');
        if (selectedType === "" || kostType === selectedType) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}
window.addEventListener('DOMContentLoaded', () => {
    const sections = document.querySelectorAll('section');
    sections.forEach((section, index) => {
        // Menambahkan delay dinamis pada setiap section
        setTimeout(() => {
            section.classList.add('show');
        }, index * 200); // Menambah jeda 200ms untuk setiap section
    });
});
