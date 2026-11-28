<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Glaciary</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link
        rel="stylesheet"
        href="https://cdn.datatables.net/1.13.11/css/jquery.dataTables.min.css">

    <style>
        @font-face {
            font-family: 'Surgena';
            src:
                url('{{ asset('fonts/Surgena.woff2') }}') format('woff2'),
                url('{{ asset('fonts/Surgena.ttf') }}') format('truetype'),
                url('{{ asset('fonts/Surgena-SemiBold.ttf') }}') format('truetype');
            font-weight: 400 700;
            font-style: normal;
            font-display: swap;
        }

        :root {
            --hero-bg-image: url('{{ asset('images/hero-library.jpg') }}');
            --split-bg-image: url('{{ asset('images/Form.jpg') }}');
            --font-surgena: 'Surgena', 'Segoe UI', Arial, sans-serif;
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        html.no-smooth-scroll {
            scroll-behavior: auto;
        }

        body {
            margin: 0;
            background:
                radial-gradient(circle at 18% 12%, rgba(37, 99, 235, 0.24), transparent 45%),
                radial-gradient(circle at 82% 28%, rgba(29, 78, 216, 0.18), transparent 48%),
                #050811;
            font-family: var(--font-surgena);
            color: #eef4ff;
            overflow-x: hidden;
        }

        /* =====================================================
           GLASSMORPHISM PILL NAVBAR (VAULT BLUE PALETTE)
        ====================================================== */
        .glass-nav-wrap {
            position: fixed;
            top: 18px;
            left: 0;
            right: 0;
            z-index: 1050;
            padding: 0 16px;
        }

        .glass-navbar {
            max-width: 1180px;
            margin: 0 auto;
            padding: 10px 14px 10px 24px;
            border-radius: 999px;
            background: rgba(13, 20, 38, 0.68);
            backdrop-filter: blur(18px) saturate(160%);
            -webkit-backdrop-filter: blur(18px) saturate(160%);
            border: 1px solid rgba(147, 197, 253, 0.22);
            box-shadow: 0 12px 34px rgba(2, 6, 18, 0.55);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
        }

        .glass-brand {
            color: #ffffff;
            font-family: var(--font-surgena);
            font-weight: 800;
            font-size: 18px;
            letter-spacing: .3px;
            text-decoration: none;
            white-space: nowrap;
        }

        .glass-brand:hover {
            color: #93c5fd;
        }

        .glass-links {
            display: none;
            align-items: center;
            gap: 22px;
        }

        @media (min-width: 768px) {
            .glass-links {
                display: flex;
            }
        }

        .glass-links a,
        .glass-links button.nav-link-btn {
            appearance: none;
            background: transparent;
            border: 0;
            padding: 0;
            color: rgba(226, 238, 255, 0.82);
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: color .2s ease;
        }

        .glass-links a:hover,
        .glass-links button.nav-link-btn:hover {
            color: #ffffff;
        }

        .glass-links .badge.text-bg-info {
            background-color: #2563eb !important;
            color: #ffffff !important;
        }

        .nav-right-group {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .glass-user-pill {
            appearance: none;
            background: rgba(37, 99, 235, 0.20);
            color: #dbeafe;
            font-size: 12.5px;
            font-weight: 700;
            padding: 8px 14px;
            border-radius: 999px;
            border: 1px solid rgba(96, 165, 250, 0.36);
            cursor: pointer;
            white-space: nowrap;
            transition: background .2s ease, border-color .2s ease;
        }

        .glass-user-pill:hover {
            background: rgba(37, 99, 235, 0.36);
            border-color: rgba(147, 197, 253, 0.6);
            color: #ffffff;
        }

        .glass-cta {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: #ffffff;
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 700;
            padding: 9px 18px;
            border-radius: 999px;
            border: 1px solid rgba(147, 197, 253, 0.32);
            box-shadow: 0 6px 18px rgba(37, 99, 235, 0.32);
            white-space: nowrap;
            transition: transform .2s ease, filter .2s ease;
        }

        .glass-cta:hover {
            filter: brightness(1.08);
            color: #ffffff;
            transform: translateY(-1px);
        }

        /* =====================================================
           FULL-SCREEN LANDING HERO (100VH) + QUICK ACCESS GENRE
        ====================================================== */
        .cinema-hero {
            position: relative;
            min-height: 100vh;
            min-height: 100dvh;
            width: 100%;
            background-image: var(--hero-bg-image);
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 112px 0 36px;
            color: #ffffff;
        }

        .cinema-hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(6, 11, 24, 0.62);
            z-index: 1;
        }

        .cinema-hero-inner {
            position: relative;
            z-index: 2;
            max-width: 1240px;
            margin: 0 auto;
            padding: 0 24px;
            width: 100%;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .hero-left-block {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            width: 100%;
            max-width: none;
            margin-bottom: 24px;
        }

        .hero-main-title {
            font-family: var(--font-surgena);
            font-size: clamp(2.8rem, 6.5vw, 5.2rem);
            font-weight: 400;
            line-height: 1.08;
            letter-spacing: 0.04em;
            margin: 0;
            color: #ffffff;
            text-shadow: 0 6px 28px rgba(37, 99, 235, 0.32);
        }

        .hero-subcaption {
            margin: 10px 0 0;
            max-width: 480px;
            font-size: 13px;
            line-height: 1.5;
            letter-spacing: 0.02em;
            color: rgba(219, 234, 254, 0.84);
        }

        .quick-genre-label {
            font-size: 13px;
            font-weight: 700;
            letter-spacing: .4px;
            color: rgba(219, 234, 254, 0.90);
            margin-bottom: 10px;
        }

        .genre-tiles-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 12px;
        }

        .genre-tile {
            appearance: none;
            background: rgba(13, 21, 42, 0.56);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1px solid rgba(147, 197, 253, 0.24);
            box-shadow: 0 8px 22px rgba(2, 6, 18, 0.35);
            color: #e2eeff;
            border-radius: 12px;
            padding: 14px 16px;
            min-height: 68px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            font-weight: 700;
            font-size: 14px;
            letter-spacing: .3px;
            cursor: pointer;
            transition: transform .18s ease, background .18s ease, border-color .18s ease, color .18s ease;
        }

        .genre-tile:hover {
            transform: translateY(-2px);
            background: rgba(37, 99, 235, 0.24);
            border-color: rgba(147, 197, 253, 0.50);
            color: #ffffff;
        }

        .genre-tile.active {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: #ffffff;
            border-color: rgba(191, 219, 254, 0.75);
            box-shadow: 0 10px 26px rgba(37, 99, 235, 0.42);
        }

        /* =====================================================
           API BOOK GALLERY CARDS (TOMBOL PINJAM TUNGGAL)
        ====================================================== */
        .api-showcase-band {
            position: relative;
            background:
                radial-gradient(circle at 14% 18%, rgba(37, 99, 235, 0.20), transparent 44%),
                radial-gradient(circle at 86% 26%, rgba(59, 130, 246, 0.14), transparent 46%),
                #070c18;
            padding: 48px 0;
            border-top: 1px solid rgba(147, 197, 253, 0.14);
            border-bottom: 1px solid rgba(147, 197, 253, 0.14);
        }

        .api-showcase-band h2.text-white,
        .api-showcase-band .text-white {
            color: #ffffff !important;
        }

        .api-showcase-band .text-secondary {
            color: #93a7c8 !important;
        }

        .api-showcase-band .badge.text-bg-primary {
            background-color: rgba(37, 99, 235, 0.24) !important;
            color: #93c5fd !important;
            border: 1px solid rgba(96, 165, 250, 0.36);
        }

        .api-showcase-band #activeGenreLabel.text-info {
            color: #60a5fa !important;
        }

        .api-showcase-band #apiSearchInput.bg-dark.text-white {
            background-color: rgba(14, 23, 45, 0.78) !important;
            backdrop-filter: blur(12px);
            color: #ffffff !important;
            border-color: rgba(147, 197, 253, 0.25) !important;
        }

        .api-showcase-band #apiSearchInput::placeholder {
            color: #7b90b2;
        }

        .showcase-card {
            background: rgba(14, 23, 45, 0.66);
            backdrop-filter: blur(16px) saturate(145%);
            -webkit-backdrop-filter: blur(16px) saturate(145%);
            border-radius: 18px;
            padding: 10px 10px 12px;
            box-shadow: 0 12px 28px rgba(2, 6, 18, 0.48);
            border: 1px solid rgba(147, 197, 253, 0.18);
            display: flex;
            flex-direction: column;
            height: 100%;
            transition: transform .22s ease, box-shadow .22s ease, background .22s ease, border-color .22s ease;
        }

        .showcase-card:hover {
            transform: translateY(-5px);
            background: rgba(20, 33, 64, 0.84);
            border-color: rgba(96, 165, 250, 0.45);
            box-shadow: 0 18px 34px rgba(15, 23, 42, 0.65);
        }

        .showcase-card-top {
            font-size: 9px;
            font-weight: 800;
            letter-spacing: 1.1px;
            text-transform: uppercase;
            color: #8da4c7;
            text-align: center;
            margin-bottom: 7px;
        }

        .showcase-cover-wrap {
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            aspect-ratio: 3 / 3.8;
            background: rgba(10, 17, 34, 0.88);
            margin-bottom: 9px;
            box-shadow: 0 6px 14px rgba(2, 6, 18, 0.45);
        }

        .showcase-cover-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .showcase-badge-pill {
            position: absolute;
            bottom: 7px;
            right: 7px;
            background: rgba(37, 99, 235, 0.90);
            backdrop-filter: blur(6px);
            color: #ffffff;
            font-size: 9.5px;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 999px;
            border: 1px solid rgba(191, 219, 254, 0.35);
            box-shadow: 0 3px 8px rgba(2, 6, 18, 0.40);
        }

        .showcase-book-title {
            font-size: 12.5px;
            font-weight: 800;
            color: #f8fafc;
            text-align: center;
            line-height: 1.28;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            min-height: 32px;
        }

        .showcase-book-stars {
            color: #60a5fa;
            font-size: 10.5px;
            text-align: center;
            letter-spacing: 1px;
            margin: 3px 0 4px;
        }

        .showcase-book-desc {
            font-size: 10.5px;
            line-height: 1.38;
            color: #93a7c8;
            text-align: center;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            margin-bottom: 8px;
            flex-grow: 1;
        }

        .showcase-card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 6px;
            padding-top: 7px;
            border-top: 1px solid rgba(147, 197, 253, 0.14);
        }

        .showcase-isbn-text {
            font-size: 10px;
            color: #93a7c8;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .btn-pinjam-card {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: #ffffff;
            border: none;
            font-size: 11px;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 999px;
            white-space: nowrap;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.30);
            transition: background .18s ease, color .18s ease, filter .18s ease;
        }

        .btn-pinjam-card:hover {
            filter: brightness(1.10);
            color: #ffffff;
        }

        /* =====================================================
           SPLIT-SCREEN ELEGANT FORM (VAULT BLUE GLASS)
        ====================================================== */
        .split-borrow-card {
            display: grid;
            grid-template-columns: 1fr;
            min-height: 620px;
            border-radius: 26px;
            overflow: hidden;
            background: rgba(12, 20, 38, 0.84);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border: 1px solid rgba(147, 197, 253, 0.20);
            box-shadow: 0 24px 60px rgba(2, 6, 18, 0.58);
        }

        @media (min-width: 992px) {
            .split-borrow-card {
                grid-template-columns: 0.92fr 1.08fr;
                min-height: 660px;
            }
        }

        .split-visual-pane {
            position: relative;
            min-height: 300px;
            padding: 36px 34px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow: hidden;
            background:
                linear-gradient(155deg, rgba(12, 24, 52, 0.72) 0%, rgba(7, 14, 29, 0.80) 100%),
                var(--split-bg-image) center / cover no-repeat;
            border-bottom: 1px solid rgba(147, 197, 253, 0.14);
        }

        @media (min-width: 992px) {
            .split-visual-pane {
                border-bottom: 0;
                border-right: 1px solid rgba(147, 197, 253, 0.14);
            }
        }

        .split-brand-mark {
            font-family: var(--font-surgena);
            font-size: 22px;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: -.3px;
        }

        .split-visual-pane .text-info {
            color: #93c5fd !important;
        }

        .split-form-pane {
            padding: 34px 30px 38px;
            background: rgba(9, 15, 30, 0.90);
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        @media (min-width: 768px) {
            .split-form-pane {
                padding: 40px 44px;
            }
        }

        .split-form-pane .text-info {
            color: #60a5fa !important;
        }

        .pill-switcher {
            position: relative;
            display: inline-grid;
            grid-template-columns: repeat(2, minmax(92px, 1fr));
            align-items: center;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(147, 197, 253, 0.18);
            border-radius: 999px;
            padding: 4px;
            gap: 0;
            user-select: none;
        }

        .pill-switch-thumb {
            position: absolute;
            top: 4px;
            left: 4px;
            width: calc(50% - 4px);
            height: calc(100% - 8px);
            border-radius: 999px;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.38);
            transform: translateX(0%);
            transition: transform .32s cubic-bezier(.22, 1, .36, 1);
            pointer-events: none;
            z-index: 0;
        }

        .pill-switcher[data-active-tab="bukusaya"] .pill-switch-thumb {
            transform: translateX(100%);
        }

        .pill-switch-btn {
            position: relative;
            z-index: 1;
            appearance: none;
            border: 0;
            background: transparent;
            color: #9fb4d4;
            font-size: 13px;
            font-weight: 700;
            padding: 7px 18px;
            border-radius: 999px;
            cursor: pointer;
            white-space: nowrap;
            transition: color .26s ease, transform .18s ease;
        }

        .pill-switch-btn:hover {
            color: #e2eeff;
        }

        .pill-switch-btn.active {
            color: #ffffff;
        }

        .split-views-stage {
            position: relative;
            flex: 1;
            display: grid;
            align-items: start;
        }

        .split-view-pane {
            grid-area: 1 / 1;
            width: 100%;
            opacity: 0;
            transform: translateY(10px);
            visibility: hidden;
            pointer-events: none;
            transition: opacity .30s ease, transform .34s cubic-bezier(.22, 1, .36, 1), visibility 0s linear .30s;
        }

        .split-view-pane.is-active {
            opacity: 1;
            transform: translateY(0);
            visibility: visible;
            pointer-events: auto;
            transition: opacity .30s ease .06s, transform .34s cubic-bezier(.22, 1, .36, 1) .06s, visibility 0s linear 0s;
        }

        .elegant-label {
            font-size: 13px;
            font-weight: 700;
            color: #e2eeff;
            margin-bottom: 6px;
        }

        .elegant-input,
        .elegant-select {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(147, 197, 253, 0.20);
            color: #ffffff;
            border-radius: 12px;
            padding: 11px 14px;
            font-size: 14px;
        }

        .elegant-input:focus,
        .elegant-select:focus {
            background: rgba(37, 99, 235, 0.10);
            border-color: #60a5fa;
            color: #ffffff;
            box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.24);
        }

        .elegant-input::placeholder {
            color: #6e85a8;
        }

        .elegant-select option {
            background: #0d152a;
            color: #ffffff;
        }

        .btn-purple-submit {
            background: linear-gradient(90deg, #2563eb 0%, #3b82f6 100%);
            color: #ffffff;
            border: none;
            border-radius: 12px;
            font-weight: 700;
            font-size: 15px;
            padding: 12px 24px;
            box-shadow: 0 8px 22px rgba(37, 99, 235, 0.34);
            transition: transform .18s ease, filter .18s ease;
        }

        .btn-purple-submit:hover {
            filter: brightness(1.08);
            color: #ffffff;
            transform: translateY(-1px);
        }

        .btn-blue {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: #ffffff;
            border: none;
            font-weight: 700;
        }

        .btn-blue:hover {
            filter: brightness(1.08);
            color: #ffffff;
        }

        .table {
            --bs-table-bg: transparent;
            --bs-table-color: #e2eeff;
            --bs-table-hover-bg: rgba(59, 130, 246, 0.10);
            --bs-table-hover-color: #ffffff;
            --bs-table-border-color: rgba(147, 197, 253, 0.16);
        }

        .table thead th {
            background: rgba(20, 34, 66, 0.88);
            color: #93c5fd;
            padding: 12px 14px;
            white-space: nowrap;
            border-bottom: 1px solid rgba(147, 197, 253, 0.24);
        }

        .modal-content.dark-glass-modal {
            background: rgba(12, 20, 38, 0.94);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            color: #ffffff;
            border: 1px solid rgba(147, 197, 253, 0.24);
        }

        .modal-content.dark-glass-modal .btn-close {
            filter: invert(1) grayscale(100%) brightness(200%);
        }

        footer {
            color: #7d92b4;
            font-size: 13px;
            padding: 28px 0;
        } 
        /*==================================================
        CUSTOM DATATABLES - TEMA GLACIARY
        ====================================================*/

        /* Dropdown "entries per page" */
        .dataTables_length select {
            background: #0b1730 !important;
            color: #ffffff !important;
            border: 1px solid rgb(105, 240, 255) !important;
            border-radius: 8px !important;
            padding: 4px 28px 4px 8px !important;
            outline: none !important;
        }

        /* Tulisan "entries per page" */
        .dataTables_length {
            color: #ffffff !important;
            font-size: 13px !important;
        }

        /* Informasi "Showing 1 to 10 of 12 entries" */
        .dataTables_info {
            color: #ffffff !important;
            font-weight: 500;
            padding-top: 12px !important;
            padding-right: 30px !important;
        }

        /* Container pagination */
        .dataTables_paginate {
            padding-top: 8px !important;
            margin-top: 5px !important;
        }

        /* Semua tombol pagination */
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            background: #0b1730 !important;
            color: #93c5fd !important;
            border: 1px solid rgb(96, 223, 255) !important;
            border-radius: 6px !important;
            margin-left: 3px !important;
            padding: 5px 10px !important;
            transition: all 0.2s ease;
        }

        /* Hover */
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #1d4ed8 !important;
            color: #ffffff !important;
            border-color: #60a5fa !important;
        }

        /* Tombol halaman aktif */
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: linear-gradient(135deg, #2563eb, #3b82f6) !important;
            color: #ffffff !important;
            border-color: #60a5fa !important;
        }

        /* Hover pada halaman aktif */
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background: #2563eb !important;
            color: #ffffff !important;
        }

        /* Tombol disabled (Previous/Next saat tidak tersedia) */
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover {
            background: #071225 !important;
            color: #526987 !important;
            border-color: rgba(147, 197, 253, 0.12) !important;
            cursor: default !important;
        }
        /* =====================================================
        DATATABLES - TEMA GLACIARY
        ===================================================== */

        /* Tulisan "entries per page" */
        #bukuSayaTable_wrapper .dataTables_length {
            color: #93c5fd !important;
            font-size: 13px !important;
            margin-bottom: 10px !important;
        }

        /* Dropdown jumlah data */
        #bukuSayaTable_wrapper .dataTables_length select {
            background: #0d152a !important;
            color: #ffffff !important;
            border: 1px solid rgba(147, 197, 253, 0.35) !important;
            border-radius: 999px !important;
            padding: 5px 28px 5px 10px !important;
            margin: 0 4px !important;
            outline: none !important;
            box-shadow: none !important;
        }

        /* Saat dropdown dipilih */
        #bukuSayaTable_wrapper .dataTables_length select:focus {
            border-color: #60a5fa !important;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.20) !important;
        }

        /* Informasi data */
        #bukuSayaTable_wrapper .dataTables_info {
            color: #8da4c7 !important;
            font-size: 12px !important;
            padding-top: 12px !important;
        }

        /* Area pagination */
        #bukuSayaTable_wrapper .dataTables_paginate {
            padding-top: 8px !important;
        }

        /* Semua tombol pagination */
        #bukuSayaTable_wrapper .dataTables_paginate .paginate_button {
            background: #0d152a !important;
            background-image: none !important;
            color: #93c5fd !important;

            border: 1px solid rgba(147, 197, 253, 0.25) !important;
            border-radius: 999px !important;

            padding: 5px 10px !important;
            margin-left: 4px !important;

            box-shadow: none !important;
            text-shadow: none !important;

            transition: all 0.2s ease !important;
        }

        /* Hover */
        #bukuSayaTable_wrapper .dataTables_paginate .paginate_button:hover {
            background: linear-gradient(135deg, #3b82f6, #2563eb) !important;
            background-image: none !important;
            color: #ffffff !important;

            border-color: rgba(147, 197, 253, 0.65) !important;
        }

        /* Halaman aktif */
        #bukuSayaTable_wrapper .dataTables_paginate .paginate_button.current {
            background: linear-gradient(135deg, #3b82f6, #2563eb) !important;
            background-image: none !important;
            color: #ffffff !important;

            border-color: rgba(191, 219, 254, 0.75) !important;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25) !important;
        }

        /* Hover halaman aktif */
        #bukuSayaTable_wrapper .dataTables_paginate .paginate_button.current:hover {
            background: #2563eb !important;
            color: #ffffff !important;
        }

        /* Tombol disabled */
        #bukuSayaTable_wrapper .dataTables_paginate .paginate_button.disabled,
        #bukuSayaTable_wrapper .dataTables_paginate .paginate_button.disabled:hover {
            background: rgba(13, 21, 42, 0.60) !important;
            background-image: none !important;
            color: #526987 !important;

            border-color: rgba(147, 197, 253, 0.12) !important;

            box-shadow: none !important;
        }
        
        /* =====================================================
        DATATABLES SEARCH - TEMA GLACIARY
        ===================================================== */

        #bukuSayaTable_wrapper .dataTables_filter {
            color: #93c5fd !important;
            margin-bottom: 10px;
        }

        #bukuSayaTable_wrapper .dataTables_filter label {
            color: #93c5fd !important;
            font-weight: 600;
            font-size: 13px;
        }

        #bukuSayaTable_wrapper .dataTables_filter input {
            background: #0b1730 !important;
            color: #ffffff !important;
            border: 1px solid #334d73 !important;
            border-radius: 999px !important;
            padding: 7px 14px !important;
            margin-left: 8px !important;
            outline: none !important;
            box-shadow: none !important;
        }

        #bukuSayaTable_wrapper .dataTables_filter input:focus {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.18) !important;
        }

        #bukuSayaTable_wrapper .dataTables_filter input::placeholder {
            color: #7186a6 !important;
        }
        /* =====================================================
        DATATABLES MANAGEMENT SYSTEM - GLACIARY
        ===================================================== */

        /* SHOW ENTRIES */
        #databasePeminjamanTable_wrapper .dataTables_length {
            color: #ffffff !important;
            font-size: 13px !important;
            margin-bottom: 15px !important;
        }

        #databasePeminjamanTable_wrapper .dataTables_length label {
            color: #ffffff !important;
        }

        #databasePeminjamanTable_wrapper .dataTables_length select {
            background-color: #0b1730 !important;
            color: #ffffff !important;
            border: 1px solid #60a5fa !important;
            border-radius: 8px !important;
            padding: 5px 28px 5px 10px !important;
            margin: 0 6px !important;
        }

        /* INFO DATA */
        #databasePeminjamanTable_wrapper .dataTables_info {
            color: #ffffff !important;
            font-size: 13px !important;
            padding-top: 10px !important;
            margin-right: 40px !important;
        }

        /* PAGINATION */
        #databasePeminjamanTable_wrapper .dataTables_paginate {
            margin-top: 5px !important;
            padding-top: 0 !important;
        }

        /* Jarak antara info dan pagination */
        #databasePeminjamanTable_wrapper .dataTables_info {
            float: left !important;
        }

        #databasePeminjamanTable_wrapper .dataTables_paginate {
            float: right !important;
        }

        /* Membersihkan float */
        #databasePeminjamanTable_wrapper::after {
            content: "";
            display: block;
            clear: both;
        }
        /* Tulisan "Show _MENU_ entries" pada semua tabel DataTables & #databasePeminjamanTable */
.dataTables_wrapper .dataTables_length,
.dataTables_wrapper .dataTables_length label,
#databasePeminjamanTable_wrapper .dataTables_length,
#databasePeminjamanTable_wrapper .dataTables_length label {
    color: #ffffff !important;
    font-size: 13px !important;
    font-weight: 500;
}

/* Dropdown jumlah entries */
.dataTables_wrapper .dataTables_length select,
#databasePeminjamanTable_wrapper .dataTables_length select {
    background-color: #0b1730 !important;
    color: #ffffff !important;
    border: 1px solid #60a5fa !important;
    border-radius: 8px !important;
    padding: 5px 28px 5px 10px !important;
    margin: 0 6px !important;
    outline: none !important;
}

/* Informasi "Showing 1 to 10 of ... entries" */
.dataTables_wrapper .dataTables_info,
#databasePeminjamanTable_wrapper .dataTables_info {
    color: #ffffff !important;
    font-size: 13px !important;
    font-weight: 500;
    padding-top: 12px !important;
    margin-right: 36px !important; /* Jarak aman ke sisi kanan / pagination */
}

/* Jarak antara teks info dan tombol < 1 | 2 > */
.dataTables_wrapper .dataTables_paginate,
#databasePeminjamanTable_wrapper .dataTables_paginate {
    padding-top: 8px !important;
    margin-top: 6px !important;
    margin-left: 24px !important; /* Tambahan jarak horizontal dari teks info */
}

/* Jika ingin teks info & pagination sejajar rapi di bawah tabel */
.dataTables_wrapper .dataTables_info {
    float: left !important;
}

.dataTables_wrapper .dataTables_paginate {
    float: right !important;
}

.dataTables_wrapper::after {
    content: "";
    display: block;
    clear: both;
}
    </style>
</head>

<body>

    @php
        $currentGmail = $userGmail ?? session('user_gmail');
        $currentName  = $userName ?? session('user_name') ?? '';
        $loansList    = $myLoans ?? collect();
    @endphp

    <!-- =====================================================
         GLASSMORPHISM PILL NAVBAR
    ====================================================== -->
    <div class="glass-nav-wrap">
        <nav class="glass-navbar">
            <a href="{{ route('booklibrary.index') }}" class="glass-brand">
                Glaciary
            </a>

            <div class="glass-links">
                <a href="#api-genre-gallery">Galeri</a>
                <a href="#form-peminjaman">Pinjam Buku</a>
                <button type="button" class="nav-link-btn" id="openMyLoansNavBtn">
                    Buku Saya
                    <span class="badge text-bg-info text-dark ms-1">
                        {{ $loansList->where('status', 'Dipinjam')->count() }}
                    </span>
                </button>
            </div>

            <div class="nav-right-group">
                @if($currentGmail)
                    <button type="button" class="glass-user-pill" data-bs-toggle="modal" data-bs-target="#gmailLoginModal" title="Kelola Akun Gmail">
                        {{ $currentGmail }}
                    </button>
                @else
                    <button type="button" class="glass-user-pill" data-bs-toggle="modal" data-bs-target="#gmailLoginModal">
                        Login Gmail
                    </button>
                @endif

                <a href="{{ route('booklibrary.manage') }}" class="glass-cta">
                    Management System ↗
                </a>
            </div>
        </nav>
    </div>


    <!-- =====================================================
         FULL-SCREEN LANDING HERO (100VH) + QUICK ACCESS GENRE
    ====================================================== -->
    <header class="cinema-hero">
        <div class="cinema-hero-inner">
            <div class="hero-left-block">
                <h1 class="hero-main-title">GLACIARY</h1>
                <p class="hero-subcaption">
                    Jelajahi koleksi buku lintas genre dan ajukan peminjaman dengan cepat.
                </p>
            </div>

            <div>
                <div class="quick-genre-label">Jelajahi Berdasarkan Genre</div>
                <div class="genre-tiles-row" id="genreQuickAccess">
                    <button type="button" class="genre-tile active" data-genre="all">
                        Semua Genre
                    </button>
                    <button type="button" class="genre-tile" data-genre="Fiction">
                        Fiction
                    </button>
                    <button type="button" class="genre-tile" data-genre="Science">
                        Science
                    </button>
                    <button type="button" class="genre-tile" data-genre="History">
                        History
                    </button>
                    <button type="button" class="genre-tile" data-genre="Technology">
                        Technology
                    </button>
                    <button type="button" class="genre-tile" data-genre="Business">
                        Business
                    </button>
                </div>
            </div>
        </div>
    </header>


    <!-- =====================================================
         API BOOK GALLERY (TOMBOL PINJAM TUNGGAL)
    ====================================================== -->
    <section class="api-showcase-band" id="api-genre-gallery">
        <div class="container">
            <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
                <div>
                    <span class="badge text-bg-primary mb-2">OPEN LIBRARY API</span>
                    <h2 class="fw-bold text-white mb-1">
                        Galeri Buku Pilihan <span id="activeGenreLabel" class="text-info">· Semua Genre</span>
                    </h2>
                    <p class="text-secondary mb-0">
                        Klik tombol <strong>Pinjam</strong> pada kartu buku untuk langsung mengisi formulir peminjaman.
                    </p>
                </div>

                <div class="d-flex gap-2" style="min-width: 280px;">
                    <input
                        type="text"
                        id="apiSearchInput"
                        class="form-control rounded-pill px-3 bg-dark text-white border-secondary"
                        placeholder="Cari judul, pengarang, atau ISBN...">
                    <button type="button" id="apiSearchBtn" class="btn btn-blue rounded-pill px-4 text-nowrap">
                        Cari
                    </button>
                </div>
            </div>

            <div id="apiSearchStatus" class="small text-secondary mb-3">
                Memuat galeri buku dari API...
            </div>

            <div id="apiSearchResults" class="row g-3"></div>
        </div>
    </section>


    <!-- =====================================================
         MAIN PUBLIC AREA: SPLIT-SCREEN FORM PEMINJAMAN & BUKU SAYA
    ====================================================== -->
    <main class="container py-5" id="form-peminjaman">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger mb-4">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="split-borrow-card">
            <!-- SISI KIRI: VISUAL BRANDING ELEGAN -->
            <div class="split-visual-pane">
                <div class="split-brand-mark">
                    Glaciary
                </div>

                @if(!$currentGmail)
                    <div class="my-auto">
                        <div class="p-3 rounded-4" style="background: rgba(255,255,255,0.07); border: 1px solid rgba(147,197,253,0.22);">
                            <div class="small text-warning fw-semibold mb-1">Belum Login Gmail</div>
                            <p class="small text-light opacity-75 mb-2">
                                Masuk terlebih dahulu menggunakan akun Gmail Anda agar peminjaman tercatat sesuai akun Anda.
                            </p>
                            <button type="button" class="btn btn-sm btn-light fw-bold rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#gmailLoginModal">
                                Login dengan Gmail
                            </button>
                        </div>
                    </div>
                @else
                    <div class="my-auto"></div>
                @endif

                <div></div>
            </div>

            <!-- SISI KANAN: FORM & BUKU SAYA (SWITCHER) -->
            <div class="split-form-pane">
                <div class="d-flex justify-content-end mb-4">
                    <div class="pill-switcher" id="splitPillSwitcher" data-active-tab="form">
                        <span class="pill-switch-thumb" aria-hidden="true"></span>
                        <button type="button" class="pill-switch-btn active" id="tabFormBtn">
                            Form
                        </button>
                        <button type="button" class="pill-switch-btn" id="tabBukuSayaBtn">
                            Buku Saya
                        </button>
                    </div>
                </div>

                <div class="split-views-stage">
                    <!-- VIEW 1: FORM PEMINJAMAN -->
                    <div id="paneFormView" class="split-view-pane is-active">
                        <h3 class="fw-bold text-white mb-4">Peminjaman Buku</h3>

                        <form id="borrowDbForm" action="{{ route('booklibrary.borrow.store') }}" method="POST" class="row g-3 keep-scroll-form">
                            @csrf
                            <input type="hidden" name="isbn" id="hiddenBookIsbn">
                            <input type="hidden" name="pengarang" id="hiddenBookAuthor">
                            <input type="hidden" name="penerbit" id="hiddenBookPublisher">
                            <input type="hidden" name="tahun_terbit" id="hiddenBookYear">
                            <input type="hidden" name="cover_url" id="hiddenBookCover">

                            <div class="col-12">
                                <label for="borrowerNameInput" class="form-label elegant-label">Nama Lengkap :</label>
                                <input
                                    type="text"
                                    id="borrowerNameInput"
                                    name="nama_peminjam"
                                    class="form-control elegant-input"
                                    value="{{ old('nama_peminjam', $currentName) }}"
                                    placeholder="Masukkan Nama Lengkap"
                                    required>
                            </div>

                            <div class="col-12">
                                <label for="borrowBookTitleInput" class="form-label elegant-label">Nama Buku yang Dipinjam :</label>
                                <input
                                    type="text"
                                    id="borrowBookTitleInput"
                                    name="judul_buku"
                                    class="form-control elegant-input"
                                    value="{{ old('judul_buku') }}"
                                    placeholder="Pilih tombol Pinjam di galeri atau ketik judul buku"
                                    required>
                            </div>

                            <div class="col-md-4">
                                <label for="borrowQtyInput" class="form-label elegant-label">Jumlah :</label>
                                <select id="borrowQtyInput" name="jumlah_buku" class="form-select elegant-select">
                                    <option value="1" selected>1 Buku</option>
                                    <option value="2">2 Buku</option>
                                    <option value="3">3 Buku</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label for="borrowDateInput" class="form-label elegant-label">Tanggal Pinjam :</label>
                                <input
                                    type="date"
                                    id="borrowDateInput"
                                    name="tanggal_pinjam"
                                    class="form-control elegant-input"
                                    value="{{ date('Y-m-d') }}"
                                    required>
                            </div>

                            <div class="col-md-4">
                                <label for="borrowDurationSelect" class="form-label elegant-label">Rentang Waktu :</label>
                                <select id="borrowDurationSelect" name="durasi_hari" class="form-select elegant-select">
                                    <option value="3">3 Hari</option>
                                    <option value="7" selected>7 Hari</option>
                                    <option value="14">14 Hari</option>
                                    <option value="21">21 Hari</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <div class="small text-secondary">
                                    Estimasi Kembali: <span id="dueDatePreviewText" class="text-info fw-semibold">-</span>
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="borrowNoteInput" class="form-label elegant-label">Keperluan / Catatan :</label>
                                <input
                                    type="text"
                                    id="borrowNoteInput"
                                    name="catatan"
                                    class="form-control elegant-input"
                                    placeholder="Opsional (misal: Referensi tugas / bacaan)">
                            </div>

                            <div class="col-12 pt-2">
                                @if($currentGmail)
                                    <button type="submit" class="btn btn-purple-submit w-100">
                                        Simpan Peminjaman
                                    </button>
                                @else
                                    <button type="button" class="btn btn-purple-submit w-100" data-bs-toggle="modal" data-bs-target="#gmailLoginModal">
                                        Login Gmail untuk Meminjam
                                    </button>
                                @endif
                            </div>
                        </form>
                    </div>

                    <!-- VIEW 2: TABEL BUKU SAYA (RINGKAS: NAMA BUKU & RENTANG WAKTU SAJA) -->
                    <div id="paneBukuSayaView" class="split-view-pane">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="fw-bold text-white mb-0">Buku Saya</h3>
                            @if($currentGmail)
                                <span class="badge rounded-pill text-bg-dark border border-secondary">
                                    {{ $currentGmail }}
                                </span>
                            @endif
                        </div>

                        @if(!$currentGmail)
                            <div class="p-4 rounded-4 text-center" style="background: rgba(255,255,255,0.04); border: 1px solid rgba(147,197,253,0.14);">
                                <p class="text-secondary mb-3">
                                    Silakan login dengan akun Gmail Anda untuk melihat daftar buku yang sedang Anda pinjam.
                                </p>
                                <button type="button" class="btn btn-purple-submit px-4" data-bs-toggle="modal" data-bs-target="#gmailLoginModal">
                                    Login Gmail Sekarang
                                </button>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table id="bukuSayaTable" class="table table-hover align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th style="width: 54px;">No.</th>
                                            <th>Nama Buku yang Dipinjam</th>
                                            <th>Rentang Waktu Peminjaman</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($loansList as $idx => $loan)
                                            <tr>
                                                <td>{{ $idx + 1 }}</td>
                                                <td class="fw-semibold text-white">
                                                    {{ $loan->judul_buku }}
                                                </td>
                                                <td class="text-info small fw-semibold">
                                                    {{ optional($loan->tanggal_pinjam)->format('d M Y') ?? '-' }} – {{ optional($loan->tanggal_kembali)->format('d M Y') ?? '-' }}
                                                    <span class="text-secondary fw-normal">({{ $loan->durasi_hari ?? 7 }} hari)</span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center text-secondary py-4">
                                                    Akun <strong>{{ $currentGmail }}</strong> belum memiliki riwayat peminjaman buku.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <footer class="text-center">
            © 2026 Glaciary · Laravel, Kelompok 14.
        </footer>
    </main>


    <!-- =====================================================
         MODAL LOGIN GMAIL PENGUNJUNG
    ====================================================== -->
    <div class="modal fade" id="gmailLoginModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content dark-glass-modal rounded-4">
                <div class="modal-header border-secondary border-opacity-25">
                    <h5 class="modal-title fw-bold">Masuk dengan Akun Gmail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <p class="small text-secondary mb-3">
                        Data peminjaman akan tersimpan ke database dan ditampilkan khusus sesuai akun Gmail yang Anda gunakan.
                    </p>

                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <button type="button" class="btn btn-sm btn-outline-info rounded-pill quick-gmail-fill" data-gmail="pembaca.satu@gmail.com" data-nama="Pembaca Satu">
                            Contoh Gmail A
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-warning rounded-pill quick-gmail-fill" data-gmail="pembaca.dua@gmail.com" data-nama="Pembaca Dua">
                            Contoh Gmail B
                        </button>
                    </div>

                    <form action="{{ route('booklibrary.user.login') }}" method="POST" class="row g-3 keep-scroll-form">
                        @csrf
                        <div class="col-12">
                            <label for="modalGmailInput" class="form-label elegant-label">Alamat Gmail *</label>
                            <input
                                type="email"
                                id="modalGmailInput"
                                name="gmail"
                                class="form-control elegant-input"
                                value="{{ old('gmail', $currentGmail) }}"
                                placeholder="namaanda@gmail.com"
                                required>
                        </div>
                        <div class="col-12">
                            <label for="modalNamaInput" class="form-label elegant-label">Nama Lengkap *</label>
                            <input
                                type="text"
                                id="modalNamaInput"
                                name="nama"
                                class="form-control elegant-input"
                                value="{{ old('nama', $currentName) }}"
                                placeholder="Masukkan nama lengkap Anda"
                                required>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-purple-submit w-100">
                                Lanjutkan dengan Gmail
                            </button>
                        </div>
                    </form>

                    @if($currentGmail)
                        <form action="{{ route('booklibrary.user.logout') }}" method="POST" class="mt-2 keep-scroll-form">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger w-100 rounded-3 fw-bold">
                                Keluar
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.11/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function () {
            if ($('#bukuSayaTable').length) {
                $('#bukuSayaTable').DataTable({
                    pageLength: 10,
                    lengthMenu: [10, 25, 50, 100],

                    paging: true,
                    searching: true,
                    ordering: true,

                    language: {
                        search: "Cari:",
                        lengthMenu: "Show _MENU_ entries",
                        info: "Showing _START_ to _END_ of _TOTAL_ entries",
                        paginate: {
                            previous: "Previous",
                            next: "Next"
                        }
                    }
                });
            }
        });
    </script>
    
    <script>
        (function () {
            const SCROLL_KEY = 'booklibrary_index_scroll_y';

            function saveScrollPosition() {
                try {
                    const y = window.scrollY || window.pageYOffset || 0;
                    sessionStorage.setItem(SCROLL_KEY, String(Math.max(0, Math.round(y))));
                } catch (_) {}
            }

            function restoreScrollPosition() {
                try {
                    const saved = sessionStorage.getItem(SCROLL_KEY);
                    if (saved === null) return;
                    sessionStorage.removeItem(SCROLL_KEY);
                    const targetY = parseInt(saved, 10);
                    if (Number.isNaN(targetY) || targetY <= 0) return;

                    document.documentElement.classList.add('no-smooth-scroll');
                    window.scrollTo(0, targetY);
                    requestAnimationFrame(() => {
                        window.scrollTo(0, targetY);
                        setTimeout(() => {
                            window.scrollTo(0, targetY);
                            document.documentElement.classList.remove('no-smooth-scroll');
                        }, 60);
                    });
                } catch (_) {
                    document.documentElement.classList.remove('no-smooth-scroll');
                }
            }

            restoreScrollPosition();

            document.querySelectorAll('form.keep-scroll-form').forEach((form) => {
                form.addEventListener('submit', function () {
                    saveScrollPosition();
                });
            });

            const searchUrl = "{{ route('booklibrary.api.search') }}";
            const isUserLoggedIn = {{ $currentGmail ? 'true' : 'false' }};

            const svgPlaceholder = '<svg xmlns="http://www.w3.org/2000/svg" width="300" height="400" viewBox="0 0 300 400"><defs><linearGradient id="g" x1="0" y1="0" x2="1" y2="1"><stop offset="0%" stop-color="#1e293b"/><stop offset="100%" stop-color="#0f172a"/></linearGradient></defs><rect width="300" height="400" fill="url(#g)"/><text x="150" y="210" text-anchor="middle" font-family="Arial, sans-serif" font-size="14" font-weight="bold" fill="#93c5fd">Book Cover</text></svg>';
            const placeholderCover = "data:image/svg+xml;charset=UTF-8," + encodeURIComponent(svgPlaceholder);

            function escapeHtml(str) {
                return String(str ?? '')
                    .replace(/&/g, '&')
                    .replace(/</g, '<')
                    .replace(/>/g, '>')
                    .replace(/"/g, '"')
                    .replace(/'/g, '\x27');
            }

            // --- SWITCHER FORM <-> BUKU SAYA ---
            const pillSwitcher = document.getElementById('splitPillSwitcher');
            const tabFormBtn = document.getElementById('tabFormBtn');
            const tabBukuSayaBtn = document.getElementById('tabBukuSayaBtn');
            const paneFormView = document.getElementById('paneFormView');
            const paneBukuSayaView = document.getElementById('paneBukuSayaView');

            function showFormTab() {
                pillSwitcher?.setAttribute('data-active-tab', 'form');
                tabFormBtn?.classList.add('active');
                tabBukuSayaBtn?.classList.remove('active');
                paneFormView?.classList.add('is-active');
                paneBukuSayaView?.classList.remove('is-active');
            }

            function showBukuSayaTab() {
                pillSwitcher?.setAttribute('data-active-tab', 'bukusaya');
                tabBukuSayaBtn?.classList.add('active');
                tabFormBtn?.classList.remove('active');
                paneBukuSayaView?.classList.add('is-active');
                paneFormView?.classList.remove('is-active');
            }

            tabFormBtn?.addEventListener('click', showFormTab);
            tabBukuSayaBtn?.addEventListener('click', showBukuSayaTab);

            document.getElementById('openMyLoansNavBtn')?.addEventListener('click', function () {
                showBukuSayaTab();
                document.getElementById('form-peminjaman')?.scrollIntoView({ behavior: 'smooth' });
            });

            // --- ISI CEPAT CONTOH GMAIL A / B ---
            document.querySelectorAll('.quick-gmail-fill').forEach((btn) => {
                btn.addEventListener('click', function () {
                    const gInput = document.getElementById('modalGmailInput');
                    const nInput = document.getElementById('modalNamaInput');
                    if (gInput) gInput.value = btn.getAttribute('data-gmail') || '';
                    if (nInput) nInput.value = btn.getAttribute('data-nama') || '';
                });
            });

            // --- ESTIMASI TANGGAL KEMBALI ---
            const borrowDateInput = document.getElementById('borrowDateInput');
            const borrowDurationSelect = document.getElementById('borrowDurationSelect');
            const dueDatePreviewText = document.getElementById('dueDatePreviewText');

            function updateDuePreview() {
                if (!borrowDateInput || !borrowDurationSelect || !dueDatePreviewText) return;
                const d = new Date(`${borrowDateInput.value}T00:00:00`);
                if (Number.isNaN(d.getTime())) {
                    dueDatePreviewText.textContent = '-';
                    return;
                }
                const days = Number(borrowDurationSelect.value || 7);
                d.setDate(d.getDate() + days);
                dueDatePreviewText.textContent = d.toLocaleDateString('id-ID', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric'
                }) + ` (${days} hari)`;
            }

            borrowDateInput?.addEventListener('change', updateDuePreview);
            borrowDurationSelect?.addEventListener('change', updateDuePreview);
            updateDuePreview();

            // --- API GALLERY (SETTINGAN PERSIS BLADE 1) ---
            const searchInput = document.getElementById('apiSearchInput');
            const searchBtn = document.getElementById('apiSearchBtn');
            const statusEl = document.getElementById('apiSearchStatus');
            const resultsEl = document.getElementById('apiSearchResults');
            const activeGenreLabel = document.getElementById('activeGenreLabel');
            const genreTiles = Array.from(document.querySelectorAll('.genre-tile'));

            const genreCuratedQueries = {
                all: ['Atomic Habits', 'Clean Code', 'Sapiens', 'Cosmos', 'The Hobbit', 'Deep Work'],
                Fiction: ['The Hobbit', 'To Kill a Mockingbird', '1984 George Orwell', 'Pride and Prejudice', 'Sherlock Holmes', 'Dune Frank Herbert'],
                Science: ['Cosmos Carl Sagan', 'A Brief History of Time', 'The Selfish Gene', 'Astrophysics for People in a Hurry', 'Origin of Species', 'The Gene Siddhartha Mukherjee'],
                History: ['Sapiens Yuval Noah Harari', 'Guns Germs and Steel', 'The Silk Roads', 'SPQR Mary Beard', 'A Short History of Nearly Everything', 'World War II Antony Beevor'],
                Technology: ['Clean Code', 'The Pragmatic Programmer', 'Introduction to Algorithms', 'Design Patterns', 'Computer Networks Tanenbaum', 'Operating System Concepts'],
                Business: ['Atomic Habits', 'The Psychology of Money', 'Good to Great', 'Zero to One', 'Thinking Fast and Slow', 'Measure What Matters']
            };

            function renderShowcaseCards(items) {
                resultsEl.innerHTML = items.map((item) => {
                    const cover = item.cover_url || placeholderCover;
                    const author = item.pengarang || 'Penulis Tidak Diketahui';
                    const publisher = item.penerbit || 'Penerbit Umum';
                    const isbn = item.isbn || 'Auto-ISBN';
                    const badgeText = item.tahun_terbit ? `${item.tahun_terbit}` : 'API';
                    const descText = `${author} · ${publisher}`;

                    return `
                        <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                            <article class="showcase-card">
                                <div class="showcase-card-top">BOOK DETAILS</div>
                                <div class="showcase-cover-wrap">
                                    <img
                                        src="${escapeHtml(cover)}"
                                        alt="${escapeHtml(item.judul_buku)}"
                                        class="api-showcase-img"
                                        loading="lazy">
                                    <span class="showcase-badge-pill">${escapeHtml(badgeText)}</span>
                                </div>
                                <div class="showcase-book-title" title="${escapeHtml(item.judul_buku)}">
                                    ${escapeHtml(item.judul_buku)}
                                </div>
                                <div class="showcase-book-stars">★★★★★</div>
                                <div class="showcase-book-desc" title="${escapeHtml(descText)}">
                                    ${escapeHtml(descText)}
                                </div>
                                <div class="showcase-card-footer">
                                    <small class="showcase-isbn-text">${escapeHtml(isbn)}</small>
                                    <button
                                        type="button"
                                        class="btn-pinjam-card pick-book-btn"
                                        data-title="${escapeHtml(item.judul_buku)}"
                                        data-isbn="${escapeHtml(item.isbn || '')}"
                                        data-author="${escapeHtml(item.pengarang || '')}"
                                        data-publisher="${escapeHtml(item.penerbit || '')}"
                                        data-year="${escapeHtml(item.tahun_terbit || '')}"
                                        data-cover="${escapeHtml(item.cover_url || '')}">
                                        Pinjam
                                    </button>
                                </div>
                            </article>
                        </div>
                    `;
                }).join('');

                resultsEl.querySelectorAll('.api-showcase-img').forEach((img) => {
                    img.addEventListener('error', function onErr() {
                        img.removeEventListener('error', onErr);
                        img.src = placeholderCover;
                    });
                });

                resultsEl.querySelectorAll('.pick-book-btn').forEach((btn) => {
                    btn.addEventListener('click', function () {
                        showFormTab();
                        const titleInput = document.getElementById('borrowBookTitleInput');
                        if (titleInput) titleInput.value = btn.getAttribute('data-title') || '';
                        document.getElementById('hiddenBookIsbn').value = btn.getAttribute('data-isbn') || '';
                        document.getElementById('hiddenBookAuthor').value = btn.getAttribute('data-author') || '';
                        document.getElementById('hiddenBookPublisher').value = btn.getAttribute('data-publisher') || '';
                        document.getElementById('hiddenBookYear').value = btn.getAttribute('data-year') || '';
                        document.getElementById('hiddenBookCover').value = btn.getAttribute('data-cover') || '';

                        document.getElementById('form-peminjaman')?.scrollIntoView({ behavior: 'smooth' });

                        if (!isUserLoggedIn) {
                            const loginModalEl = document.getElementById('gmailLoginModal');
                            if (loginModalEl && typeof bootstrap !== 'undefined') {
                                new bootstrap.Modal(loginModalEl).show();
                            }
                        } else {
                            titleInput?.focus();
                        }
                    });
                });
            }

            async function fetchSingleBook(query) {
                const res = await fetch(`${searchUrl}?q=${encodeURIComponent(query)}`, {
                    headers: { 'Accept': 'application/json' }
                });
                if (!res.ok) return null;
                const data = await res.json();
                const list = Array.isArray(data.items) ? data.items : [];
                return list.find((it) => it && it.cover_url) || list[0] || null;
            }

            async function loadGenreGallery(genreKey = 'all') {
                const labelText = genreKey === 'all' ? 'Semua Genre' : genreKey;
                if (activeGenreLabel) activeGenreLabel.textContent = `· ${labelText}`;

                const queries = genreCuratedQueries[genreKey] || genreCuratedQueries.all;
                statusEl.textContent = `Memuat ${queries.length} buku untuk genre ${labelText}...`;
                resultsEl.innerHTML = '';
                searchBtn.disabled = true;

                try {
                    const fetched = await Promise.all(queries.map((q) => fetchSingleBook(q)));
                    const items = fetched.filter(Boolean).slice(0, 6);
                    statusEl.textContent = `Menampilkan ${items.length} buku (${labelText}). Klik "Pinjam" untuk mengajukan peminjaman.`;
                    renderShowcaseCards(items);
                } catch (_) {
                    statusEl.textContent = 'Gagal memuat buku dari API.';
                } finally {
                    searchBtn.disabled = false;
                }
            }

            async function runCustomSearch() {
                const q = (searchInput?.value || '').trim();
                if (!q) {
                    const activeTile = document.querySelector('.genre-tile.active');
                    loadGenreGallery(activeTile?.getAttribute('data-genre') || 'all');
                    return;
                }

                if (activeGenreLabel) activeGenreLabel.textContent = `· Cari: "${q}"`;
                statusEl.textContent = `Mencari "${q}"...`;
                resultsEl.innerHTML = '';
                searchBtn.disabled = true;

                try {
                    const res = await fetch(`${searchUrl}?q=${encodeURIComponent(q)}`, {
                        headers: { 'Accept': 'application/json' }
                    });
                    const data = await res.json();
                    const items = (Array.isArray(data.items) ? data.items : []).slice(0, 6);
                    statusEl.textContent = items.length
                        ? `Ditemukan ${items.length} buku untuk "${q}".`
                        : `Tidak ditemukan buku untuk "${q}".`;
                    renderShowcaseCards(items);
                } catch (_) {
                    statusEl.textContent = 'Terjadi gangguan jaringan.';
                } finally {
                    searchBtn.disabled = false;
                }
            }

            genreTiles.forEach((tile) => {
                tile.addEventListener('click', function () {
                    genreTiles.forEach((t) => t.classList.remove('active'));
                    tile.classList.add('active');
                    loadGenreGallery(tile.getAttribute('data-genre') || 'all');
                });
            });

            searchBtn?.addEventListener('click', runCustomSearch);
            searchInput?.addEventListener('keydown', function (e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    runCustomSearch();
                }
            });

            loadGenreGallery('all');
        })();
    
    </script>
</body>
</html>