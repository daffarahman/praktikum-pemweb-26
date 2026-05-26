// When the document is ready
$(document).ready(function () {

    // Tombol-tombol di kalkulator
    const calcButtons = [
        '7', '8', '9', '+',
        '4', '5', '6', '-',
        '1', '2', '3', '*',
        'C', '0', '=', '/'
    ];

    // Selector id untuk container tombol kalkulator
    const $btnContainer = $('#calc-buttons-container');

    // Untuk setiap tombol...
    calcButtons.forEach(function (btn) {
        // Tambahkan ke container dalam bentuk button
        $btnContainer.append(
            `<button class="calc-btn border border-black bg-white rounded-md hover:bg-black hover:text-white p-1 text-center cursor-pointer">${btn}</button>`
        );
    });


    // Onclick untuk selector class .menu-item
    $('.menu-item').on('click', function () {
        $('.menu-item').removeClass('font-bold');
        $(this).addClass('font-bold');

        // Melakukan GET, attribute dan text
        let targetApp = $(this).attr('data-target');
        let appName = $(this).text();

        $('.app-section').addClass('hidden');
        $('#' + targetApp).removeClass('hidden');
    });

    // Tombol save di aplikasi notes
    $('#save-note-btn').on('click', function () {
        // Mengambil isi dari #note-input
        let textInput = $('#note-input').val();

        // apabila tidak kosong maka
        if (textInput.trim() !== "") {
            // set isi text dari #note-output menjadi apa yang ada di inputan #note-input
            $('#note-output').text(textInput);
            // Kosongkan #note-input
            $('#note-input').val("");
        }
    });

    // Ekspresi perhitungan kalkulator
    let calcExpression = "";

    // Ketika salah satu tombol di kliik
    $(document).on('click', '.calc-btn', function () {
        let btnValue = $(this).text(); // GET nilai dari elemen tombol yang diklik

        // Tombol reset
        if (btnValue === 'C') {
            // Saat reset, hapus isi ekspresi dan set layar kalkulator ke 0
            calcExpression = "";
            $('#calc-screen').text("0");

            // Apabila diklik tombol "=" atau hasil
        } else if (btnValue === '=') {
            try {
                if (calcExpression !== "") {
                    // Hitung menggunakan JavaScript
                    let result = Function('"use strict";return (' + calcExpression + ')')();
                    // Kemudian SET hasil ke #calc-screen
                    $('#calc-screen').text(result);
                    calcExpression = result.toString();
                }
            } catch (e) {
                $('#calc-screen').text("Error");
                calcExpression = "";
            }
            // Jika tidak, tambahkan apapun yang diklik user ke dalam ekspresi
        } else {
            calcExpression += btnValue;
            $('#calc-screen').text(calcExpression);
        }
    });

    // MacPaint
    const canvas = $('#paint-canvas')[0];
    const ctx = canvas.getContext('2d');
    let isDrawing = false;

    // Setup garis yang akan digambar
    ctx.lineWidth = 2;
    ctx.lineCap = 'round';
    ctx.strokeStyle = '#000000';

    // Apabila user menekan mouse di area canvas, maka isDrawing = true dan set titik mulai penggambaran
    $('#paint-canvas').on('mousedown', function (e) {
        isDrawing = true;
        ctx.beginPath();
        ctx.moveTo(e.offsetX, e.offsetY);
    });

    // Kemudian saat mouse bergerak dan isDrawing, gambar garis dari titik start ke titik sekarang
    $('#paint-canvas').on('mousemove', function (e) {
        if (isDrawing) {
            ctx.lineTo(e.offsetX, e.offsetY);
            ctx.stroke();
        }
    });

    // Jika mouse tidak menekan di area canvas maka isDrawing = false
    $(window).on('mouseup', function () {
        isDrawing = false;
    });

    // Ketika tombol #clear-canvas diklik maka bersihkan canvas
    $('#clear-canvas').on('click', function () {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
    });
});