<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Footer PTPN I</title>
    <style>
        /* Gaya footer sama seperti style.css di utama */
        body {
            margin: 0;
        }
        footer {
            background: #2c3e50;
            color: white;
            padding: 20px 10px;
            margin-top: 50px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .footer-container {
            max-width: 1200px;
            margin: auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
        }

        .footer-logo img {
            height: 50px;
            width: auto;
            object-fit: contain;
        }

        .footer-text {
            flex-grow: 1;
            text-align: center;
            font-size: 14px;
            color: #ddd;
        }

        /* Responsif untuk footer */
        @media (max-width: 600px) {
            .footer-container {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }
            .footer-text {
                order: 3;
            }
            .footer-logo {
                order: 1;
            }
        }
    </style>
</head>
<footer>
        <div class="footer-container">
            <div class="footer-logo">
                <img src="{{ Vite::asset('resources/images/ptpni.png') }}" alt="Logo PTPN I" />
            </div>
            <div class="footer-text">
                &copy; 2025 PTPN I Regional 3 Kebun Ngobo. All rights reserved.
            </div>
            <div class="footer-logo">
                <img src="{{ Vite::asset('resources/images/pn.png') }}" alt="Logo Perkebunan Nusantara" />
            </div>
        </div>
</footer>