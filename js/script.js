function toggleSubmenu(event) {
  event.preventDefault(); // Mencegah reload halaman karena klik pada <a>
  const categoryItem = event.target.closest(".category"); // Cari elemen kategori
  const submenu = categoryItem.querySelector(".submenu"); // Ambil submenu di dalamnya

  // Toggle class 'show' pada submenu
  if (submenu) {
    submenu.classList.toggle("show");
  }
}

