</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Pilih semua tautan kategori yang memiliki kelas 'category-link'
        const categoryLinks = document.querySelectorAll('.category-link');

        categoryLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault(); // Mencegah default aksi tautan
                const parentLi = link.parentElement; // Ambil elemen <li> induk
                parentLi.classList.toggle('open'); // Menambahkan / menghapus kelas 'open'
            });
        });
    });
</script>
<!-- Footer -->
<div class="footer">
    &copy; 2024 Berita.com. All Rights Reserved
</div>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js">
</script>

</body>

</html>