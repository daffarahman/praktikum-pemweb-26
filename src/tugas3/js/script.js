// Menunggu sampai seluruh struktur HTML selesai dimuat sebelum menjalankan script
document.addEventListener('DOMContentLoaded', () => {

    // Selector ke navbar untuk manual.html, gallery.html, dan parts.html memiliki navbar yang sama
    // dan DRY (Don't Repeat Yourself)
    const navbar = document.querySelector('header.navbar');
    if (navbar) {
        navbar.innerHTML = `
            <a href="index.html" class="brand">
                <img src="./img/dappa.png" alt="Logo" class="logo-image">
            </a>
            <div class="title-group">
                <h1 class="title-primary">Messerschmitt</h1>
                <h1 class="title-secondary">Bf 109 G-6</h1>
            </div>
        `;
    }

    // Link gambar dan caption untuk halaman parts.html
    const partsData = [
        { img: './img/parts/1.png', alt: 'Model part 1', caption: 'Part 01' },
        { img: './img/parts/2.png', alt: 'Model part 2', caption: 'Part 02' },
        { img: './img/parts/3.png', alt: 'Model part 3', caption: 'Part 03' },
        { img: './img/parts/4.png', alt: 'Model part 4', caption: 'Part 04' },
        { img: './img/parts/5.png', alt: 'Model part 5', caption: 'Part 05' },
        { img: './img/parts/6.png', alt: 'Model part 6', caption: 'Part 06' },
        { img: './img/parts/7.png', alt: 'Model part 7', caption: 'Part 07' }
    ];

    // Link gambar dan alt text untuk halaman gallery.html
    const galleryData = [
        { img: './img/gallery/1.jpg', alt: 'Final result of the model' },
        { img: './img/gallery/2.jpg', alt: 'The box and the finished model' },
        { img: './img/gallery/3.jpg', alt: 'Bottom side of the model' },
        { img: './img/gallery/4.jpg', alt: 'Propeller of the model' }
    ];

    // Link gambar manual untuk halaman manual.html
    const manualData = [
        { img: './img/manual/1.jpg', alt: 'Manual page 1' },
        { img: './img/manual/2.jpg', alt: 'Manual page 2' },
        { img: './img/manual/3.jpg', alt: 'Manual page 3' },
        { img: './img/manual/4.jpg', alt: 'Manual page 4' },
        { img: './img/manual/5.jpg', alt: 'Manual page 5' },
        { img: './img/manual/6.jpg', alt: 'Manual page 6' },
        { img: './img/manual/7.jpg', alt: 'Manual page 7' }
    ];


    // Menampilkan daftar bagian model kit di parts.html
    const partsContainer = document.querySelector('.parts-gallery');
    if (partsContainer) {
        // Kosongkan container
        partsContainer.innerHTML = '';

        // Untuk setiap data bagian tampilkan
        partsData.forEach(item => {
            const figure = document.createElement('figure');
            figure.className = 'part-card';

            const img = document.createElement('img');
            img.src = item.img;
            img.alt = item.alt;

            const figcaption = document.createElement('figcaption');
            figcaption.className = 'part-caption';
            figcaption.textContent = item.caption;

            // Append ke figure
            figure.appendChild(img);
            figure.appendChild(figcaption);
            partsContainer.appendChild(figure);
        });
    }

    // Menampilkan grid galeri foto model kit di gallery.html
    const galleryContainer = document.querySelector('.gallery-grid');
    if (galleryContainer) {
        // Kosongkan container
        galleryContainer.innerHTML = '';

        // Untuk setiap data gallery tampilkan gambar tersebut
        galleryData.forEach(item => {
            const figure = document.createElement('figure');
            figure.className = 'gallery-card';

            const img = document.createElement('img');
            img.src = item.img;
            img.alt = item.alt;

            // Append ke figure
            figure.appendChild(img);
            galleryContainer.appendChild(figure);
        });
    }

    // Menampilkan daftar halaman buku panduan di manual.html
    const manualContainer = document.querySelector('.manual-book');
    if (manualContainer) {
        // Kosongkan container
        manualContainer.innerHTML = '';

        // Untuk setiap data manual tampilkan
        manualData.forEach(item => {
            const figure = document.createElement('figure');
            figure.className = 'manual-page';

            const img = document.createElement('img');
            img.src = item.img;
            img.alt = item.alt;

            // Append ke figure
            figure.appendChild(img);
            manualContainer.appendChild(figure);
        });
    }
});
