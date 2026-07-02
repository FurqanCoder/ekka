<div>
    <style>
        /*---------------------------------------------------------------------------------
    Included CSS INDEX
-----------------------------------------------------------------------------------

01. Typography
02. Components
    - Helper
    - Common
    - Popup Model
    - Breadcrumb
03. Layout
    - Header Section
    - Mainslider Section
    - Product Tab Section
    - Banner Section
    - Category Section
    - Specials Section
    - Services Section
    - Offer Section
    - New Product Section
    - Testimonial Section
    - Brand Section
    - Instagram Section
    - Footer Section
    - Quickview Section
-----------------------------------------------------------------------------------*/
        /*-------------------------------------------------
  Fonts Family & Style CSS
---------------------------------------------------*/
        @font-face {
            font-family: "Poppins, sans-serif";
            src: url("../fonts/poppins/Poppins-Thin.ttf") format("truetype");
            font-weight: 100;
            font-style: normal;
        }

        @font-face {
            font-family: "Poppins, sans-serif";
            src: url("../fonts/poppins/Poppins-ExtraLight.ttf") format("truetype");
            font-weight: 200;
            font-style: normal;
        }

        @font-face {
            font-family: "Poppins, sans-serif";
            src: url("../fonts/poppins/Poppins-Light.ttf");
            font-weight: 300;
            font-style: normal;
        }

        @font-face {
            font-family: "Poppins, sans-serif";
            src: url("../fonts/poppins/Poppins-Regular.ttf") format("truetype");
            font-weight: 400;
            font-style: normal;
        }

        @font-face {
            font-family: "Poppins, sans-serif";
            src: url("../fonts/poppins/Poppins-Medium.ttf") format("truetype");
            font-weight: 500;
            font-style: normal;
        }

        @font-face {
            font-family: "Poppins, sans-serif";
            src: url("../fonts/poppins/Poppins-SemiBold.ttf") format("truetype");
            font-weight: 600;
            font-style: normal;
        }

        @font-face {
            font-family: "Poppins, sans-serif";
            src: url("../fonts/poppins/Poppins-Bold.ttf") format("truetype");
            font-weight: 700;
            font-style: normal;
        }

        @font-face {
            font-family: "Poppins, sans-serif";
            src: url("../fonts/poppins/Poppins-ExtraBold.ttf") format("truetype");
            font-weight: 800;
            font-style: normal;
        }

        @font-face {
            font-family: "Poppins, sans-serif";
            src: url("../fonts/poppins/Poppins-Black.ttf") format("truetype");
            font-weight: 900;
            font-style: normal;
        }

        @font-face {
            font-family: "Fjalla One";
            src: url("../fonts/fjalla/FjallaOne-Regular.ttf") format("truetype");
        }

        @font-face {
            font-family: "Montserrat";
            src: url("../fonts/montserrat/Montserrat-Regular.ttf") format("truetype");
            font-weight: 400;
            font-style: normal;
        }

        @font-face {
            font-family: "Montserrat";
            src: url("../fonts/montserrat/Montserrat-SemiBold.ttf") format("truetype");
            font-weight: 700;
            font-style: normal;
        }

        @font-face {
            font-family: "Montserrat";
            src: url("../fonts/montserrat/Montserrat-Bold.ttf") format("truetype");
            font-weight: 800;
            font-style: normal;
        }

        @font-face {
            font-family: "Montserrat";
            src: url("../fonts/montserrat/Montserrat-ExtraBold.ttf") format("truetype");
            font-weight: 900;
            font-style: normal;
        }

        @font-face {
            font-family: "Oswald";
            src: url("../fonts/oswald/Oswald-ExtraLight.ttf") format("truetype");
            font-weight: 200;
            font-style: normal;
        }

        @font-face {
            font-family: "Oswald";
            src: url("../fonts/oswald/Oswald-Light.ttf") format("truetype");
            font-weight: 300;
            font-style: normal;
        }

        @font-face {
            font-family: "Oswald";
            src: url("../fonts/oswald/Oswald-Regular.ttf");
            font-weight: 400;
            font-style: normal;
        }

        @font-face {
            font-family: "Oswald";
            src: url("../fonts/oswald/Oswald-Medium.ttf") format("truetype");
            font-weight: 500;
            font-style: normal;
        }

        @font-face {
            font-family: "Oswald";
            src: url("../fonts/oswald/Oswald-SemiBold.ttf") format("truetype");
            font-weight: 600;
            font-style: normal;
        }

        @font-face {
            font-family: "Oswald";
            src: url("../fonts/oswald/Oswald-Bold.ttf") format("truetype");
            font-weight: 700;
            font-style: normal;
        }

        /*-------------------------------------------------
  Site Main Slider CSS
---------------------------------------------------*/
        .ec-slide-item {
            width: 100%;
            height: 80vh;
            position: relative;
        }

        .swiper-slide {
            overflow: auto;
        }

        .ec-slide-1 {
            width: 100%;
            /* background-image: url({{ asset('web/images/main-slider-banner/1.jpg') }}); */
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            overflow-y: hidden;
        }

        .ec-slide-2 {
            /* background-image: url({{ asset('web/images/main-slider-banner/2.jpg') }}); */
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
        }


        .ec-slide-3 {
            background-image: url("../images/main-slider-banner/3.jpg");
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
        }

        /*----  Main Slider Style  ----*/
        .ec-main-slider .container {
            position: absolute;
            left: 0;
            right: 0;
        }

        .ec-main-slider * {
            direction: ltr;
        }

        .ec-slide-content {
            position: relative;
            z-index: 9;
        }

        .ec-slide-content .ec-slide-title {
            margin-bottom: 25px;
            padding-top: 25px;
            color: #555;
            font-size: 65px;
            font-weight: 600;
            letter-spacing: 2px;
            font-family: "Fjalla One";
            position: relative;
        }

        .ec-slide-content .ec-slide-title:before {
            content: "";
            position: absolute;
            top: 0;
            height: 5px;
            width: 50px;
            margin: 0 auto;
            background: #3474d4;
            left: 4px;
            right: auto;
        }

        .ec-slide-content .ec-slide-stitle {
            font-size: 50px;
            font-weight: 400;
            color: #444444;
            margin-bottom: 11px;
            text-transform: uppercase;
            letter-spacing: 1.6px;
        }

        .ec-slide-content p {
            max-width: 350px;
            font-size: 17px;
            color: #777777;
            line-height: 1.5;
            letter-spacing: 0;
            font-weight: 300;
        }

        .ec-slide-content .btn {
            font-size: 15px;
            padding: 0 19px;
            letter-spacing: 0;
            margin-top: 34px;
        }

        .main-slider-dot .swiper-pagination-bullets {
            display: none;
        }

        .main-slider-dot .swiper-pagination-bullet {
            width: 14px;
            height: 14px;
            display: inline-block;
            border-radius: 100%;
            background: transparent;
            opacity: 1;
            border: 1px solid #000000;
            margin: 0 5px;
            -webkit-box-shadow: none;
            box-shadow: none;
            -webkit-transition: all 0.3s ease 0s;
            transition: all 0.3s ease 0s;
        }

        .main-slider-dot .swiper-pagination-bullet:hover {
            background-color: #555;
            border-color: #555;
        }

        .main-slider-dot .swiper-pagination-bullet.swiper-pagination-bullet-active {
            background-color: #555;
            border-color: #555;
        }

        .main-slider-dot.dot-color-white .swiper-pagination-bullet {
            border: 1px solid #ffffff;
        }

        .main-slider-dot.dot-color-white .swiper-pagination-bullet:hover {
            background-color: #555;
            border-color: #555;
        }

        .main-slider-dot.dot-color-white .swiper-pagination-bullet.swiper-pagination-bullet-active {
            background-color: #555;
            border-color: #555;
        }

        .main-slider-nav {
            position: relative;
        }

        .main-slider-nav .swiper-button-next {
            outline: 0;
            left: auto;
            right: -20px;
        }

        .main-slider-nav .swiper-button-next:after {
            content: "\f105";
            font-family: "EcIcons";
            font-size: 30px;
            line-height: 1;
            outline: 0;
        }

        .main-slider-nav .swiper-button-prev {
            outline: 0;
            right: auto;
            left: -20px;
        }

        .main-slider-nav .swiper-button-prev:after {
            content: "\f104";
            font-family: "EcIcons";
            font-size: 30px;
            line-height: 1;
            outline: 0;
        }

        .main-slider-nav .swiper-buttons .swiper-button-next {
            position: absolute;
            top: 50%;
            -webkit-transform: translateY(-50%);
            transform: translateY(-50%);
            z-index: 9;
            width: 40px;
            height: 40px;
            line-height: 40px;
            opacity: 0;
            visibility: hidden;
            -webkit-transition: all 0.3s;
            transition: all 0.3s;
            margin: auto;
            border-radius: 0;
            text-align: center;
            color: #ffffff;
            background-color: #3474d4;
        }

        .main-slider-nav .swiper-buttons .swiper-button-next:hover {
            background-color: #555;
            color: #ffffff;
        }

        .main-slider-nav .swiper-buttons .swiper-button-prev {
            position: absolute;
            top: 50%;
            -webkit-transform: translateY(-50%);
            transform: translateY(-50%);
            z-index: 9;
            width: 40px;
            height: 40px;
            line-height: 40px;
            opacity: 0;
            visibility: hidden;
            -webkit-transition: all 0.3s;
            transition: all 0.3s;
            margin: auto;
            border-radius: 0;
            text-align: center;
            color: #ffffff;
            background-color: #3474d4;
        }

        .main-slider-nav .swiper-buttons .swiper-button-prev:hover {
            background-color: #555;
            color: #ffffff;
        }

        .main-slider-nav:hover .swiper-button-next {
            opacity: 1;
            visibility: visible;
            right: 10px;
        }

        .main-slider-nav:hover .swiper-button-prev {
            opacity: 1;
            visibility: visible;
            left: 10px;
        }

        .main-slider-nav.small-nav .swiper-button-next:after {
            font-size: 14px;
        }

        .main-slider-nav.small-nav .swiper-button-prev:after {
            font-size: 14px;
        }

        .main-slider-nav.small-nav .swiper-buttons .swiper-button-next {
            width: 30px;
            height: 30px;
            line-height: 30px;
        }

        .main-slider-nav.small-nav .swiper-buttons .swiper-button-next:hover {
            background-color: #555;
            color: #ffffff;
        }

        .main-slider-nav.small-nav .swiper-buttons .swiper-button-prev {
            width: 30px;
            height: 30px;
            line-height: 30px;
        }

        .main-slider-nav.small-nav .swiper-buttons .swiper-button-prev:hover {
            background-color: #555;
            color: #ffffff;
        }

        /*----  Button Style  ----*/
        .btn {
            padding: 0;
            font-size: 16px;
            border-radius: 0;
            height: 45px;
            border: 0;
            font-weight: 500;
            line-height: 45px;
            padding-left: 15px;
            padding-right: 15px;
        }

        .btn:focus {
            outline: 0;
            -webkit-box-shadow: none;
            box-shadow: none;
        }

        .btn-primary {
            color: #ffffff;
            background-color: #3474d4;
            border-color: #3474d4;
        }

        .btn-primary:hover {
            color: #ffffff;
            background-color: #555;
            border-color: #555;
        }

        .btn-primary:focus {
            color: #ffffff;
            background-color: #3474d4;
            border-color: #3474d4;
        }

        .btn-primary:active {
            color: #ffffff;
            background-color: #3474d4;
            border-color: #3474d4;
        }

        .btn-color-dark {
            background-color: #4d4d4d;
            border-color: #4d4d4d;
            color: #ffffff;
            font-weight: 500;
            font-size: 14px;
            width: 130px;
            height: 45px;
            line-height: 45px;
        }

        .btn-hover-color-primary:hover {
            color: #ffffff;
            background-color: #555;
            border-color: #555;
        }

        .btn-check:focus+.btn {
            outline: 0;
            -webkit-box-shadow: none;
            box-shadow: none;
        }

        .btn-check:focus+.btn-primary {
            color: #ffffff;
            background-color: #3474d4;
            border-color: #3474d4;
        }

        .btn-check:checked+.btn-primary {
            color: #ffffff;
            background-color: #3474d4;
            border-color: #3474d4;
        }

        .btn-check:active+.btn-primary {
            color: #ffffff;
            background-color: #3474d4;
            border-color: #3474d4;
        }

        .btn-primary.active {
            color: #ffffff;
            background-color: #3474d4;
            border-color: #3474d4;
        }

        .show>.btn-primary.dropdown-toggle {
            color: #ffffff;
            background-color: #3474d4;
            border-color: #3474d4;
        }

        /*-------------------------------------------------
  Banner Section CSS
---------------------------------------------------*/
        .ec-banner {
            margin-bottom: 3px;
        }

        .ec-banner-inner {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: horizontal;
            -webkit-box-direction: normal;
            -ms-flex-direction: row;
            flex-direction: row;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: justify;
            -ms-flex-pack: justify;
            justify-content: space-between;
        }

        .banner-block {
            position: relative;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            overflow: hidden;
        }

        .banner-block .bnr-overlay {
            position: relative;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            border-radius: 0;
            overflow: hidden;
            border: 1px solid #eeeeee;
        }

        .banner-block img {
            width: 100%;
            -webkit-transition: all 0.3s ease 0s;
            transition: all 0.3s ease 0s;
        }

        .banner-block .banner-text {
            position: absolute;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            padding: 30px;
        }

        .banner-block .banner-text .ec-banner-title {
            font-size: 28px;
            color: #555;
            margin-bottom: 2px;
            letter-spacing: 1px;
            font-family: "Montserrat";
            font-weight: 800;
            position: relative;
            padding-top: 0;
            text-transform: uppercase;
            line-height: 1.2;
        }

        .banner-block .banner-text .ec-banner-discount {
            font-size: 24px;
            font-weight: 400;
            color: #ffffff;
            letter-spacing: 0.7px;
            line-height: 1;
        }

        .banner-block .banner-text .ec-banner-stitle {
            font-size: 20px;
            font-weight: 400;
            color: #555;
            text-transform: capitalize;
            letter-spacing: 0.7px;
            line-height: 1;
            position: relative;
            padding-left: 2px;
            padding-top: 10px;
        }

        .banner-block .banner-content {
            position: absolute;
            top: 0;
            left: 0;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: horizontal;
            -webkit-box-direction: normal;
            -ms-flex-direction: row;
            flex-direction: row;
            width: 100%;
            height: 100%;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            -webkit-transform: scale(0.9);
            transform: scale(0.9);
            opacity: 0;
            -webkit-transition: all 0.5s ease 0s;
            transition: all 0.5s ease 0s;
            background-color: rgba(31, 28, 28, 0.5);
        }

        .banner-block .banner-content .ec-banner-btn a {
            height: 40px;
            font-size: 16px;
            text-transform: uppercase;
            padding: 0 18px;
            letter-spacing: 0.02rem;
            background-color: #3474d4;
            color: #ffffff;
            line-height: 40px;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            font-weight: 600;
        }

        .banner-block .banner-content .ec-banner-btn a:hover {
            background-color: #555;
        }

        .banner-block:hover .banner-content {
            -webkit-transform: scale(1);
            transform: scale(1);
            opacity: 1;
        }

        .ec-banner-block-1 .banner-block .banner-text {
            padding-top: 46px;
        }

        .ec-banner-block-1 .banner-block .banner-text .ec-banner-discount {
            font-family: "Fjalla One";
        }

        .ec-banner-block-2 .banner-block .banner-text .ec-banner-title {
            font-size: 28px;
            margin: 15px 0;
        }

        .ec-banner-block-2 .banner-block .banner-text .ec-banner-discount {
            font-size: 16px;
            color: #777;
            letter-spacing: 0.5px;
            line-height: 1.5;
        }

        .ec-banner-block.ec-banner-block-2 {
            padding: 0;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            -ms-flex-line-pack: justify;
            align-content: space-between;
            height: 100%;
            -webkit-box-pack: justify;
            -ms-flex-pack: justify;
            justify-content: space-between;
        }

        /*-------------------------------------------------
  Product Countdown CSS
---------------------------------------------------*/
        .ec-fre-spe-section .section-title {
            padding-bottom: 5px;
            border-bottom: 1px solid #eeeeee;
        }

        .ec-fre-spe-section .section-title .ec-bg-title {
            font-size: 52px;
            letter-spacing: 1px;
        }

        .ec-fre-spe-section .section-title .ec-title {
            padding: 0;
        }

        .ec-fre-spe-section .section-title .ec-title:after {
            content: none;
        }

        .ec-fre-spe-section .section-title .ec-title:before {
            content: none;
        }

        .ec-fre-spe-section .ec-fs-product {
            padding: 0 10px;
        }

        .ec-fre-spe-section .ec-fre-products {
            margin: 0 -10px;
        }

        .ec-fre-spe-section .ec-spe-products {
            margin: 0 -10px;
        }

        .ec-fre-spe-section .ec-fs-pro-inner {
            background: #f7f7f7;
            padding: 15px 35px;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            min-height: 476px;
            border: 1px solid #eeeeee;
        }

        .ec-fre-spe-section .slick-arrow {
            top: -70px;
        }

        .periodDisplay {
            font-size: 13px;
        }

        .ec-fs-pro-inner .ec-fs-pro-image {
            position: relative;
        }

        .ec-fs-pro-inner .ec-fs-pro-image .image img {
            max-width: 100%;
            padding-right: 10px;
            -webkit-transition: all 0.3s ease 0s;
            transition: all 0.3s ease 0s;
            z-index: 1;
        }

        .ec-fs-pro-inner .ec-fs-pro-image .image img.hover-image {
            position: absolute;
            z-index: 2;
            top: 0;
            left: 0;
            opacity: 0;
        }

        .ec-fs-pro-inner .ec-fs-pro-image a.quickview {
            position: absolute;
            z-index: 9;
            top: 60%;
            right: 0;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: horizontal;
            -webkit-box-direction: normal;
            -ms-flex-direction: row;
            flex-direction: row;
            visibility: hidden;
            -webkit-transition: all 0.5s ease 0s;
            transition: all 0.5s ease 0s;
            width: 40px;
            height: 40px;
            left: 0;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            opacity: 0;
            margin: 0 auto;
            color: #ffffff;
            background-color: #ffffff;
            border: 1px solid #eeeeee;
            border-radius: 50%;
        }

        .ec-fs-pro-inner .ec-fs-pro-image a.quickview:hover {
            -webkit-box-shadow: 0px 0px 5px 0px #ccc;
            box-shadow: 0px 0px 5px 0px #ccc;
        }

        .ec-fs-pro-inner .ec-fs-pro-image a.quickview i {
            color: #777;
            font-size: 17px;
            line-height: 0;
        }

        .ec-fs-pro-inner:hover .ec-fs-pro-image a.quickview {
            visibility: visible;
            opacity: 1;
            top: 44%;
        }

        .ec-fs-pro-inner .ec-fs-pro-content {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            padding-left: 30px;
        }

        .ec-fs-pro-inner .ec-fs-pro-content .ec-fs-price {
            font-size: 16px;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: left;
            -ms-flex-pack: left;
            justify-content: left;
            color: #777777;
            margin: 10px 0 20px 0;
            line-height: 1.2;
        }

        .ec-fs-pro-inner .ec-fs-pro-content .ec-fs-price span.new-price {
            color: #555;
            font-weight: 700;
            font-size: 15px;
        }

        .ec-fs-pro-inner .ec-fs-pro-content .ec-fs-price span.old-price {
            font-size: 13px;
            margin-right: 15px;
            text-decoration: line-through;
            color: #777777;
            margin-top: 2px;
        }

        .ec-fs-pro-inner .ec-fs-pro-content .ec-fs-pro-desc {
            font-size: 14px;
            color: #777777;
            border-top: 1px solid #eeeeee;
            padding: 10px 0 0;
            line-height: 22px;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
            margin-top: 15px;
        }

        .ec-fs-pro-inner .ec-fs-pro-content .ec-fs-pro-book {
            margin-bottom: 10px;
            font-size: 16px;
            color: #444444;
            letter-spacing: 0.5px;
            font-weight: 600;
        }

        .ec-fs-pro-inner .ec-fs-pro-content .ec-fs-pro-book span {
            color: #3474d4;
        }

        .ec-fs-pro-inner .ec-fs-pro-content .ec-fs-pro-btn a {
            height: 35px;
            line-height: 35px;
            padding-left: 10px;
            padding-right: 10px;
            font-weight: 400;
            min-width: 120px;
            text-transform: uppercase;
            font-size: 14px;
        }

        .ec-fs-pro-inner .ec-fs-pro-content .ec-fs-pro-btn a:not(:last-child) {
            margin-right: 11px;
        }

        .ec-fs-pro-inner .ec-fs-pro-title {
            margin: 0 0 2px;
        }

        .ec-fs-pro-inner .ec-fs-pro-title a {
            font-family: "Poppins, sans-serif";
            font-weight: 400;
            font-size: 20px;
            color: #777;
            letter-spacing: 0.6px;
            text-decoration: none;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            display: block;
            line-height: 34px;
        }

        .ec-fs-pro-inner .ec-fs-pro-rating {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            font-size: 16px;
            margin-bottom: 2px;
        }

        .ec-fs-pro-inner .ec-fs-pro-rating .ec-fs-rating-text {
            font-size: 16px;
            color: #777777;
        }

        .ec-fs-pro-inner .ec-fs-pro-rating .ec-fs-rating-icon {
            margin-right: 14px;
            margin-top: -1px;
        }

        .ec-fre-products .slick-arrow.slick-prev {
            right: 28px;
            left: auto;
        }

        .ec-fre-products .slick-arrow.slick-next {
            right: 0;
            left: auto;
        }

        .ec-spe-products .slick-arrow.slick-prev {
            right: 28px;
            left: auto;
        }

        .ec-spe-products .slick-arrow.slick-next {
            right: 0;
            left: auto;
        }

        .numberDisplay {
            color: #686868;
            background-color: #ffffff;
            font-weight: 500;
        }

        /*-------------------------------------------------
  Vendor Section CSS For Home page 1 (index.html)
---------------------------------------------------*/
        .ec-vendor-card {
            margin: 15px 0;
            padding: 15px;
            border: 1px solid #eeeeee;
            background-color: #fff;
        }

        .ec-vendor-card .ec-vendor-detail {
            margin-bottom: 15px;
            padding-bottom: 15px;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: horizontal;
            -webkit-box-direction: normal;
            -ms-flex-direction: row;
            flex-direction: row;
            border-bottom: 1px solid #eeeeee;
        }

        .ec-vendor-card .ec-vendor-detail .ec-vendor-avtar {
            width: 70px;
            margin-right: 10px;
        }

        .ec-vendor-card .ec-vendor-detail .ec-vendor-info {
            width: calc(100% - 80px);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            position: relative;
        }

        .ec-vendor-card .ec-vendor-detail .ec-vendor-info .name {
            font-weight: 500;
            color: #444444;
        }

        .ec-vendor-card .ec-vendor-detail .ec-vendor-info .prod-count {
            margin-bottom: 10px;
            color: #999;
        }

        .ec-vendor-card .ec-vendor-detail .ec-vendor-info .ec-pro-rating i {
            font-size: 12px;
        }

        .ec-vendor-card .ec-vendor-detail .ec-vendor-info .ec-sale {
            position: absolute;
            right: 0;
            bottom: 0;
            bottom: -1px;
            font-size: 12px;
        }

        .ec-vendor-card .ec-vendor-detail .ec-vendor-info .ec-sale p {
            margin: 0;
            color: #999;
        }

        .ec-vendor-card .ec-vendor-prod {
            display: -ms-grid;
            display: grid;
            grid-template-columns: repeat(auto-fill, calc(50% - 6px));
            grid-row-gap: 12px;
            grid-column-gap: 12px;
        }

        .ec-vendor-card .ec-vendor-prod .ec-prod-img {
            overflow: hidden;
        }

        .ec-vendor-card .ec-vendor-prod .ec-prod-img img {
            -webkit-transition: all 0.3s ease-in-out;
            transition: all 0.3s ease-in-out;
        }

        .ec-vendor-card .ec-vendor-prod .ec-prod-img img:hover {
            -webkit-transform: scale(1.1);
            transform: scale(1.1);
        }

        /*-------------------------------------------------
  Services Section CSS
---------------------------------------------------*/
        .ec_ser_inner {
            padding: 30px;
            -webkit-transition: all 0.3s ease 0s;
            transition: all 0.3s ease 0s;
            cursor: pointer;
            border: 1px solid #eeeeee;
            height: 100%;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            text-align: center;
            background-color: #fff;
        }

        .ec_ser_inner .ec-service-image {
            margin-bottom: 15px;
        }

        .ec_ser_inner .ec-service-image svg {
            width: 50px;
            height: 50px;
            fill: #444444;
            stroke: #444444;
            stroke-dashoffset: 1500;
            stroke-dasharray: 1500;
        }

        .ec_ser_inner .ec-service-image i {
            font-size: 44px;
            line-height: 25px;
        }

        .ec_ser_inner:hover {
            box-shadow: 0 3px 25px 4px rgba(0, 0, 0, 0.06);
            -webkit-box-shadow: 0 3px 25px 4px rgba(0, 0, 0, 0.06);
            -moz-box-shadow: 0 3px 25px 4px rgba(0, 0, 0, 0.06);
            border: 1px solid transparent;
        }

        .ec_ser_inner:hover .ec-service-image svg {
            stroke-dashoffset: 0;
            -webkit-transition: fill 0.5s, stroke-dashoffset 6s, -webkit-transform 0.3s;
            transition: fill 0.5s, stroke-dashoffset 6s, -webkit-transform 0.3s;
            transition: transform 0.3s, fill 0.5s, stroke-dashoffset 6s;
            transition: transform 0.3s, fill 0.5s, stroke-dashoffset 6s, -webkit-transform 0.3s;
        }

        .ec-service-desc h2 {
            font-size: 18px;
            font-weight: 700;
            color: #444444;
            letter-spacing: 0.6px;
            margin-bottom: 10px;
        }

        .ec-service-desc p {
            font-size: 14px;
            color: #777777;
            line-height: 1.5;
            letter-spacing: 0.5px;
        }

        /*-------------------------------------------------
  Offer Section CSS
---------------------------------------------------*/
        .ec-offer-section {
            min-height: 620px;
            background-size: cover;
            overflow: hidden;
            padding: 30px 0;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            background-image: url("../images/offer-image/offer_bg.jpg");
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
        }

        .ec-offer-content {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            text-align: center;
        }

        .ec-offer-content .ec-offer-title {
            font-size: 60px;
            color: #3474d4;
            margin-bottom: 5px;
            letter-spacing: 2px;
            font-family: "Montserrat";
            text-transform: uppercase;
            line-height: 1;
            font-weight: 800;
        }

        .ec-offer-content .ec-offer-stitle {
            font-size: 40px;
            color: #3474d4;
            margin-bottom: 13px;
            letter-spacing: 1.5px;
            font-family: "Montserrat";
            text-transform: uppercase;
        }

        .ec-offer-content .btn-primary {
            width: 140px;
            margin: 15px auto 0 auto;
        }

        .ec-offer-content .ec-offer-img {
            margin-bottom: 16px;
        }

        .ec-offer-content .ec-offer-desc {
            font-size: 32px;
            color: #444444;
            margin-bottom: 16px;
            letter-spacing: 1.2px;
            font-weight: 600;
            line-height: 1.2;
        }

        .ec-offer-content .ec-offer-price {
            font-size: 40px;
            color: #555;
            letter-spacing: 1.5px;
            font-weight: 900;
            line-height: 1.2;
        }

        /*-------------------------------------------------
  Brand Section CSS
---------------------------------------------------*/
        .ec-brand-area {
            display: block;
        }

        .ec-brand-item img {
            margin: 0 auto;
            background-color: #fff;
            border: 1px solid #eeeeee;
            -webkit-transition: all 0.3s ease 0s;
            transition: all 0.3s ease 0s;
            cursor: pointer;
            outline: 0;
        }

        .ec-brand-item:hover img {
            box-shadow: 0 3px 25px 4px rgba(0, 0, 0, 0.06);
            -webkit-box-shadow: 0 3px 25px 4px rgba(0, 0, 0, 0.06);
            -moz-box-shadow: 0 3px 25px 4px rgba(0, 0, 0, 0.06);
        }

        .ec-brand-outer .ec-brand-item .ec-brand-img {
            padding: 0 15px;
        }

        .ec-brand-outer .slick-arrow {
            height: 100%;
            top: 0;
            display: none !important;
        }

        .ec-brand-outer .slick-arrow.slick-prev {
            left: -30px;
        }

        .ec-brand-outer .slick-arrow.slick-next {
            right: -30px;
        }

        li.ec-brand-item {
            display: block !important;
        }

        /*-------------------------------------------------
  Category sidebar CSS
---------------------------------------------------*/
        .ec-open {
            -webkit-transform: translateX(0) !important;
            transform: translateX(0) !important;
        }

        .category-sidebar {
            font-size: 14px;
            font-weight: 400;
            position: fixed;
            z-index: 1000;
            top: 0;
            left: 0;
            right: auto;
            display: block;
            width: 350px;
            height: 100%;
            padding: 30px;
            -webkit-transition: all 0.5s ease 0s;
            transition: all 0.5s ease 0s;
            -webkit-transform: translateX(-100%);
            transform: translateX(-100%);
            background-color: #ffffff;
            -webkit-box-shadow: none;
            box-shadow: none;
            overflow: auto;
            opacity: 1;
        }

        .category-sidebar::-webkit-scrollbar {
            position: absolute;
            width: 7px;
        }

        .category-sidebar::-webkit-scrollbar-thumb {
            background-color: rgba(80, 93, 113, 0.5);
            border-radius: 5px;
        }

        .category-sidebar .cat-sidebar .cat-sidebar-box .ec-sidebar-wrap {
            padding: 0;
        }

        .category-sidebar .cat-sidebar .cat-sidebar-box .ec-sidebar-wrap .ec-sb-block-content {
            margin-bottom: 0;
            padding: 0;
            border-bottom: none;
        }

        .category-sidebar .cat-sidebar .cat-sidebar-box .ec-sidebar-wrap .ec-sb-block-content li {
            padding: 0;
        }

        .category-sidebar .cat-sidebar .cat-sidebar-box .ec-sidebar-wrap .ec-sb-block-content li .ec-sidebar-block-item {
            padding: 10px 0;
            position: relative;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            color: #777;
            font-size: 16px;
            font-weight: 500;
            text-transform: capitalize;
            line-height: 1;
            cursor: pointer;
        }

        .category-sidebar .cat-sidebar .cat-sidebar-box .ec-sidebar-wrap .ec-sb-block-content li .ec-sidebar-block-item:after {
            content: "\f067";
            position: absolute;
            right: 0;
            top: 40%;
            font-family: "EcIcons";
            cursor: pointer;
            font-size: 10px;
            color: #777;
            font-weight: 400;
            margin-left: 7px;
        }

        .category-sidebar .cat-sidebar .cat-sidebar-box .ec-sidebar-wrap .ec-sb-block-content li .ec-sidebar-block-item .svg_img {
            width: 20px;
            height: 20px;
            margin-right: 10px;
        }

        .category-sidebar .cat-sidebar .cat-sidebar-box .ec-sidebar-wrap .ec-sb-block-content li ul {
            border-top: 1px solid #ededed;
            display: none;
            padding-top: 13px;
            padding-bottom: 3px;
        }

        .category-sidebar .cat-sidebar .cat-sidebar-box .ec-sidebar-wrap .ec-sb-block-content li ul li {
            padding: 0 0 6px;
        }

        .category-sidebar .cat-sidebar .cat-sidebar-box .ec-sidebar-wrap .ec-sb-block-content li ul li a {
            margin: 0;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            color: #777;
            font-size: 14px;
            margin-top: 0;
            line-height: 20px;
            font-weight: 300;
            text-transform: capitalize;
            letter-spacing: 0;
            cursor: pointer;
            position: relative;
            -webkit-box-pack: justify;
            -ms-flex-pack: justify;
            justify-content: space-between;
        }

        .category-sidebar .cat-sidebar .cat-sidebar-box .ec-sidebar-wrap .ec-sidebar-block .ec-sb-title h3 {
            text-decoration: none;
            color: #444444;
            display: block;
            font-size: 16px;
            line-height: 22px;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            font-weight: 600;
            padding-bottom: 5px;
            position: relative;
            border: none;
        }

        .category-sidebar .cat-sidebar .cat-sidebar-box .ec-sidebar-wrap .ec-sidebar-block .ec-sb-title h3 .ec-close {
            padding: 0;
            position: absolute;
            right: -3px;
            display: inline-block !important;
            font-size: 30px;
            color: #444444;
        }

        .category-sidebar .cat-sidebar .cat-sidebar-box .ec-sidebar-wrap .ec-sidebar-block .ec-sb-title h3 i {
            display: none;
        }

        .category-sidebar .cat-sidebar .ec-sb-slider-title {
            margin-top: 30px;
            text-decoration: none;
            color: #444;
            display: block;
            font-size: 16px;
            line-height: 22px;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            font-weight: 600;
            padding-bottom: 15px;
        }

        .category-sidebar .cat-sidebar .slick-arrow.slick-prev {
            right: 20px;
            left: auto;
        }

        .category-sidebar .cat-sidebar .slick-arrow.slick-prev:before {
            font-size: 22px;
        }

        .category-sidebar .cat-sidebar .slick-arrow {
            top: -43px;
            right: -10px;
            left: auto;
        }

        .category-sidebar .cat-sidebar .slick-arrow:before {
            font-size: 22px;
        }

        .category-sidebar .cat-sidebar .ec-sb-pro-sl .ec-sb-pro-sl-item {
            border: none;
            margin-bottom: 15px;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            overflow: hidden;
        }

        .category-sidebar .cat-sidebar .ec-sb-pro-sl .ec-sb-pro-sl-item .sidekka_pro_img {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 80px;
            flex: 0 0 80px;
        }

        .category-sidebar .cat-sidebar .ec-sb-pro-sl .ec-sb-pro-sl-item .ec-pro-content {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            margin-top: 4px;
            overflow: hidden;
            padding-left: 12px;
        }

        .category-sidebar .cat-sidebar .ec-sb-pro-sl .ec-sb-pro-sl-item .ec-pro-content .ec-pro-title a {
            text-decoration: none;
            color: #444;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            display: block;
            font-size: 14px;
            line-height: 1.5;
            letter-spacing: 0.5px;
            font-weight: 400;
            font-family: "Poppins, sans-serif";
            text-transform: capitalize;
        }

        .category-sidebar .cat-sidebar .ec-sb-pro-sl .ec-sb-pro-sl-item .ec-pro-content .ec-pro-rating {
            margin: 4px 0 6px;
            opacity: 0.7;
        }

        .category-sidebar .cat-sidebar .ec-sb-pro-sl .ec-sb-pro-sl-item .ec-pro-content .ec-price {
            font-size: 16px;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: left;
            -ms-flex-pack: left;
            justify-content: left;
            color: #777;
        }

        .category-sidebar .cat-sidebar .ec-sb-pro-sl .ec-sb-pro-sl-item .ec-pro-content .ec-price span.old-price {
            font-size: 13px;
            margin-right: 15px;
            text-decoration: line-through;
            color: #777;
            line-height: 14px;
        }

        .category-sidebar .cat-sidebar .ec-sb-pro-sl .ec-sb-pro-sl-item .ec-pro-content .ec-price span.new-price {
            color: #555;
            font-weight: 600;
            font-size: 14px;
        }

        .ec-side-cat-overlay {
            display: none;
            width: 100%;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 16;
        }

        /**  Responsive cat sidebar  **/
        @media only screen and (max-width: 575px) {
            .category-sidebar {
                width: 300px;
            }
        }

        /*# sourceMappingURL=demo1.css.map */
    </style>

    {{-- @include('components.web.slider') --}}
    @include('components.web.slider')


    {{-- categories --}}
    <!--  Category Section Start -->
    @livewire('web.components.home.category')
    <!-- New Product Start -->
    <button class="btn btn-warning" wire:click="testNotification">send notification</but>
    <button id="a2hs-btn" onclick="installPWA()"
        style="display:none; position:fixed; bottom:20px; right:20px; padding:10px 20px; background:#1e40af; color:white; border:none; border-radius:8px; z-index:999;">
        Add to Home Screen
    </button>

    <section class="section ec-new-product section-space-p" id="arrivals">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="section-title">
                        <h2 class="ec-bg-title">New Arrivals</h2>
                        <h2 class="ec-title">New Arrivals</h2>
                        <p class="sub-title">Browse The Collection of Top Products</p>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($products as $product)
                    <x-product-card :product="$product" />
                @endforeach



                <div class="col-sm-12 shop-all-btn"><a href="shop-left-sidebar-col-3.html">Shop All Collection</a>
                </div>
            </div>
        </div>
    </section>
    <!-- New Product end -->
    <!-- Product tab Area Start -->
    <section class="section ec-product-tab section-space-p" id="collection">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="section-title">
                        <h2 class="ec-bg-title">Our Top Collection</h2>
                        <h2 class="ec-title">Our Top Collection</h2>
                        <p class="sub-title">Browse The Collection of Top Products</p>
                    </div>
                </div>

                <!-- Tab Start -->
                <div class="col-md-12 text-center">
                    <ul class="ec-pro-tab-nav nav justify-content-center">
                        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#tab-pro-for-all">For
                                All</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab-pro-for-men">For
                                Men</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab-pro-for-women">For
                                Women</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab-pro-for-child">For
                                Children</a></li>
                    </ul>
                </div>
                <!-- Tab End -->
            </div>
            <div class="row">
                <div class="col">
                    <div class="tab-content">
                        <!-- 1st Product tab start -->
                        <div class="tab-pane fade show active" id="tab-pro-for-all">
                            <div class="row">
                                <!-- Product Content -->
                                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 mb-6  ec-product-content"
                                    data-animation="fadeIn">
                                    <div class="ec-product-inner">
                                        <div class="ec-pro-image-outer">
                                            <div class="ec-pro-image">
                                                <a href="product-left-sidebar.html" class="image">
                                                    <img class="main-image" src="web/images/product-image/6_1.jpg"
                                                        alt="Product" />
                                                    <img class="hover-image" src="web/images/product-image/6_2.jpg"
                                                        alt="Product" />
                                                </a>
                                                <span class="percentage">20%</span>
                                                <a href="#" class="quickview" data-link-action="quickview"
                                                    title="Quick view" data-bs-toggle="modal"
                                                    data-bs-target="#ec_quickview_modal"><i class="fi-rr-eye"></i></a>
                                                <div class="ec-pro-actions">
                                                    <a href="compare.html" class="ec-btn-group compare"
                                                        title="Compare"><i class="fi fi-rr-arrows-repeat"></i></a>
                                                    <button title="Add To Cart" class="add-to-cart"><i
                                                            class="fi-rr-shopping-basket"></i> Add To Cart</button>
                                                    <a class="ec-btn-group wishlist" title="Wishlist"><i
                                                            class="fi-rr-heart"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ec-pro-content">
                                            <h5 class="ec-pro-title"><a href="product-left-sidebar.html">Round Neck
                                                    T-Shirt</a></h5>
                                            <div class="ec-pro-rating">
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star"></i>
                                            </div>
                                            <span class="ec-price">
                                                <span class="old-price">$27.00</span>
                                                <span class="new-price">$22.00</span>
                                            </span>
                                            <div class="ec-pro-option">
                                                <div class="ec-pro-color">
                                                    <span class="ec-pro-opt-label">Color</span>
                                                    <ul class="ec-opt-swatch ec-change-img">
                                                        <li class="active"><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/6_1.jpg"
                                                                data-src-hover="web/images/product-image/6_1.jpg"
                                                                data-tooltip="Gray"><span
                                                                    style="background-color:#e8c2ff;"></span></a></li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/6_2.jpg"
                                                                data-src-hover="web/images/product-image/6_2.jpg"
                                                                data-tooltip="Orange"><span
                                                                    style="background-color:#9cfdd5;"></span></a></li>
                                                    </ul>
                                                </div>
                                                <div class="ec-pro-size">
                                                    <span class="ec-pro-opt-label">Size</span>
                                                    <ul class="ec-opt-size">
                                                        <li class="active"><a href="#" class="ec-opt-sz"
                                                                data-old="$25.00" data-new="$20.00"
                                                                data-tooltip="Small">S</a></li>
                                                        <li><a href="#" class="ec-opt-sz" data-old="$27.00"
                                                                data-new="$22.00" data-tooltip="Medium">M</a></li>
                                                        <li><a href="#" class="ec-opt-sz" data-old="$30.00"
                                                                data-new="$25.00" data-tooltip="Large">X</a></li>
                                                        <li><a href="#" class="ec-opt-sz" data-old="$35.00"
                                                                data-new="$30.00" data-tooltip="Extra Large">XL</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 mb-6  ec-product-content"
                                    data-animation="fadeIn">
                                    <div class="ec-product-inner">
                                        <div class="ec-pro-image-outer">
                                            <div class="ec-pro-image">
                                                <a href="product-left-sidebar.html" class="image">
                                                    <img class="main-image" src="web/images/product-image/7_1.jpg"
                                                        alt="Product" />
                                                    <img class="hover-image" src="web/images/product-image/7_2.jpg"
                                                        alt="Product" />
                                                </a>
                                                <span class="flags">
                                                    <span class="sale">Sale</span>
                                                </span>
                                                <a href="#" class="quickview" data-link-action="quickview"
                                                    title="Quick view" data-bs-toggle="modal"
                                                    data-bs-target="#ec_quickview_modal"><i class="fi-rr-eye"></i></a>
                                                <div class="ec-pro-actions">
                                                    <a href="compare.html" class="ec-btn-group compare"
                                                        title="Compare"><i class="fi fi-rr-arrows-repeat"></i></a>
                                                    <button title="Add To Cart" class="add-to-cart"><i
                                                            class="fi-rr-shopping-basket"></i> Add To Cart</button>
                                                    <a class="ec-btn-group wishlist" title="Wishlist"><i
                                                            class="fi-rr-heart"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ec-pro-content">
                                            <h5 class="ec-pro-title"><a href="product-left-sidebar.html">Full Sleeve
                                                    Shirt</a></h5>
                                            <div class="ec-pro-rating">
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star"></i>
                                            </div>
                                            <span class="ec-price">
                                                <span class="old-price">$12.00</span>
                                                <span class="new-price">$10.00</span>
                                            </span>
                                            <div class="ec-pro-option">
                                                <div class="ec-pro-color">
                                                    <span class="ec-pro-opt-label">Color</span>
                                                    <ul class="ec-opt-swatch ec-change-img">
                                                        <li class="active"><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/7_1.jpg"
                                                                data-src-hover="web/images/product-image/7_1.jpg"
                                                                data-tooltip="Gray"><span
                                                                    style="background-color:#01f1f1;"></span></a></li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/7_2.jpg"
                                                                data-src-hover="web/images/product-image/7_2.jpg"
                                                                data-tooltip="Orange"><span
                                                                    style="background-color:#b89df8;"></span></a></li>
                                                    </ul>
                                                </div>
                                                <div class="ec-pro-size">
                                                    <span class="ec-pro-opt-label">Size</span>
                                                    <ul class="ec-opt-size">
                                                        <li class="active"><a href="#" class="ec-opt-sz"
                                                                data-old="$12.00" data-new="$10.00"
                                                                data-tooltip="Small">S</a></li>
                                                        <li><a href="#" class="ec-opt-sz" data-old="$15.00"
                                                                data-new="$12.00" data-tooltip="Medium">M</a></li>
                                                        <li><a href="#" class="ec-opt-sz" data-old="$18.00"
                                                                data-new="$15.00" data-tooltip="Large">X</a></li>
                                                        <li><a href="#" class="ec-opt-sz" data-old="$20.00"
                                                                data-new="$17.00" data-tooltip="Extra Large">XL</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 mb-6  ec-product-content"
                                    data-animation="fadeIn">
                                    <div class="ec-product-inner">
                                        <div class="ec-pro-image-outer">
                                            <div class="ec-pro-image">
                                                <a href="product-left-sidebar.html" class="image">
                                                    <img class="main-image" src="web/images/product-image/1_1.jpg"
                                                        alt="Product" />
                                                    <img class="hover-image" src="web/images/product-image/1_2.jpg"
                                                        alt="Product" />
                                                </a>
                                                <a href="#" class="quickview" data-link-action="quickview"
                                                    title="Quick view" data-bs-toggle="modal"
                                                    data-bs-target="#ec_quickview_modal"><i class="fi-rr-eye"></i></a>
                                                <div class="ec-pro-actions">
                                                    <a href="compare.html" class="ec-btn-group compare"
                                                        title="Compare"><i class="fi fi-rr-arrows-repeat"></i></a>
                                                    <button title="Add To Cart" class="add-to-cart"><i
                                                            class="fi-rr-shopping-basket"></i> Add To Cart</button>
                                                    <a class="ec-btn-group wishlist" title="Wishlist"><i
                                                            class="fi-rr-heart"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ec-pro-content">
                                            <h5 class="ec-pro-title"><a href="product-left-sidebar.html">Cute Baby
                                                    Toy's</a></h5>
                                            <div class="ec-pro-rating">
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star"></i>
                                            </div>
                                            <span class="ec-price">
                                                <span class="old-price">$40.00</span>
                                                <span class="new-price">$30.00</span>
                                            </span>
                                            <div class="ec-pro-option">
                                                <div class="ec-pro-color">
                                                    <span class="ec-pro-opt-label">Color</span>
                                                    <ul class="ec-opt-swatch ec-change-img">
                                                        <li class="active"><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/1_1.jpg"
                                                                data-src-hover="web/images/product-image/1_1.jpg"
                                                                data-tooltip="Gray"><span
                                                                    style="background-color:#90cdf7;"></span></a></li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/1_2.jpg"
                                                                data-src-hover="web/images/product-image/1_2.jpg"
                                                                data-tooltip="Orange"><span
                                                                    style="background-color:#ff3b66;"></span></a></li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/1_3.jpg"
                                                                data-src-hover="web/images/product-image/1_3.jpg"
                                                                data-tooltip="Green"><span
                                                                    style="background-color:#ffc476;"></span></a></li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/1_4.jpg"
                                                                data-src-hover="web/images/product-image/1_4.jpg"
                                                                data-tooltip="Sky Blue"><span
                                                                    style="background-color:#1af0ba;"></span></a></li>
                                                    </ul>
                                                </div>
                                                <div class="ec-pro-size">
                                                    <span class="ec-pro-opt-label">Size</span>
                                                    <ul class="ec-opt-size">
                                                        <li class="active"><a href="#" class="ec-opt-sz"
                                                                data-old="$40.00" data-new="$30.00"
                                                                data-tooltip="Small">S</a></li>
                                                        <li><a href="#" class="ec-opt-sz" data-old="$50.00"
                                                                data-new="$40.00" data-tooltip="Medium">M</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 mb-6  ec-product-content"
                                    data-animation="fadeIn">
                                    <div class="ec-product-inner">
                                        <div class="ec-pro-image-outer">
                                            <div class="ec-pro-image">
                                                <a href="product-left-sidebar.html" class="image">
                                                    <img class="main-image" src="web/images/product-image/2_1.jpg"
                                                        alt="Product" />
                                                    <img class="hover-image" src="web/images/product-image/2_2.jpg"
                                                        alt="Product" />
                                                </a>
                                                <span class="flags">
                                                    <span class="new">New</span>
                                                </span>
                                                <a href="#" class="quickview" data-link-action="quickview"
                                                    title="Quick view" data-bs-toggle="modal"
                                                    data-bs-target="#ec_quickview_modal"><i class="fi-rr-eye"></i></a>
                                                <div class="ec-pro-actions">
                                                    <a href="compare.html" class="ec-btn-group compare"
                                                        title="Compare"><i class="fi fi-rr-arrows-repeat"></i></a>
                                                    <button title="Add To Cart" class="add-to-cart"><i
                                                            class="fi-rr-shopping-basket"></i> Add To Cart</button>
                                                    <a class="ec-btn-group wishlist" title="Wishlist"><i
                                                            class="fi-rr-heart"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ec-pro-content">
                                            <h5 class="ec-pro-title"><a href="product-left-sidebar.html">Jumbo Carry
                                                    Bag</a></h5>
                                            <div class="ec-pro-rating">
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star"></i>
                                            </div>
                                            <span class="ec-price">
                                                <span class="old-price">$50.00</span>
                                                <span class="new-price">$40.00</span>
                                            </span>
                                            <div class="ec-pro-option">
                                                <div class="ec-pro-color">
                                                    <span class="ec-pro-opt-label">Color</span>
                                                    <ul class="ec-opt-swatch ec-change-img">
                                                        <li class="active"><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/2_1.jpg"
                                                                data-src-hover="web/images/product-image/2_2.jpg"
                                                                data-tooltip="Gray"><span
                                                                    style="background-color:#fdbf04;"></span></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 mb-6  ec-product-content"
                                    data-animation="fadeIn">
                                    <div class="ec-product-inner">
                                        <div class="ec-pro-image-outer">
                                            <div class="ec-pro-image">
                                                <a href="product-left-sidebar.html" class="image">
                                                    <img class="main-image" src="web/images/product-image/3_1.jpg"
                                                        alt="Product" />
                                                    <img class="hover-image" src="web/images/product-image/3_2.jpg"
                                                        alt="Product" />
                                                </a>
                                                <span class="percentage">15%</span>
                                                <a href="#" class="quickview" data-link-action="quickview"
                                                    title="Quick view" data-bs-toggle="modal"
                                                    data-bs-target="#ec_quickview_modal"><i class="fi-rr-eye"></i></a>
                                                <div class="ec-pro-actions">
                                                    <a href="compare.html" class="ec-btn-group compare"
                                                        title="Compare"><i class="fi fi-rr-arrows-repeat"></i></a>
                                                    <button title="Add To Cart" class="add-to-cart"><i
                                                            class="fi-rr-shopping-basket"></i> Add To Cart</button>
                                                    <a class="ec-btn-group wishlist" title="Wishlist"><i
                                                            class="fi-rr-heart"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ec-pro-content">
                                            <h5 class="ec-pro-title"><a href="product-left-sidebar.html">Designer
                                                    Leather Purses</a></h5>
                                            <div class="ec-pro-rating">
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star"></i>
                                            </div>
                                            <span class="ec-price">
                                                <span class="old-price">$40.00</span>
                                                <span class="new-price">$30.00</span>
                                            </span>
                                            <div class="ec-pro-option">
                                                <div class="ec-pro-color">
                                                    <span class="ec-pro-opt-label">Color</span>
                                                    <ul class="ec-opt-swatch ec-change-img">
                                                        <li class="active"><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/3_1.jpg"
                                                                data-src-hover="web/images/product-image/3_1.jpg"
                                                                data-tooltip="Gray"><span
                                                                    style="background-color:#75e3ff;"></span></a></li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/3_2.jpg"
                                                                data-src-hover="web/images/product-image/3_2.jpg"
                                                                data-tooltip="Orange"><span
                                                                    style="background-color:#11f7d8;"></span></a></li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/3_3.jpg"
                                                                data-src-hover="web/images/product-image/3_3.jpg"
                                                                data-tooltip="Green"><span
                                                                    style="background-color:#acff7c;"></span></a></li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/3_5.jpg"
                                                                data-src-hover="web/images/product-image/3_5.jpg"
                                                                data-tooltip="Sky Blue"><span
                                                                    style="background-color:#e996fa;"></span></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 mb-6  ec-product-content"
                                    data-animation="fadeIn">
                                    <div class="ec-product-inner">
                                        <div class="ec-pro-image-outer">
                                            <div class="ec-pro-image">
                                                <a href="product-left-sidebar.html" class="image">
                                                    <img class="main-image" src="web/images/product-image/4_1.jpg"
                                                        alt="Product" />
                                                    <img class="hover-image" src="web/images/product-image/4_2.jpg"
                                                        alt="Product" />
                                                </a>
                                                <a href="#" class="quickview" data-link-action="quickview"
                                                    title="Quick view" data-bs-toggle="modal"
                                                    data-bs-target="#ec_quickview_modal"><i class="fi-rr-eye"></i></a>
                                                <div class="ec-pro-actions">
                                                    <a href="compare.html" class="ec-btn-group compare"
                                                        title="Compare"><i class="fi fi-rr-arrows-repeat"></i></a>
                                                    <button title="Add To Cart" class="add-to-cart"><i
                                                            class="fi-rr-shopping-basket"></i> Add To Cart</button>
                                                    <a class="ec-btn-group wishlist" title="Wishlist"><i
                                                            class="fi-rr-heart"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ec-pro-content">
                                            <h5 class="ec-pro-title"><a href="product-left-sidebar.html">Canvas Cowboy
                                                    Hat</a></h5>
                                            <div class="ec-pro-rating">
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star"></i>
                                            </div>
                                            <span class="ec-price">
                                                <span class="old-price">$12.00</span>
                                                <span class="new-price">$10.00</span>
                                            </span>
                                            <div class="ec-pro-option">
                                                <div class="ec-pro-color">
                                                    <span class="ec-pro-opt-label">Color</span>
                                                    <ul class="ec-opt-swatch ec-change-img">
                                                        <li class="active"><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/4_1.jpg"
                                                                data-src-hover="web/images/product-image/4_1.jpg"
                                                                data-tooltip="Gray"><span
                                                                    style="background-color:#ebbf60;"></span></a></li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/4_2.jpg"
                                                                data-src-hover="web/images/product-image/4_2.jpg"
                                                                data-tooltip="Orange"><span
                                                                    style="background-color:#b4fc57;"></span></a></li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/4_3.jpg"
                                                                data-src-hover="web/images/product-image/4_3.jpg"
                                                                data-tooltip="Green"><span
                                                                    style="background-color:#2ea1cd;"></span></a></li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/4_4.jpg"
                                                                data-src-hover="web/images/product-image/4_4.jpg"
                                                                data-tooltip="Sky Blue"><span
                                                                    style="background-color:#c1a1fd;"></span></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 mb-6  ec-product-content"
                                    data-animation="fadeIn">
                                    <div class="ec-product-inner">
                                        <div class="ec-pro-image-outer">
                                            <div class="ec-pro-image">
                                                <a href="product-left-sidebar.html" class="image">
                                                    <img class="main-image" src="web/images/product-image/5_1.jpg"
                                                        alt="Product" />
                                                    <img class="hover-image" src="web/images/product-image/5_2.jpg"
                                                        alt="Product" />
                                                </a>
                                                <span class="flags">
                                                    <span class="new">New</span>
                                                </span>
                                                <a href="#" class="quickview" data-link-action="quickview"
                                                    title="Quick view" data-bs-toggle="modal"
                                                    data-bs-target="#ec_quickview_modal"><i class="fi-rr-eye"></i></a>
                                                <div class="ec-pro-actions">
                                                    <a href="compare.html" class="ec-btn-group compare"
                                                        title="Compare"><i class="fi fi-rr-arrows-repeat"></i></a>
                                                    <button title="Add To Cart" class="add-to-cart"><i
                                                            class="fi-rr-shopping-basket"></i> Add To Cart</button>
                                                    <a class="ec-btn-group wishlist" title="Wishlist"><i
                                                            class="fi-rr-heart"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ec-pro-content">
                                            <h5 class="ec-pro-title"><a href="product-left-sidebar.html">Leather Belt
                                                    for Men</a></h5>
                                            <div class="ec-pro-rating">
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star"></i>
                                            </div>
                                            <span class="ec-price">
                                                <span class="old-price">$15.00</span>
                                                <span class="new-price">$10.00</span>
                                            </span>
                                            <div class="ec-pro-option">
                                                <div class="ec-pro-color">
                                                    <span class="ec-pro-opt-label">Color</span>
                                                    <ul class="ec-opt-swatch ec-change-img">
                                                        <li class="active"><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/5_1.jpg"
                                                                data-src-hover="web/images/product-image/5_1.jpg"
                                                                data-tooltip="Gray"><span
                                                                    style="background-color:#9e9e9e;"></span></a></li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/5_2.jpg"
                                                                data-src-hover="web/images/product-image/5_2.jpg"
                                                                data-tooltip="Orange"><span
                                                                    style="background-color:#eb8e76;"></span></a></li>
                                                    </ul>
                                                </div>
                                                <div class="ec-pro-size">
                                                    <span class="ec-pro-opt-label">Size</span>
                                                    <ul class="ec-opt-size">
                                                        <li class="active"><a href="#" class="ec-opt-sz"
                                                                data-old="$15.00" data-new="$10.00"
                                                                data-tooltip="Small">32</a></li>
                                                        <li><a href="#" class="ec-opt-sz" data-old="$17.00"
                                                                data-new="$12.00" data-tooltip="Medium">34</a></li>
                                                        <li><a href="#" class="ec-opt-sz" data-old="$20.00"
                                                                data-new="$15.00" data-tooltip="Large">36</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 mb-6  ec-product-content"
                                    data-animation="fadeIn">
                                    <div class="ec-product-inner">
                                        <div class="ec-pro-image-outer">
                                            <div class="ec-pro-image">
                                                <a href="product-left-sidebar.html" class="image">
                                                    <img class="main-image" src="web/images/product-image/8_1.jpg"
                                                        alt="Product" />
                                                    <img class="hover-image" src="web/images/product-image/8_2.jpg"
                                                        alt="Product" />
                                                </a>
                                                <span class="percentage">35%</span>
                                                <span class="flags">
                                                    <span class="new">New</span>
                                                </span>
                                                <a href="#" class="quickview" data-link-action="quickview"
                                                    title="Quick view" data-bs-toggle="modal"
                                                    data-bs-target="#ec_quickview_modal"><i class="fi-rr-eye"></i></a>
                                                <div class="ec-pro-actions">
                                                    <a href="compare.html" class="ec-btn-group compare"
                                                        title="Compare"><i class="fi fi-rr-arrows-repeat"></i></a>
                                                    <button title="Add To Cart" class="add-to-cart"><i
                                                            class="fi-rr-shopping-basket"></i> Add To Cart</button>
                                                    <a class="ec-btn-group wishlist" title="Wishlist"><i
                                                            class="fi-rr-heart"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ec-pro-content">
                                            <h5 class="ec-pro-title"><a href="product-left-sidebar.html">Digital Smart
                                                    Watches</a></h5>
                                            <div class="ec-pro-rating">
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star"></i>
                                            </div>
                                            <span class="ec-price">
                                                <span class="old-price">$100.00</span>
                                                <span class="new-price">$80.00</span>
                                            </span>
                                            <div class="ec-pro-option">
                                                <div class="ec-pro-color">
                                                    <span class="ec-pro-opt-label">Color</span>
                                                    <ul class="ec-opt-swatch ec-change-img">
                                                        <li class="active"><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/8_2.jpg"
                                                                data-src-hover="web/images/product-image/8_2.jpg"
                                                                data-tooltip="Gray"><span
                                                                    style="background-color:#e9dddd;"></span></a></li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/8_3.jpg"
                                                                data-src-hover="web/images/product-image/8_3.jpg"
                                                                data-tooltip="Orange"><span
                                                                    style="background-color:#ffd5cb;"></span></a></li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/8_4.jpg"
                                                                data-src-hover="web/images/product-image/8_4.jpg"
                                                                data-tooltip="Green"><span
                                                                    style="background-color:#92e4fd;"></span></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 shop-all-btn"><a href="shop-left-sidebar-col-3.html">Shop All
                                        Collection</a></div>
                            </div>
                        </div>
                        <!-- ec 1st Product tab end -->
                        <!-- ec 2nd Product tab start -->
                        <div class="tab-pane fade" id="tab-pro-for-men">
                            <div class="row">
                                <!-- Product Content -->
                                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 mb-6  ec-product-content">
                                    <div class="ec-product-inner">
                                        <div class="ec-pro-image-outer">
                                            <div class="ec-pro-image">
                                                <a href="product-left-sidebar.html" class="image">
                                                    <img class="main-image" src="web/images/product-image/6_1.jpg"
                                                        alt="Product" />
                                                    <img class="hover-image" src="web/images/product-image/6_2.jpg"
                                                        alt="Product" />
                                                </a>
                                                <span class="percentage">20%</span>
                                                <a href="#" class="quickview" data-link-action="quickview"
                                                    title="Quick view" data-bs-toggle="modal"
                                                    data-bs-target="#ec_quickview_modal"><i class="fi-rr-eye"></i></a>
                                                <div class="ec-pro-actions">
                                                    <a href="compare.html" class="ec-btn-group compare"
                                                        title="Compare"><i class="fi fi-rr-arrows-repeat"></i></a>
                                                    <button title="Add To Cart" class="add-to-cart"><i
                                                            class="fi-rr-shopping-basket"></i> Add To Cart</button>
                                                    <a class="ec-btn-group wishlist" title="Wishlist"><i
                                                            class="fi-rr-heart"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ec-pro-content">
                                            <h5 class="ec-pro-title"><a href="product-left-sidebar.html">Round Neck
                                                    T-Shirt</a></h5>
                                            <div class="ec-pro-rating">
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star"></i>
                                            </div>
                                            <span class="ec-price">
                                                <span class="old-price">$30.00</span>
                                                <span class="new-price">$25.00</span>
                                            </span>
                                            <div class="ec-pro-option">
                                                <div class="ec-pro-color">
                                                    <span class="ec-pro-opt-label">Color</span>
                                                    <ul class="ec-opt-swatch ec-change-img">
                                                        <li class="active"><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/6_1.jpg"
                                                                data-src-hover="web/images/product-image/6_1.jpg"
                                                                data-tooltip="Gray"><span
                                                                    style="background-color:#e8c2ff;"></span></a></li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/6_2.jpg"
                                                                data-src-hover="web/images/product-image/6_2.jpg"
                                                                data-tooltip="Orange"><span
                                                                    style="background-color:#9cfdd5;"></span></a></li>
                                                    </ul>
                                                </div>
                                                <div class="ec-pro-size">
                                                    <span class="ec-pro-opt-label">Size</span>
                                                    <ul class="ec-opt-size">
                                                        <li class="active"><a href="#" class="ec-opt-sz"
                                                                data-old="$25.00" data-new="$20.00"
                                                                data-tooltip="Small">S</a></li>
                                                        <li><a href="#" class="ec-opt-sz" data-old="$27.00"
                                                                data-new="$22.00" data-tooltip="Medium">M</a></li>
                                                        <li><a href="#" class="ec-opt-sz" data-old="$30.00"
                                                                data-new="$25.00" data-tooltip="Large">X</a></li>
                                                        <li><a href="#" class="ec-opt-sz" data-old="$35.00"
                                                                data-new="$30.00" data-tooltip="Extra Large">XL</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 mb-6  ec-product-content">
                                    <div class="ec-product-inner">
                                        <div class="ec-pro-image-outer">
                                            <div class="ec-pro-image">
                                                <a href="product-left-sidebar.html" class="image">
                                                    <img class="main-image" src="web/images/product-image/7_1.jpg"
                                                        alt="Product" />
                                                    <img class="hover-image" src="web/images/product-image/7_2.jpg"
                                                        alt="Product" />
                                                </a>
                                                <span class="percentage">20%</span>
                                                <span class="flags">
                                                    <span class="sale">Sale</span>
                                                </span>
                                                <a href="#" class="quickview" data-link-action="quickview"
                                                    title="Quick view" data-bs-toggle="modal"
                                                    data-bs-target="#ec_quickview_modal"><i class="fi-rr-eye"></i></a>
                                                <div class="ec-pro-actions">
                                                    <a href="compare.html" class="ec-btn-group compare"
                                                        title="Compare"><i class="fi fi-rr-arrows-repeat"></i></a>
                                                    <button title="Add To Cart" class="add-to-cart"><i
                                                            class="fi-rr-shopping-basket"></i> Add To Cart</button>
                                                    <a class="ec-btn-group wishlist" title="Wishlist"><i
                                                            class="fi-rr-heart"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ec-pro-content">
                                            <h5 class="ec-pro-title"><a href="product-left-sidebar.html">Full Sleeve
                                                    Shirt</a></h5>
                                            <div class="ec-pro-rating">
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star"></i>
                                            </div>
                                            <span class="ec-price">
                                                <span class="old-price">$12.00</span>
                                                <span class="new-price">$10.00</span>
                                            </span>
                                            <div class="ec-pro-option">
                                                <div class="ec-pro-color">
                                                    <span class="ec-pro-opt-label">Color</span>
                                                    <ul class="ec-opt-swatch ec-change-img">
                                                        <li class="active"><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/7_1.jpg"
                                                                data-src-hover="web/images/product-image/7_1.jpg"
                                                                data-tooltip="Gray"><span
                                                                    style="background-color:#01f1f1;"></span></a></li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/7_2.jpg"
                                                                data-src-hover="web/images/product-image/7_2.jpg"
                                                                data-tooltip="Orange"><span
                                                                    style="background-color:#b89df8;"></span></a></li>
                                                    </ul>
                                                </div>
                                                <div class="ec-pro-size">
                                                    <span class="ec-pro-opt-label">Size</span>
                                                    <ul class="ec-opt-size">
                                                        <li class="active"><a href="#" class="ec-opt-sz"
                                                                data-old="$12.00" data-new="$10.00"
                                                                data-tooltip="Small">S</a></li>
                                                        <li><a href="#" class="ec-opt-sz" data-old="$15.00"
                                                                data-new="$12.00" data-tooltip="Medium">M</a></li>
                                                        <li><a href="#" class="ec-opt-sz" data-old="$18.00"
                                                                data-new="$15.00" data-tooltip="Large">X</a></li>
                                                        <li><a href="#" class="ec-opt-sz" data-old="$20.00"
                                                                data-new="$17.00" data-tooltip="Extra Large">XL</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 mb-6  ec-product-content">
                                    <div class="ec-product-inner">
                                        <div class="ec-pro-image-outer">
                                            <div class="ec-pro-image">
                                                <a href="product-left-sidebar.html" class="image">
                                                    <img class="main-image" src="web/images/product-image/2_1.jpg"
                                                        alt="Product" />
                                                    <img class="hover-image" src="web/images/product-image/2_2.jpg"
                                                        alt="Product" />
                                                </a>
                                                <span class="percentage">20%</span>
                                                <span class="flags">
                                                    <span class="new">New</span>
                                                </span>
                                                <a href="#" class="quickview" data-link-action="quickview"
                                                    title="Quick view" data-bs-toggle="modal"
                                                    data-bs-target="#ec_quickview_modal"><i class="fi-rr-eye"></i></a>
                                                <div class="ec-pro-actions">
                                                    <a href="compare.html" class="ec-btn-group compare"
                                                        title="Compare"><i class="fi fi-rr-arrows-repeat"></i></a>
                                                    <button title="Add To Cart" class="add-to-cart"><i
                                                            class="fi-rr-shopping-basket"></i> Add To Cart</button>
                                                    <a class="ec-btn-group wishlist" title="Wishlist"><i
                                                            class="fi-rr-heart"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ec-pro-content">
                                            <h5 class="ec-pro-title"><a href="product-left-sidebar.html">Jumbo Carry
                                                    Bag</a></h5>
                                            <div class="ec-pro-rating">
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star"></i>
                                            </div>
                                            <span class="ec-price">
                                                <span class="old-price">$40.00</span>
                                                <span class="new-price">$20.00</span>
                                            </span>
                                            <div class="ec-pro-option">
                                                <div class="ec-pro-color">
                                                    <span class="ec-pro-opt-label">Color</span>
                                                    <ul class="ec-opt-swatch ec-change-img">
                                                        <li class="active"><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/2_1.jpg"
                                                                data-src-hover="web/images/product-image/2_2.jpg"
                                                                data-tooltip="Gray"><span
                                                                    style="background-color:#fdbf04;"></span></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 mb-6  ec-product-content">
                                    <div class="ec-product-inner">
                                        <div class="ec-pro-image-outer">
                                            <div class="ec-pro-image">
                                                <a href="product-left-sidebar.html" class="image">
                                                    <img class="main-image" src="web/images/product-image/4_1.jpg"
                                                        alt="Product" />
                                                    <img class="hover-image" src="web/images/product-image/4_2.jpg"
                                                        alt="Product" />
                                                </a>
                                                <a href="#" class="quickview" data-link-action="quickview"
                                                    title="Quick view" data-bs-toggle="modal"
                                                    data-bs-target="#ec_quickview_modal"><i class="fi-rr-eye"></i></a>
                                                <div class="ec-pro-actions">
                                                    <a href="compare.html" class="ec-btn-group compare"
                                                        title="Compare"><i class="fi fi-rr-arrows-repeat"></i></a>
                                                    <button title="Add To Cart" class="add-to-cart"><i
                                                            class="fi-rr-shopping-basket"></i> Add To Cart</button>
                                                    <a class="ec-btn-group wishlist" title="Wishlist"><i
                                                            class="fi-rr-heart"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ec-pro-content">
                                            <h5 class="ec-pro-title"><a href="product-left-sidebar.html">Canvas Cowboy
                                                    Hat</a></h5>
                                            <div class="ec-pro-rating">
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star"></i>
                                            </div>
                                            <span class="ec-price">
                                                <span class="old-price">$12.00</span>
                                                <span class="new-price">$10.00</span>
                                            </span>
                                            <div class="ec-pro-option">
                                                <div class="ec-pro-color">
                                                    <span class="ec-pro-opt-label">Color</span>
                                                    <ul class="ec-opt-swatch ec-change-img">
                                                        <li class="active"><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/4_1.jpg"
                                                                data-src-hover="web/images/product-image/4_1.jpg"
                                                                data-tooltip="Gray"><span
                                                                    style="background-color:#ebbf60;"></span></a></li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/4_2.jpg"
                                                                data-src-hover="web/images/product-image/4_2.jpg"
                                                                data-tooltip="Orange"><span
                                                                    style="background-color:#b4fc57;"></span></a></li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/4_3.jpg"
                                                                data-src-hover="web/images/product-image/4_3.jpg"
                                                                data-tooltip="Green"><span
                                                                    style="background-color:#2ea1cd;"></span></a></li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/4_4.jpg"
                                                                data-src-hover="web/images/product-image/4_4.jpg"
                                                                data-tooltip="Sky Blue"><span
                                                                    style="background-color:#c1a1fd;"></span></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 mb-6  ec-product-content">
                                    <div class="ec-product-inner">
                                        <div class="ec-pro-image-outer">
                                            <div class="ec-pro-image">
                                                <a href="product-left-sidebar.html" class="image">
                                                    <img class="main-image" src="web/images/product-image/5_1.jpg"
                                                        alt="Product" />
                                                    <img class="hover-image" src="web/images/product-image/5_2.jpg"
                                                        alt="Product" />
                                                </a>
                                                <span class="flags">
                                                    <span class="new">New</span>
                                                </span>
                                                <a href="#" class="quickview" data-link-action="quickview"
                                                    title="Quick view" data-bs-toggle="modal"
                                                    data-bs-target="#ec_quickview_modal"><i class="fi-rr-eye"></i></a>
                                                <div class="ec-pro-actions">
                                                    <a href="compare.html" class="ec-btn-group compare"
                                                        title="Compare"><i class="fi fi-rr-arrows-repeat"></i></a>
                                                    <button title="Add To Cart" class="add-to-cart"><i
                                                            class="fi-rr-shopping-basket"></i> Add To Cart</button>
                                                    <a class="ec-btn-group wishlist" title="Wishlist"><i
                                                            class="fi-rr-heart"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ec-pro-content">
                                            <h5 class="ec-pro-title"><a href="product-left-sidebar.html">Leather
                                                    Belt
                                                    for Men</a></h5>
                                            <div class="ec-pro-rating">
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star"></i>
                                            </div>
                                            <span class="ec-price">
                                                <span class="old-price">$15.00</span>
                                                <span class="new-price">$10.00</span>
                                            </span>
                                            <div class="ec-pro-option">
                                                <div class="ec-pro-color">
                                                    <span class="ec-pro-opt-label">Color</span>
                                                    <ul class="ec-opt-swatch ec-change-img">
                                                        <li class="active"><a href="#"
                                                                class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/5_1.jpg"
                                                                data-src-hover="web/images/product-image/5_1.jpg"
                                                                data-tooltip="Gray"><span
                                                                    style="background-color:#9e9e9e;"></span></a></li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/5_2.jpg"
                                                                data-src-hover="web/images/product-image/5_2.jpg"
                                                                data-tooltip="Orange"><span
                                                                    style="background-color:#eb8e76;"></span></a></li>
                                                    </ul>
                                                </div>
                                                <div class="ec-pro-size">
                                                    <span class="ec-pro-opt-label">Size</span>
                                                    <ul class="ec-opt-size">
                                                        <li class="active"><a href="#" class="ec-opt-sz"
                                                                data-old="$15.00" data-new="$10.00"
                                                                data-tooltip="Small">32</a></li>
                                                        <li><a href="#" class="ec-opt-sz" data-old="$17.00"
                                                                data-new="$12.00" data-tooltip="Medium">34</a></li>
                                                        <li><a href="#" class="ec-opt-sz" data-old="$20.00"
                                                                data-new="$15.00" data-tooltip="Large">36</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 mb-6  ec-product-content">
                                    <div class="ec-product-inner">
                                        <div class="ec-pro-image-outer">
                                            <div class="ec-pro-image">
                                                <a href="product-left-sidebar.html" class="image">
                                                    <img class="main-image" src="web/images/product-image/8_1.jpg"
                                                        alt="Product" />
                                                    <img class="hover-image" src="web/images/product-image/8_2.jpg"
                                                        alt="Product" />
                                                </a>
                                                <span class="percentage">20%</span>
                                                <span class="flags">
                                                    <span class="new">New</span>
                                                </span>
                                                <a href="#" class="quickview" data-link-action="quickview"
                                                    title="Quick view" data-bs-toggle="modal"
                                                    data-bs-target="#ec_quickview_modal"><i
                                                        class="fi-rr-eye"></i></a>
                                                <div class="ec-pro-actions">
                                                    <a href="compare.html" class="ec-btn-group compare"
                                                        title="Compare"><i class="fi fi-rr-arrows-repeat"></i></a>
                                                    <button title="Add To Cart" class="add-to-cart"><i
                                                            class="fi-rr-shopping-basket"></i> Add To Cart</button>
                                                    <a class="ec-btn-group wishlist" title="Wishlist"><i
                                                            class="fi-rr-heart"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ec-pro-content">
                                            <h5 class="ec-pro-title"><a href="product-left-sidebar.html">Digital
                                                    Smart
                                                    Watches</a></h5>
                                            <div class="ec-pro-rating">
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star"></i>
                                            </div>
                                            <span class="ec-price">
                                                <span class="old-price">$100.00</span>
                                                <span class="new-price">$80.00</span>
                                            </span>
                                            <div class="ec-pro-option">
                                                <div class="ec-pro-color">
                                                    <span class="ec-pro-opt-label">Color</span>
                                                    <ul class="ec-opt-swatch ec-change-img">
                                                        <li class="active"><a href="#"
                                                                class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/8_2.jpg"
                                                                data-src-hover="web/images/product-image/8_2.jpg"
                                                                data-tooltip="Gray"><span
                                                                    style="background-color:#e9dddd;"></span></a></li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/8_3.jpg"
                                                                data-src-hover="web/images/product-image/8_3.jpg"
                                                                data-tooltip="Orange"><span
                                                                    style="background-color:#ffd5cb;"></span></a></li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/8_4.jpg"
                                                                data-src-hover="web/images/product-image/8_4.jpg"
                                                                data-tooltip="Green"><span
                                                                    style="background-color:#92e4fd;"></span></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 mb-6  ec-product-content">
                                    <div class="ec-product-inner">
                                        <div class="ec-pro-image-outer">
                                            <div class="ec-pro-image">
                                                <a href="product-left-sidebar.html" class="image">
                                                    <img class="main-image" src="web/images/product-image/10_1.jpg"
                                                        alt="Product" />
                                                    <img class="hover-image" src="web/images/product-image/10_2.jpg"
                                                        alt="Product" />
                                                </a>
                                                <span class="percentage">20%</span>
                                                <span class="flags">
                                                    <span class="sale">Sale</span>
                                                </span>
                                                <a href="#" class="quickview" data-link-action="quickview"
                                                    title="Quick view" data-bs-toggle="modal"
                                                    data-bs-target="#ec_quickview_modal"><i
                                                        class="fi-rr-eye"></i></a>
                                                <div class="ec-pro-actions">
                                                    <a href="compare.html" class="ec-btn-group compare"
                                                        title="Compare"><i class="fi fi-rr-arrows-repeat"></i></a>
                                                    <button title="Add To Cart" class="add-to-cart"><i
                                                            class="fi-rr-shopping-basket"></i> Add To Cart</button>
                                                    <a class="ec-btn-group wishlist" title="Wishlist"><i
                                                            class="fi-rr-heart"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ec-pro-content">
                                            <h5 class="ec-pro-title"><a href="product-left-sidebar.html">Canvas
                                                    Shoes
                                                    for Men</a></h5>
                                            <div class="ec-pro-rating">
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star"></i>
                                            </div>
                                            <span class="ec-price">
                                                <span class="old-price">$30.00</span>
                                                <span class="new-price">$25.00</span>
                                            </span>
                                            <div class="ec-pro-option">
                                                <div class="ec-pro-color">
                                                    <span class="ec-pro-opt-label">Color</span>
                                                    <ul class="ec-opt-swatch ec-change-img">
                                                        <li class="active"><a href="#"
                                                                class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/10_1.jpg"
                                                                data-src-hover="web/images/product-image/10_1.jpg"
                                                                data-tooltip="Gray"><span
                                                                    style="background-color:#41d49c;"></span></a></li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/10_2.jpg"
                                                                data-src-hover="web/images/product-image/10_2.jpg"
                                                                data-tooltip="Orange"><span
                                                                    style="background-color:#fc8484;"></span></a></li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/10_3.jpg"
                                                                data-src-hover="web/images/product-image/10_3.jpg"
                                                                data-tooltip="Green"><span
                                                                    style="background-color:#db94f7;"></span></a></li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/10_4.jpg"
                                                                data-src-hover="web/images/product-image/10_4.jpg"
                                                                data-tooltip="Sky Blue"><span
                                                                    style="background-color:#24da0c;"></span></a></li>
                                                    </ul>
                                                </div>
                                                <div class="ec-pro-size">
                                                    <span class="ec-pro-opt-label">Size</span>
                                                    <ul class="ec-opt-size">
                                                        <li class="active"><a href="#" class="ec-opt-sz"
                                                                data-old="$30.00" data-new="$25.00"
                                                                data-tooltip="Small">6</a></li>
                                                        <li><a href="#" class="ec-opt-sz" data-old="$35.00"
                                                                data-new="$27.00" data-tooltip="Medium">7</a></li>
                                                        <li><a href="#" class="ec-opt-sz" data-old="$40.00"
                                                                data-new="$30.00" data-tooltip="Large">8</a></li>
                                                        <li><a href="#" class="ec-opt-sz" data-old="$45.00"
                                                                data-new="$35.00" data-tooltip="Extra Large">9</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 mb-6  ec-product-content">
                                    <div class="ec-product-inner">
                                        <div class="ec-pro-image-outer">
                                            <div class="ec-pro-image">
                                                <a href="product-left-sidebar.html" class="image">
                                                    <img class="main-image" src="web/images/product-image/9_1.jpg"
                                                        alt="Product" />
                                                    <img class="hover-image" src="web/images/product-image/9_2.jpg"
                                                        alt="Product" />
                                                </a>
                                                <span class="percentage">20%</span>
                                                <span class="flags">
                                                    <span class="sale">Sale</span>
                                                </span>
                                                <a href="#" class="quickview" data-link-action="quickview"
                                                    title="Quick view" data-bs-toggle="modal"
                                                    data-bs-target="#ec_quickview_modal"><i
                                                        class="fi-rr-eye"></i></a>
                                                <div class="ec-pro-actions">
                                                    <a href="compare.html" class="ec-btn-group compare"
                                                        title="Compare"><i class="fi fi-rr-arrows-repeat"></i></a>
                                                    <button title="Add To Cart" class="add-to-cart"><i
                                                            class="fi-rr-shopping-basket"></i> Add To Cart</button>
                                                    <a class="ec-btn-group wishlist" title="Wishlist"><i
                                                            class="fi-rr-heart"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ec-pro-content">
                                            <h5 class="ec-pro-title"><a href="product-left-sidebar.html">Full Sleeve
                                                    T-Shirt</a></h5>
                                            <div class="ec-pro-rating">
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star"></i>
                                            </div>
                                            <span class="ec-price">
                                                <span class="old-price">$30.00</span>
                                                <span class="new-price">$25.00</span>
                                            </span>
                                            <div class="ec-pro-option">
                                                <div class="ec-pro-color">
                                                    <span class="ec-pro-opt-label">Color</span>
                                                    <ul class="ec-opt-swatch ec-change-img">
                                                        <li class="active"><a href="#"
                                                                class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/9_1.jpg"
                                                                data-src-hover="web/images/product-image/9_1.jpg"
                                                                data-tooltip="Gray"><span
                                                                    style="background-color:#21b7fc;"></span></a></li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/9_2.jpg"
                                                                data-src-hover="web/images/product-image/9_2.jpg"
                                                                data-tooltip="Orange"><span
                                                                    style="background-color:#1df0ff;"></span></a></li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/9_3.jpg"
                                                                data-src-hover="web/images/product-image/9_3.jpg"
                                                                data-tooltip="Green"><span
                                                                    style="background-color:#94f7a1;"></span></a></li>
                                                    </ul>
                                                </div>
                                                <div class="ec-pro-size">
                                                    <span class="ec-pro-opt-label">Size</span>
                                                    <ul class="ec-opt-size">
                                                        <li class="active"><a href="#" class="ec-opt-sz"
                                                                data-old="$30.00" data-new="$25.00"
                                                                data-tooltip="Small">S</a></li>
                                                        <li><a href="#" class="ec-opt-sz" data-old="$35.00"
                                                                data-new="$27.00" data-tooltip="Medium">M</a></li>
                                                        <li><a href="#" class="ec-opt-sz" data-old="$40.00"
                                                                data-new="$30.00" data-tooltip="Large">X</a></li>
                                                        <li><a href="#" class="ec-opt-sz" data-old="$45.00"
                                                                data-new="$35.00" data-tooltip="Extra Large">XL</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 shop-all-btn"><a href="shop-left-sidebar-col-3.html">Shop All
                                        Collection</a></div>
                            </div>
                        </div>
                        <!-- ec 2nd Product tab end -->
                        <!-- ec 3rd Product tab start -->
                        <div class="tab-pane fade" id="tab-pro-for-women">
                            <div class="row">
                                <!-- Product Content -->
                                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 mb-6  ec-product-content">
                                    <div class="ec-product-inner">
                                        <div class="ec-pro-image-outer">
                                            <div class="ec-pro-image">
                                                <a href="product-left-sidebar.html" class="image">
                                                    <img class="main-image" src="web/images/product-image/9_1.jpg"
                                                        alt="Product" />
                                                    <img class="hover-image" src="web/images/product-image/9_2.jpg"
                                                        alt="Product" />
                                                </a>
                                                <span class="percentage">20%</span>
                                                <span class="flags">
                                                    <span class="sale">Sale</span>
                                                </span>
                                                <a href="#" class="quickview" data-link-action="quickview"
                                                    title="Quick view" data-bs-toggle="modal"
                                                    data-bs-target="#ec_quickview_modal"><i
                                                        class="fi-rr-eye"></i></a>
                                                <div class="ec-pro-actions">
                                                    <a href="compare.html" class="ec-btn-group compare"
                                                        title="Compare"><i class="fi fi-rr-arrows-repeat"></i></a>
                                                    <button title="Add To Cart" class="add-to-cart"><i
                                                            class="fi-rr-shopping-basket"></i> Add To Cart</button>
                                                    <a class="ec-btn-group wishlist" title="Wishlist"><i
                                                            class="fi-rr-heart"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ec-pro-content">
                                            <h5 class="ec-pro-title"><a href="product-left-sidebar.html">Canvas
                                                    Shoes
                                                    for Men</a></h5>
                                            <div class="ec-pro-rating">
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star"></i>
                                            </div>
                                            <span class="ec-price">
                                                <span class="old-price">$30.00</span>
                                                <span class="new-price">$25.00</span>
                                            </span>
                                            <div class="ec-pro-option">
                                                <div class="ec-pro-color">
                                                    <span class="ec-pro-opt-label">Color</span>
                                                    <ul class="ec-opt-swatch ec-change-img">
                                                        <li class="active"><a href="#"
                                                                class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/9_1.jpg"
                                                                data-src-hover="web/images/product-image/9_1.jpg"
                                                                data-tooltip="Gray"><span
                                                                    style="background-color:#21b7fc;"></span></a></li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/9_2.jpg"
                                                                data-src-hover="web/images/product-image/9_2.jpg"
                                                                data-tooltip="Orange"><span
                                                                    style="background-color:#1df0ff;"></span></a></li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/9_3.jpg"
                                                                data-src-hover="web/images/product-image/9_3.jpg"
                                                                data-tooltip="Green"><span
                                                                    style="background-color:#94f7a1;"></span></a></li>
                                                    </ul>
                                                </div>
                                                <div class="ec-pro-size">
                                                    <span class="ec-pro-opt-label">Size</span>
                                                    <ul class="ec-opt-size">
                                                        <li class="active"><a href="#" class="ec-opt-sz"
                                                                data-old="$30.00" data-new="$25.00"
                                                                data-tooltip="Small">S</a></li>
                                                        <li><a href="#" class="ec-opt-sz" data-old="$35.00"
                                                                data-new="$27.00" data-tooltip="Medium">M</a></li>
                                                        <li><a href="#" class="ec-opt-sz" data-old="$40.00"
                                                                data-new="$30.00" data-tooltip="Large">X</a></li>
                                                        <li><a href="#" class="ec-opt-sz" data-old="$45.00"
                                                                data-new="$35.00" data-tooltip="Extra Large">XL</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 mb-6  ec-product-content">
                                    <div class="ec-product-inner">
                                        <div class="ec-pro-image-outer">
                                            <div class="ec-pro-image">
                                                <a href="product-left-sidebar.html" class="image">
                                                    <img class="main-image" src="web/images/product-image/6_1.jpg"
                                                        alt="Product" />
                                                    <img class="hover-image" src="web/images/product-image/6_2.jpg"
                                                        alt="Product" />
                                                </a>
                                                <span class="percentage">20%</span>
                                                <a href="#" class="quickview" data-link-action="quickview"
                                                    title="Quick view" data-bs-toggle="modal"
                                                    data-bs-target="#ec_quickview_modal"><i
                                                        class="fi-rr-eye"></i></a>
                                                <div class="ec-pro-actions">
                                                    <a href="compare.html" class="ec-btn-group compare"
                                                        title="Compare"><i class="fi fi-rr-arrows-repeat"></i></a>
                                                    <button title="Add To Cart" class="add-to-cart"><i
                                                            class="fi-rr-shopping-basket"></i> Add To Cart</button>
                                                    <a class="ec-btn-group wishlist" title="Wishlist"><i
                                                            class="fi-rr-heart"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ec-pro-content">
                                            <h5 class="ec-pro-title"><a href="product-left-sidebar.html">Round Neck
                                                    T-Shirt</a></h5>
                                            <div class="ec-pro-rating">
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star"></i>
                                            </div>
                                            <span class="ec-price">
                                                <span class="old-price">$30.00</span>
                                                <span class="new-price">$25.00</span>
                                            </span>
                                            <div class="ec-pro-option">
                                                <div class="ec-pro-color">
                                                    <span class="ec-pro-opt-label">Color</span>
                                                    <ul class="ec-opt-swatch ec-change-img">
                                                        <li class="active"><a href="#"
                                                                class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/6_1.jpg"
                                                                data-src-hover="web/images/product-image/6_1.jpg"
                                                                data-tooltip="Gray"><span
                                                                    style="background-color:#e8c2ff;"></span></a></li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/6_2.jpg"
                                                                data-src-hover="web/images/product-image/6_2.jpg"
                                                                data-tooltip="Orange"><span
                                                                    style="background-color:#9cfdd5;"></span></a></li>
                                                    </ul>
                                                </div>
                                                <div class="ec-pro-size">
                                                    <span class="ec-pro-opt-label">Size</span>
                                                    <ul class="ec-opt-size">
                                                        <li class="active"><a href="#" class="ec-opt-sz"
                                                                data-old="$25.00" data-new="$20.00"
                                                                data-tooltip="Small">S</a></li>
                                                        <li><a href="#" class="ec-opt-sz" data-old="$27.00"
                                                                data-new="$22.00" data-tooltip="Medium">M</a></li>
                                                        <li><a href="#" class="ec-opt-sz" data-old="$30.00"
                                                                data-new="$25.00" data-tooltip="Large">X</a></li>
                                                        <li><a href="#" class="ec-opt-sz" data-old="$35.00"
                                                                data-new="$30.00" data-tooltip="Extra Large">XL</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 mb-6  ec-product-content">
                                    <div class="ec-product-inner">
                                        <div class="ec-pro-image-outer">
                                            <div class="ec-pro-image">
                                                <a href="product-left-sidebar.html" class="image">
                                                    <img class="main-image" src="web/images/product-image/8_1.jpg"
                                                        alt="Product" />
                                                    <img class="hover-image" src="web/images/product-image/8_2.jpg"
                                                        alt="Product" />
                                                </a>
                                                <span class="percentage">20%</span>
                                                <span class="flags">
                                                    <span class="new">New</span>
                                                </span>
                                                <a href="#" class="quickview" data-link-action="quickview"
                                                    title="Quick view" data-bs-toggle="modal"
                                                    data-bs-target="#ec_quickview_modal"><i
                                                        class="fi-rr-eye"></i></a>
                                                <div class="ec-pro-actions">
                                                    <a href="compare.html" class="ec-btn-group compare"
                                                        title="Compare"><i class="fi fi-rr-arrows-repeat"></i></a>
                                                    <button title="Add To Cart" class="add-to-cart"><i
                                                            class="fi-rr-shopping-basket"></i> Add To Cart</button>
                                                    <a class="ec-btn-group wishlist" title="Wishlist"><i
                                                            class="fi-rr-heart"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ec-pro-content">
                                            <h5 class="ec-pro-title"><a href="product-left-sidebar.html">Digital
                                                    Smart
                                                    Watches</a></h5>
                                            <div class="ec-pro-rating">
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star"></i>
                                            </div>
                                            <span class="ec-price">
                                                <span class="old-price">$100.00</span>
                                                <span class="new-price">$80.00</span>
                                            </span>
                                            <div class="ec-pro-option">
                                                <div class="ec-pro-color">
                                                    <span class="ec-pro-opt-label">Color</span>
                                                    <ul class="ec-opt-swatch ec-change-img">
                                                        <li class="active"><a href="#"
                                                                class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/8_2.jpg"
                                                                data-src-hover="web/images/product-image/8_2.jpg"
                                                                data-tooltip="Gray"><span
                                                                    style="background-color:#e9dddd;"></span></a></li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/8_3.jpg"
                                                                data-src-hover="web/images/product-image/8_3.jpg"
                                                                data-tooltip="Orange"><span
                                                                    style="background-color:#ffd5cb;"></span></a></li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/8_4.jpg"
                                                                data-src-hover="web/images/product-image/8_4.jpg"
                                                                data-tooltip="Green"><span
                                                                    style="background-color:#92e4fd;"></span></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 mb-6  ec-product-content">
                                    <div class="ec-product-inner">
                                        <div class="ec-pro-image-outer">
                                            <div class="ec-pro-image">
                                                <a href="product-left-sidebar.html" class="image">
                                                    <img class="main-image" src="web/images/product-image/3_1.jpg"
                                                        alt="Product" />
                                                    <img class="hover-image" src="web/images/product-image/3_2.jpg"
                                                        alt="Product" />
                                                </a>
                                                <span class="percentage">20%</span>
                                                <span class="flags">
                                                    <span class="new">New</span>
                                                </span>
                                                <a href="#" class="quickview" data-link-action="quickview"
                                                    title="Quick view" data-bs-toggle="modal"
                                                    data-bs-target="#ec_quickview_modal"><i
                                                        class="fi-rr-eye"></i></a>
                                                <div class="ec-pro-actions">
                                                    <a href="compare.html" class="ec-btn-group compare"
                                                        title="Compare"><i class="fi fi-rr-arrows-repeat"></i></a>
                                                    <button title="Add To Cart" class="add-to-cart"><i
                                                            class="fi-rr-shopping-basket"></i> Add To Cart</button>
                                                    <a class="ec-btn-group wishlist" title="Wishlist"><i
                                                            class="fi-rr-heart"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ec-pro-content">
                                            <h5 class="ec-pro-title"><a href="product-left-sidebar.html">Designer
                                                    Leather Purses</a></h5>
                                            <div class="ec-pro-rating">
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star"></i>
                                            </div>
                                            <span class="ec-price">
                                                <span class="old-price">$40.00</span>
                                                <span class="new-price">$30.00</span>
                                            </span>
                                            <div class="ec-pro-option">
                                                <div class="ec-pro-color">
                                                    <span class="ec-pro-opt-label">Color</span>
                                                    <ul class="ec-opt-swatch ec-change-img">
                                                        <li class="active"><a href="#"
                                                                class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/3_1.jpg"
                                                                data-src-hover="web/images/product-image/3_1.jpg"
                                                                data-tooltip="Gray"><span
                                                                    style="background-color:#75e3ff;"></span></a></li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/3_2.jpg"
                                                                data-src-hover="web/images/product-image/3_2.jpg"
                                                                data-tooltip="Orange"><span
                                                                    style="background-color:#11f7d8;"></span></a></li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/3_3.jpg"
                                                                data-src-hover="web/images/product-image/3_3.jpg"
                                                                data-tooltip="Green"><span
                                                                    style="background-color:#acff7c;"></span></a></li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/3_5.jpg"
                                                                data-src-hover="web/images/product-image/3_5.jpg"
                                                                data-tooltip="Sky Blue"><span
                                                                    style="background-color:#e996fa;"></span></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 mb-6  ec-product-content">
                                    <div class="ec-product-inner">
                                        <div class="ec-pro-image-outer">
                                            <div class="ec-pro-image">
                                                <a href="product-left-sidebar.html" class="image">
                                                    <img class="main-image" src="web/images/product-image/11_1.jpg"
                                                        alt="Product" />
                                                    <img class="hover-image" src="web/images/product-image/11_2.jpg"
                                                        alt="Product" />
                                                </a>
                                                <span class="percentage">20%</span>
                                                <span class="flags">
                                                    <span class="new">New</span>
                                                </span>
                                                <a href="#" class="quickview" data-link-action="quickview"
                                                    title="Quick view" data-bs-toggle="modal"
                                                    data-bs-target="#ec_quickview_modal"><i
                                                        class="fi-rr-eye"></i></a>
                                                <div class="ec-pro-actions">
                                                    <a href="compare.html" class="ec-btn-group compare"
                                                        title="Compare"><i class="fi fi-rr-arrows-repeat"></i></a>
                                                    <button title="Add To Cart" class="add-to-cart"><i
                                                            class="fi-rr-shopping-basket"></i> Add To Cart</button>
                                                    <a class="ec-btn-group wishlist" title="Wishlist"><i
                                                            class="fi-rr-heart"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ec-pro-content">
                                            <h5 class="ec-pro-title"><a href="product-left-sidebar.html">Classic
                                                    Leather
                                                    purse</a></h5>
                                            <div class="ec-pro-rating">
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star"></i>
                                            </div>
                                            <span class="ec-price">
                                                <span class="old-price">$100.00</span>
                                                <span class="new-price">$80.00</span>
                                            </span>
                                            <div class="ec-pro-option">
                                                <div class="ec-pro-color">
                                                    <span class="ec-pro-opt-label">Color</span>
                                                    <ul class="ec-opt-swatch ec-change-img">
                                                        <li class="active"><a href="#"
                                                                class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/11_1.jpg"
                                                                data-src-hover="web/images/product-image/11_1.jpg"
                                                                data-tooltip="Gray"><span
                                                                    style="background-color:#dba4ff;"></span></a>
                                                        </li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/11_2.jpg"
                                                                data-src-hover="web/images/product-image/11_2.jpg"
                                                                data-tooltip="Orange"><span
                                                                    style="background-color:#ff4a77;"></span></a></li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/11_3.jpg"
                                                                data-src-hover="web/images/product-image/11_3.jpg"
                                                                data-tooltip="Green"><span
                                                                    style="background-color:#c9ff55;"></span></a>
                                                        </li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/11_4.jpg"
                                                                data-src-hover="web/images/product-image/11_4.jpg"
                                                                data-tooltip="Sky Blue"><span
                                                                    style="background-color:#ffcc5e;"></span></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 mb-6  ec-product-content">
                                    <div class="ec-product-inner">
                                        <div class="ec-pro-image-outer">
                                            <div class="ec-pro-image">
                                                <a href="product-left-sidebar.html" class="image">
                                                    <img class="main-image" src="web/images/product-image/12_1.jpg"
                                                        alt="Product" />
                                                    <img class="hover-image" src="web/images/product-image/12_2.jpg"
                                                        alt="Product" />
                                                </a>
                                                <span class="percentage">20%</span>
                                                <span class="flags">
                                                    <span class="sale">Sale</span>
                                                </span>
                                                <a href="#" class="quickview" data-link-action="quickview"
                                                    title="Quick view" data-bs-toggle="modal"
                                                    data-bs-target="#ec_quickview_modal"><i
                                                        class="fi-rr-eye"></i></a>
                                                <div class="ec-pro-actions">
                                                    <a href="compare.html" class="ec-btn-group compare"
                                                        title="Compare"><i class="fi fi-rr-arrows-repeat"></i></a>
                                                    <button title="Add To Cart" class="add-to-cart"><i
                                                            class="fi-rr-shopping-basket"></i> Add To Cart</button>
                                                    <a class="ec-btn-group wishlist" title="Wishlist"><i
                                                            class="fi-rr-heart"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ec-pro-content">
                                            <h5 class="ec-pro-title"><a href="product-left-sidebar.html">Fancy
                                                    Ladies
                                                    Sandal</a></h5>
                                            <div class="ec-pro-rating">
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star"></i>
                                            </div>
                                            <span class="ec-price">
                                                <span class="old-price">$100.00</span>
                                                <span class="new-price">$80.00</span>
                                            </span>
                                            <div class="ec-pro-option">
                                                <div class="ec-pro-color">
                                                    <span class="ec-pro-opt-label">Color</span>
                                                    <ul class="ec-opt-swatch ec-change-img">
                                                        <li class="active"><a href="#"
                                                                class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/12_1.jpg"
                                                                data-src-hover="web/images/product-image/12_1.jpg"
                                                                data-tooltip="Gray"><span
                                                                    style="background-color:#db9dff;"></span></a>
                                                        </li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/12_2.jpg"
                                                                data-src-hover="web/images/product-image/12_2.jpg"
                                                                data-tooltip="Orange"><span
                                                                    style="background-color:#00ffff;"></span></a></li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/12_3.jpg"
                                                                data-src-hover="web/images/product-image/12_3.jpg"
                                                                data-tooltip="Green"><span
                                                                    style="background-color:#ffa7f3;"></span></a>
                                                        </li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/12_4.jpg"
                                                                data-src-hover="web/images/product-image/12_4.jpg"
                                                                data-tooltip="Sky Blue"><span
                                                                    style="background-color:#89ff7e;"></span></a></li>
                                                    </ul>
                                                </div>
                                                <div class="ec-pro-size">
                                                    <span class="ec-pro-opt-label">Size</span>
                                                    <ul class="ec-opt-size">
                                                        <li class="active"><a href="#" class="ec-opt-sz"
                                                                data-old="$50.00" data-new="$40.00"
                                                                data-tooltip="Small">6</a></li>
                                                        <li><a href="#" class="ec-opt-sz" data-old="$60.00"
                                                                data-new="$50.00" data-tooltip="Medium">7</a></li>
                                                        <li><a href="#" class="ec-opt-sz" data-old="$70.00"
                                                                data-new="$60.00" data-tooltip="Large">8</a></li>
                                                        <li><a href="#" class="ec-opt-sz" data-old="$80.00"
                                                                data-new="$70.00" data-tooltip="Extra Large">9</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 mb-6  ec-product-content">
                                    <div class="ec-product-inner">
                                        <div class="ec-pro-image-outer">
                                            <div class="ec-pro-image">
                                                <a href="product-left-sidebar.html" class="image">
                                                    <img class="main-image" src="web/images/product-image/13_1.jpg"
                                                        alt="Product" />
                                                    <img class="hover-image" src="web/images/product-image/13_2.jpg"
                                                        alt="Product" />
                                                </a>
                                                <a href="#" class="quickview" data-link-action="quickview"
                                                    title="Quick view" data-bs-toggle="modal"
                                                    data-bs-target="#ec_quickview_modal"><i
                                                        class="fi-rr-eye"></i></a>
                                                <div class="ec-pro-actions">
                                                    <a href="compare.html" class="ec-btn-group compare"
                                                        title="Compare"><i class="fi fi-rr-arrows-repeat"></i></a>
                                                    <button title="Add To Cart" class="add-to-cart"><i
                                                            class="fi-rr-shopping-basket"></i> Add To Cart</button>
                                                    <a class="ec-btn-group wishlist" title="Wishlist"><i
                                                            class="fi-rr-heart"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ec-pro-content">
                                            <h5 class="ec-pro-title"><a href="product-left-sidebar.html">Womens
                                                    Leather
                                                    Backpack</a></h5>
                                            <div class="ec-pro-rating">
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star"></i>
                                            </div>
                                            <span class="ec-price">
                                                <span class="old-price">$100.00</span>
                                                <span class="new-price">$80.00</span>
                                            </span>
                                            <div class="ec-pro-option">
                                                <div class="ec-pro-color">
                                                    <span class="ec-pro-opt-label">Color</span>
                                                    <ul class="ec-opt-swatch ec-change-img">
                                                        <li class="active"><a href="#"
                                                                class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/13_1.jpg"
                                                                data-src-hover="web/images/product-image/13_1.jpg"
                                                                data-tooltip="Gray"><span
                                                                    style="background-color:#deffa4;"></span></a>
                                                        </li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/13_2.jpg"
                                                                data-src-hover="web/images/product-image/13_2.jpg"
                                                                data-tooltip="Orange"><span
                                                                    style="background-color:#ffcdbe;"></span></a></li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/13_3.jpg"
                                                                data-src-hover="web/images/product-image/13_3.jpg"
                                                                data-tooltip="Green"><span
                                                                    style="background-color:#ff94df;"></span></a>
                                                        </li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/13_4.jpg"
                                                                data-src-hover="web/images/product-image/13_4.jpg"
                                                                data-tooltip="Sky Blue"><span
                                                                    style="background-color:#dd9bfc;"></span></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 mb-6  ec-product-content">
                                    <div class="ec-product-inner">
                                        <div class="ec-pro-image-outer">
                                            <div class="ec-pro-image">
                                                <a href="product-left-sidebar.html" class="image">
                                                    <img class="main-image" src="web/images/product-image/14_1.jpg"
                                                        alt="Product" />
                                                    <img class="hover-image" src="web/images/product-image/14_2.jpg"
                                                        alt="Product" />
                                                </a>
                                                <span class="percentage">20%</span>
                                                <a href="#" class="quickview" data-link-action="quickview"
                                                    title="Quick view" data-bs-toggle="modal"
                                                    data-bs-target="#ec_quickview_modal"><i
                                                        class="fi-rr-eye"></i></a>
                                                <div class="ec-pro-actions">
                                                    <a href="compare.html" class="ec-btn-group compare"
                                                        title="Compare"><i class="fi fi-rr-arrows-repeat"></i></a>
                                                    <button title="Add To Cart" class="add-to-cart"><i
                                                            class="fi-rr-shopping-basket"></i> Add To Cart</button>
                                                    <a class="ec-btn-group wishlist" title="Wishlist"><i
                                                            class="fi-rr-heart"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ec-pro-content">
                                            <h5 class="ec-pro-title"><a href="product-left-sidebar.html">Beautiful
                                                    Watch
                                                    for Women</a></h5>
                                            <div class="ec-pro-rating">
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star"></i>
                                            </div>
                                            <span class="ec-price">
                                                <span class="old-price">$100.00</span>
                                                <span class="new-price">$80.00</span>
                                            </span>
                                            <div class="ec-pro-option">
                                                <div class="ec-pro-color">
                                                    <span class="ec-pro-opt-label">Color</span>
                                                    <ul class="ec-opt-swatch ec-change-img">
                                                        <li class="active"><a href="#"
                                                                class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/14_1.jpg"
                                                                data-src-hover="web/images/product-image/14_1.jpg"
                                                                data-tooltip="Gray"><span
                                                                    style="background-color:#bb8641;"></span></a></li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/14_2.jpg"
                                                                data-src-hover="web/images/product-image/14_2.jpg"
                                                                data-tooltip="Orange"><span
                                                                    style="background-color:#5dd677;"></span></a></li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/14_3.jpg"
                                                                data-src-hover="web/images/product-image/14_3.jpg"
                                                                data-tooltip="Green"><span
                                                                    style="background-color:#32ffdd;"></span></a></li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/14_4.jpg"
                                                                data-src-hover="web/images/product-image/14_4.jpg"
                                                                data-tooltip="Sky Blue"><span
                                                                    style="background-color:#56ccfa;"></span></a></li>
                                                    </ul>
                                                </div>
                                                <div class="ec-pro-size">
                                                    <span class="ec-pro-opt-label">Size</span>
                                                    <ul class="ec-opt-size">
                                                        <li class="active"><a href="#" class="ec-opt-sz"
                                                                data-old="$70.00" data-new="$60.00"
                                                                data-tooltip="Small">6</a></li>
                                                        <li><a href="#" class="ec-opt-sz" data-old="$80.00"
                                                                data-new="$70.00" data-tooltip="Medium">7</a></li>
                                                        <li><a href="#" class="ec-opt-sz" data-old="$90.00"
                                                                data-new="$80.00" data-tooltip="Large">8</a></li>
                                                        <li><a href="#" class="ec-opt-sz" data-old="$100.00"
                                                                data-new="$90.00" data-tooltip="Extra Large">9</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 shop-all-btn"><a href="shop-left-sidebar-col-3.html">Shop All
                                        Collection</a></div>
                            </div>
                        </div>
                        <!-- ec 3rd Product tab end -->
                        <!-- ec 4th Product tab start -->
                        <div class="tab-pane fade" id="tab-pro-for-child">
                            <div class="row">
                                <!-- Product Content -->
                                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 mb-6  ec-product-content">
                                    <div class="ec-product-inner">
                                        <div class="ec-pro-image-outer">
                                            <div class="ec-pro-image">
                                                <a href="product-left-sidebar.html" class="image">
                                                    <img class="main-image" src="web/images/product-image/1_1.jpg"
                                                        alt="Product" />
                                                    <img class="hover-image" src="web/images/product-image/1_2.jpg"
                                                        alt="Product" />
                                                </a>
                                                <span class="percentage">20%</span>
                                                <span class="flags">
                                                    <span class="sale">Sale</span>
                                                </span>
                                                <a href="#" class="quickview" data-link-action="quickview"
                                                    title="Quick view" data-bs-toggle="modal"
                                                    data-bs-target="#ec_quickview_modal"><i
                                                        class="fi-rr-eye"></i></a>
                                                <div class="ec-pro-actions">
                                                    <a href="compare.html" class="ec-btn-group compare"
                                                        title="Compare"><i class="fi fi-rr-arrows-repeat"></i></a>
                                                    <button title="Add To Cart" class="add-to-cart"><i
                                                            class="fi-rr-shopping-basket"></i> Add To Cart</button>
                                                    <a class="ec-btn-group wishlist" title="Wishlist"><i
                                                            class="fi-rr-heart"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ec-pro-content">
                                            <h5 class="ec-pro-title"><a href="product-left-sidebar.html">Cute Baby
                                                    Toy's</a></h5>
                                            <div class="ec-pro-rating">
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star"></i>
                                            </div>
                                            <span class="ec-price">
                                                <span class="old-price">$40.00</span>
                                                <span class="new-price">$30.00</span>
                                            </span>
                                            <div class="ec-pro-option">
                                                <div class="ec-pro-color">
                                                    <span class="ec-pro-opt-label">Color</span>
                                                    <ul class="ec-opt-swatch ec-change-img">
                                                        <li class="active"><a href="#"
                                                                class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/1_1.jpg"
                                                                data-src-hover="web/images/product-image/1_1.jpg"
                                                                data-tooltip="Gray"><span
                                                                    style="background-color:#90cdf7;"></span></a></li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/1_2.jpg"
                                                                data-src-hover="web/images/product-image/1_2.jpg"
                                                                data-tooltip="Orange"><span
                                                                    style="background-color:#ff3b66;"></span></a></li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/1_3.jpg"
                                                                data-src-hover="web/images/product-image/1_3.jpg"
                                                                data-tooltip="Green"><span
                                                                    style="background-color:#ffc476;"></span></a></li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/1_4.jpg"
                                                                data-src-hover="web/images/product-image/1_4.jpg"
                                                                data-tooltip="Sky Blue"><span
                                                                    style="background-color:#1af0ba;"></span></a></li>
                                                    </ul>
                                                </div>
                                                <div class="ec-pro-size">
                                                    <span class="ec-pro-opt-label">Size</span>
                                                    <ul class="ec-opt-size">
                                                        <li class="active"><a href="#" class="ec-opt-sz"
                                                                data-old="$40.00" data-new="$30.00"
                                                                data-tooltip="Small">S</a></li>
                                                        <li><a href="#" class="ec-opt-sz" data-old="$50.00"
                                                                data-new="$40.00" data-tooltip="Medium">M</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 mb-6  ec-product-content">
                                    <div class="ec-product-inner">
                                        <div class="ec-pro-image-outer">
                                            <div class="ec-pro-image">
                                                <a href="product-left-sidebar.html" class="image">
                                                    <img class="main-image" src="web/images/product-image/15_1.jpg"
                                                        alt="Product" />
                                                    <img class="hover-image" src="web/images/product-image/15_2.jpg"
                                                        alt="Product" />
                                                </a>
                                                <span class="percentage">20%</span>
                                                <span class="flags">
                                                    <span class="sale">Sale</span>
                                                </span>
                                                <a href="#" class="quickview" data-link-action="quickview"
                                                    title="Quick view" data-bs-toggle="modal"
                                                    data-bs-target="#ec_quickview_modal"><i
                                                        class="fi-rr-eye"></i></a>
                                                <div class="ec-pro-actions">
                                                    <a href="compare.html" class="ec-btn-group compare"
                                                        title="Compare"><i class="fi fi-rr-arrows-repeat"></i></a>
                                                    <button title="Add To Cart" class="add-to-cart"><i
                                                            class="fi-rr-shopping-basket"></i> Add To Cart</button>
                                                    <a class="ec-btn-group wishlist" title="Wishlist"><i
                                                            class="fi-rr-heart"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ec-pro-content">
                                            <h5 class="ec-pro-title"><a href="product-left-sidebar.html">Clasic Baby
                                                    Shoes
                                                </a></h5>
                                            <div class="ec-pro-rating">
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star"></i>
                                            </div>
                                            <span class="ec-price">
                                                <span class="old-price">$80.00</span>
                                                <span class="new-price">$70.00</span>
                                            </span>
                                            <div class="ec-pro-option">
                                                <div class="ec-pro-color">
                                                    <span class="ec-pro-opt-label">Color</span>
                                                    <ul class="ec-opt-swatch ec-change-img">
                                                        <li class="active"><a href="#"
                                                                class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/15_1.jpg"
                                                                data-src-hover="web/images/product-image/15_1.jpg"
                                                                data-tooltip="Gray"><span
                                                                    style="background-color:#ffacfb;"></span></a></li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/15_2.jpg"
                                                                data-src-hover="web/images/product-image/15_2.jpg"
                                                                data-tooltip="Orange"><span
                                                                    style="background-color:#90dfff;"></span></a></li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/15_3.jpg"
                                                                data-src-hover="web/images/product-image/15_3.jpg"
                                                                data-tooltip="Green"><span
                                                                    style="background-color:#c6ff4a;"></span></a></li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/15_4.jpg"
                                                                data-src-hover="web/images/product-image/15_4.jpg"
                                                                data-tooltip="Sky Blue"><span
                                                                    style="background-color:#ffb158;"></span></a></li>
                                                    </ul>
                                                </div>
                                                <div class="ec-pro-size">
                                                    <span class="ec-pro-opt-label">Size</span>
                                                    <ul class="ec-opt-size">
                                                        <li class="active"><a href="#" class="ec-opt-sz"
                                                                data-old="$80.00" data-new="$70.00"
                                                                data-tooltip="Small">4</a></li>
                                                        <li><a href="#" class="ec-opt-sz" data-old="$70.00"
                                                                data-new="$60.00" data-tooltip="Medium">5</a></li>
                                                        <li><a href="#" class="ec-opt-sz" data-old="$60.00"
                                                                data-new="$50.00" data-tooltip="Large">6</a></li>
                                                        <li><a href="#" class="ec-opt-sz" data-old="$50.00"
                                                                data-new="$40.00" data-tooltip="Extra Large">7</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 mb-6  ec-product-content">
                                    <div class="ec-product-inner">
                                        <div class="ec-pro-image-outer">
                                            <div class="ec-pro-image">
                                                <a href="product-left-sidebar.html" class="image">
                                                    <img class="main-image" src="web/images/product-image/16_1.jpg"
                                                        alt="Product" />
                                                    <img class="hover-image" src="web/images/product-image/16_2.jpg"
                                                        alt="Product" />
                                                </a>
                                                <span class="percentage">20%</span>
                                                <span class="flags">
                                                    <span class="new">New</span>
                                                </span>
                                                <a href="#" class="quickview" data-link-action="quickview"
                                                    title="Quick view" data-bs-toggle="modal"
                                                    data-bs-target="#ec_quickview_modal"><i
                                                        class="fi-rr-eye"></i></a>
                                                <div class="ec-pro-actions">
                                                    <a href="compare.html" class="ec-btn-group compare"
                                                        title="Compare"><i class="fi fi-rr-arrows-repeat"></i></a>
                                                    <button title="Add To Cart" class="add-to-cart"><i
                                                            class="fi-rr-shopping-basket"></i> Add To Cart</button>
                                                    <a class="ec-btn-group wishlist" title="Wishlist"><i
                                                            class="fi-rr-heart"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ec-pro-content">
                                            <h5 class="ec-pro-title"><a href="product-left-sidebar.html">Baby Doctor
                                                    Toy
                                                    Kit</a></h5>
                                            <div class="ec-pro-rating">
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star"></i>
                                            </div>
                                            <span class="ec-price">
                                                <span class="old-price">$50.00</span>
                                                <span class="new-price">$40.00</span>
                                            </span>
                                            <div class="ec-pro-option">
                                                <div class="ec-pro-color">
                                                    <span class="ec-pro-opt-label">Color</span>
                                                    <ul class="ec-opt-swatch ec-change-img">
                                                        <li class="active"><a href="#"
                                                                class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/16_1.jpg"
                                                                data-src-hover="web/images/product-image/16_1.jpg"
                                                                data-tooltip="Gray"><span
                                                                    style="background-color:#6ee9ff;"></span></a></li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/16_2.jpg"
                                                                data-src-hover="web/images/product-image/16_2.jpg"
                                                                data-tooltip="Orange"><span
                                                                    style="background-color:#eb99ff;"></span></a></li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/16_3.jpg"
                                                                data-src-hover="web/images/product-image/16_3.jpg"
                                                                data-tooltip="Green"><span
                                                                    style="background-color:#ff6464;"></span></a></li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/16_4.jpg"
                                                                data-src-hover="web/images/product-image/16_4.jpg"
                                                                data-tooltip="Sky Blue"><span
                                                                    style="background-color:#e476ff;"></span></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 mb-6  ec-product-content">
                                    <div class="ec-product-inner">
                                        <div class="ec-pro-image-outer">
                                            <div class="ec-pro-image">
                                                <a href="product-left-sidebar.html" class="image">
                                                    <img class="main-image" src="web/images/product-image/17_1.jpg"
                                                        alt="Product" />
                                                    <img class="hover-image" src="web/images/product-image/17_2.jpg"
                                                        alt="Product" />
                                                </a>
                                                <span class="percentage">20%</span>
                                                <span class="flags">
                                                    <span class="sale">Sale</span>
                                                </span>
                                                <a href="#" class="quickview" data-link-action="quickview"
                                                    title="Quick view" data-bs-toggle="modal"
                                                    data-bs-target="#ec_quickview_modal"><i
                                                        class="fi-rr-eye"></i></a>
                                                <div class="ec-pro-actions">
                                                    <a href="compare.html" class="ec-btn-group compare"
                                                        title="Compare"><i class="fi fi-rr-arrows-repeat"></i></a>
                                                    <button title="Add To Cart" class="add-to-cart"><i
                                                            class="fi-rr-shopping-basket"></i> Add To Cart</button>
                                                    <a class="ec-btn-group wishlist" title="Wishlist"><i
                                                            class="fi-rr-heart"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ec-pro-content">
                                            <h5 class="ec-pro-title"><a href="product-left-sidebar.html">Baby
                                                    Leather
                                                    Purse</a></h5>
                                            <div class="ec-pro-rating">
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star"></i>
                                            </div>
                                            <span class="ec-price">
                                                <span class="old-price">$60.00</span>
                                                <span class="new-price">$50.00</span>
                                            </span>
                                            <div class="ec-pro-option">
                                                <div class="ec-pro-color">
                                                    <span class="ec-pro-opt-label">Color</span>
                                                    <ul class="ec-opt-swatch ec-change-img">
                                                        <li class="active"><a href="#"
                                                                class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/17_1.jpg"
                                                                data-src-hover="web/images/product-image/17_1.jpg"
                                                                data-tooltip="Gray"><span
                                                                    style="background-color:#8ad2fc;"></span></a></li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/17_2.jpg"
                                                                data-src-hover="web/images/product-image/17_2.jpg"
                                                                data-tooltip="Orange"><span
                                                                    style="background-color:#ff8ef6;"></span></a></li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/17_3.jpg"
                                                                data-src-hover="web/images/product-image/17_3.jpg"
                                                                data-tooltip="Green"><span
                                                                    style="background-color:#ffbe31;"></span></a></li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/17_4.jpg"
                                                                data-src-hover="web/images/product-image/17_4.jpg"
                                                                data-tooltip="Sky Blue"><span
                                                                    style="background-color:#a3ffba;"></span></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 mb-6  ec-product-content">
                                    <div class="ec-product-inner">
                                        <div class="ec-pro-image-outer">
                                            <div class="ec-pro-image">
                                                <a href="product-left-sidebar.html" class="image">
                                                    <img class="main-image" src="web/images/product-image/9_1.jpg"
                                                        alt="Product" />
                                                    <img class="hover-image" src="web/images/product-image/9_2.jpg"
                                                        alt="Product" />
                                                </a>
                                                <span class="percentage">20%</span>
                                                <span class="flags">
                                                    <span class="sale">Sale</span>
                                                </span>
                                                <a href="#" class="quickview" data-link-action="quickview"
                                                    title="Quick view" data-bs-toggle="modal"
                                                    data-bs-target="#ec_quickview_modal"><i
                                                        class="fi-rr-eye"></i></a>
                                                <div class="ec-pro-actions">
                                                    <a href="compare.html" class="ec-btn-group compare"
                                                        title="Compare"><i class="fi fi-rr-arrows-repeat"></i></a>
                                                    <button title="Add To Cart" class="add-to-cart"><i
                                                            class="fi-rr-shopping-basket"></i> Add To Cart</button>
                                                    <a class="ec-btn-group wishlist" title="Wishlist"><i
                                                            class="fi-rr-heart"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ec-pro-content">
                                            <h5 class="ec-pro-title"><a href="product-left-sidebar.html">Canvas
                                                    Shoes
                                                    for Boy</a></h5>
                                            <div class="ec-pro-rating">
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star"></i>
                                            </div>
                                            <span class="ec-price">
                                                <span class="old-price">$30.00</span>
                                                <span class="new-price">$25.00</span>
                                            </span>
                                            <div class="ec-pro-option">
                                                <div class="ec-pro-color">
                                                    <span class="ec-pro-opt-label">Color</span>
                                                    <ul class="ec-opt-swatch ec-change-img">
                                                        <li class="active"><a href="#"
                                                                class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/9_1.jpg"
                                                                data-src-hover="web/images/product-image/9_1.jpg"
                                                                data-tooltip="Gray"><span
                                                                    style="background-color:#21b7fc;"></span></a></li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/9_2.jpg"
                                                                data-src-hover="web/images/product-image/9_2.jpg"
                                                                data-tooltip="Orange"><span
                                                                    style="background-color:#1df0ff;"></span></a></li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/9_3.jpg"
                                                                data-src-hover="web/images/product-image/9_3.jpg"
                                                                data-tooltip="Green"><span
                                                                    style="background-color:#94f7a1;"></span></a></li>
                                                    </ul>
                                                </div>
                                                <div class="ec-pro-size">
                                                    <span class="ec-pro-opt-label">Size</span>
                                                    <ul class="ec-opt-size">
                                                        <li class="active"><a href="#" class="ec-opt-sz"
                                                                data-old="$30.00" data-new="$25.00"
                                                                data-tooltip="Small">S</a></li>
                                                        <li><a href="#" class="ec-opt-sz" data-old="$35.00"
                                                                data-new="$27.00" data-tooltip="Medium">M</a></li>
                                                        <li><a href="#" class="ec-opt-sz" data-old="$40.00"
                                                                data-new="$30.00" data-tooltip="Large">X</a></li>
                                                        <li><a href="#" class="ec-opt-sz" data-old="$45.00"
                                                                data-new="$35.00" data-tooltip="Extra Large">XL</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 mb-6  ec-product-content">
                                    <div class="ec-product-inner">
                                        <div class="ec-pro-image-outer">
                                            <div class="ec-pro-image">
                                                <a href="product-left-sidebar.html" class="image">
                                                    <img class="main-image" src="web/images/product-image/6_1.jpg"
                                                        alt="Product" />
                                                    <img class="hover-image" src="web/images/product-image/6_2.jpg"
                                                        alt="Product" />
                                                </a>
                                                <span class="percentage">20%</span>
                                                <a href="#" class="quickview" data-link-action="quickview"
                                                    title="Quick view" data-bs-toggle="modal"
                                                    data-bs-target="#ec_quickview_modal"><i
                                                        class="fi-rr-eye"></i></a>
                                                <div class="ec-pro-actions">
                                                    <a href="compare.html" class="ec-btn-group compare"
                                                        title="Compare"><i class="fi fi-rr-arrows-repeat"></i></a>
                                                    <button title="Add To Cart" class="add-to-cart"><i
                                                            class="fi-rr-shopping-basket"></i> Add To Cart</button>
                                                    <a class="ec-btn-group wishlist" title="Wishlist"><i
                                                            class="fi-rr-heart"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ec-pro-content">
                                            <h5 class="ec-pro-title"><a href="product-left-sidebar.html">Round Neck
                                                    T-Shirt</a></h5>
                                            <div class="ec-pro-rating">
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star"></i>
                                            </div>
                                            <span class="ec-price">
                                                <span class="old-price">$30.00</span>
                                                <span class="new-price">$25.00</span>
                                            </span>
                                            <div class="ec-pro-option">
                                                <div class="ec-pro-color">
                                                    <span class="ec-pro-opt-label">Color</span>
                                                    <ul class="ec-opt-swatch ec-change-img">
                                                        <li class="active"><a href="#"
                                                                class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/6_1.jpg"
                                                                data-src-hover="web/images/product-image/6_1.jpg"
                                                                data-tooltip="Gray"><span
                                                                    style="background-color:#e8c2ff;"></span></a></li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/6_2.jpg"
                                                                data-src-hover="web/images/product-image/6_2.jpg"
                                                                data-tooltip="Orange"><span
                                                                    style="background-color:#9cfdd5;"></span></a></li>
                                                    </ul>
                                                </div>
                                                <div class="ec-pro-size">
                                                    <span class="ec-pro-opt-label">Size</span>
                                                    <ul class="ec-opt-size">
                                                        <li class="active"><a href="#" class="ec-opt-sz"
                                                                data-old="$25.00" data-new="$20.00"
                                                                data-tooltip="Small">S</a></li>
                                                        <li><a href="#" class="ec-opt-sz" data-old="$27.00"
                                                                data-new="$22.00" data-tooltip="Medium">M</a></li>
                                                        <li><a href="#" class="ec-opt-sz" data-old="$30.00"
                                                                data-new="$25.00" data-tooltip="Large">X</a></li>
                                                        <li><a href="#" class="ec-opt-sz" data-old="$35.00"
                                                                data-new="$30.00" data-tooltip="Extra Large">XL</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 mb-6  ec-product-content">
                                    <div class="ec-product-inner">
                                        <div class="ec-pro-image-outer">
                                            <div class="ec-pro-image">
                                                <a href="product-left-sidebar.html" class="image">
                                                    <img class="main-image" src="web/images/product-image/8_1.jpg"
                                                        alt="Product" />
                                                    <img class="hover-image" src="web/images/product-image/8_2.jpg"
                                                        alt="Product" />
                                                </a>
                                                <span class="percentage">20%</span>
                                                <span class="flags">
                                                    <span class="new">New</span>
                                                </span>
                                                <a href="#" class="quickview" data-link-action="quickview"
                                                    title="Quick view" data-bs-toggle="modal"
                                                    data-bs-target="#ec_quickview_modal"><i
                                                        class="fi-rr-eye"></i></a>
                                                <div class="ec-pro-actions">
                                                    <a href="compare.html" class="ec-btn-group compare"
                                                        title="Compare"><i class="fi fi-rr-arrows-repeat"></i></a>
                                                    <button title="Add To Cart" class="add-to-cart"><i
                                                            class="fi-rr-shopping-basket"></i> Add To Cart</button>
                                                    <a class="ec-btn-group wishlist" title="Wishlist"><i
                                                            class="fi-rr-heart"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ec-pro-content">
                                            <h5 class="ec-pro-title"><a href="product-left-sidebar.html">Digital
                                                    Smart
                                                    Watches</a></h5>
                                            <div class="ec-pro-rating">
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star"></i>
                                            </div>
                                            <span class="ec-price">
                                                <span class="old-price">$100.00</span>
                                                <span class="new-price">$80.00</span>
                                            </span>
                                            <div class="ec-pro-option">
                                                <div class="ec-pro-color">
                                                    <span class="ec-pro-opt-label">Color</span>
                                                    <ul class="ec-opt-swatch ec-change-img">
                                                        <li class="active"><a href="#"
                                                                class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/8_2.jpg"
                                                                data-src-hover="web/images/product-image/8_2.jpg"
                                                                data-tooltip="Gray"><span
                                                                    style="background-color:#e9dddd;"></span></a></li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/8_3.jpg"
                                                                data-src-hover="web/images/product-image/8_3.jpg"
                                                                data-tooltip="Orange"><span
                                                                    style="background-color:#ffd5cb;"></span></a></li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/8_4.jpg"
                                                                data-src-hover="web/images/product-image/8_4.jpg"
                                                                data-tooltip="Green"><span
                                                                    style="background-color:#92e4fd;"></span></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 mb-6  ec-product-content">
                                    <div class="ec-product-inner">
                                        <div class="ec-pro-image-outer">
                                            <div class="ec-pro-image">
                                                <a href="product-left-sidebar.html" class="image">
                                                    <img class="main-image" src="web/images/product-image/3_1.jpg"
                                                        alt="Product" />
                                                    <img class="hover-image" src="web/images/product-image/3_2.jpg"
                                                        alt="Product" />
                                                </a>
                                                <span class="percentage">20%</span>
                                                <span class="flags">
                                                    <span class="new">New</span>
                                                </span>
                                                <a href="#" class="quickview" data-link-action="quickview"
                                                    title="Quick view" data-bs-toggle="modal"
                                                    data-bs-target="#ec_quickview_modal"><i
                                                        class="fi-rr-eye"></i></a>
                                                <div class="ec-pro-actions">
                                                    <a href="compare.html" class="ec-btn-group compare"
                                                        title="Compare"><i class="fi fi-rr-arrows-repeat"></i></a>
                                                    <button title="Add To Cart" class="add-to-cart"><i
                                                            class="fi-rr-shopping-basket"></i> Add To Cart</button>
                                                    <a class="ec-btn-group wishlist" title="Wishlist"><i
                                                            class="fi-rr-heart"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ec-pro-content">
                                            <h5 class="ec-pro-title"><a href="product-left-sidebar.html">Designer
                                                    Leather Purses</a></h5>
                                            <div class="ec-pro-rating">
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star"></i>
                                            </div>
                                            <span class="ec-price">
                                                <span class="old-price">$40.00</span>
                                                <span class="new-price">$30.00</span>
                                            </span>
                                            <div class="ec-pro-option">
                                                <div class="ec-pro-color">
                                                    <span class="ec-pro-opt-label">Color</span>
                                                    <ul class="ec-opt-swatch ec-change-img">
                                                        <li class="active"><a href="#"
                                                                class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/3_1.jpg"
                                                                data-src-hover="web/images/product-image/3_1.jpg"
                                                                data-tooltip="Gray"><span
                                                                    style="background-color:#75e3ff;"></span></a></li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/3_2.jpg"
                                                                data-src-hover="web/images/product-image/3_2.jpg"
                                                                data-tooltip="Orange"><span
                                                                    style="background-color:#11f7d8;"></span></a></li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/3_3.jpg"
                                                                data-src-hover="web/images/product-image/3_3.jpg"
                                                                data-tooltip="Green"><span
                                                                    style="background-color:#acff7c;"></span></a></li>
                                                        <li><a href="#" class="ec-opt-clr-img"
                                                                data-src="web/images/product-image/3_5.jpg"
                                                                data-src-hover="web/images/product-image/3_5.jpg"
                                                                data-tooltip="Sky Blue"><span
                                                                    style="background-color:#e996fa;"></span></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 shop-all-btn"><a href="shop-left-sidebar-col-3.html">Shop All
                                        Collection</a></div>
                            </div>
                        </div>
                        <!-- ec 4th Product tab end -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ec Product tab Area End -->

    <!-- ec Banner Section Start -->
    <section class="ec-banner section section-space-p">
        <h2 class="d-none">Banner</h2>
        <div class="container">
            <!-- ec Banners Start -->
            <div class="ec-banner-inner">
                <!--ec Banner Start -->
                <div class="ec-banner-block ec-banner-block-2">
                    <div class="row">
                        <div class="banner-block col-lg-6 col-md-12 margin-b-30" data-animation="slideInRight">
                            <div class="bnr-overlay">
                                <img src="web/images/banner/2.jpg" alt="" />
                                <div class="banner-text">
                                    <span class="ec-banner-stitle">New Arrivals</span>
                                    <span class="ec-banner-title">mens<br> Sport shoes</span>
                                    <span class="ec-banner-discount">30% Discount</span>
                                </div>
                                <div class="banner-content">
                                    <span class="ec-banner-btn"><a href="#">Order Now</a></span>
                                </div>
                            </div>
                        </div>
                        <div class="banner-block col-lg-6 col-md-12" data-animation="slideInLeft">
                            <div class="bnr-overlay">
                                <img src="web/images/banner/3.jpg" alt="" />
                                <div class="banner-text">
                                    <span class="ec-banner-stitle">New Trending</span>
                                    <span class="ec-banner-title">Smart<br> watches</span>
                                    <span class="ec-banner-discount">Buy any 3 Items & get <br>20% Discount</span>
                                </div>
                                <div class="banner-content">
                                    <span class="ec-banner-btn"><a href="#">Order Now</a></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ec Banner End -->
                </div>
                <!-- ec Banners End -->
            </div>
        </div>
    </section>
    <!-- ec Banner Section End -->
    <!--  Feature & Special Section Start -->
    <section class="section ec-fre-spe-section section-space-p" id="offers">
        <div class="container">
            <div class="row">
                <!--  Feature Section Start -->
                <div class="ec-fre-section col-lg-6 col-md-6 col-sm-6 margin-b-30" data-animation="slideInRight">
                    <div class="col-md-12 text-left">
                        <div class="section-title">
                            <h2 class="ec-bg-title">Feature Items</h2>
                            <h2 class="ec-title">Feature Items</h2>
                        </div>
                    </div>

                    <div class="ec-fre-products">
                        <div class="ec-fs-product">
                            <div class="ec-fs-pro-inner">
                                <div class="ec-fs-pro-image-outer col-lg-6 col-md-6 col-sm-6">
                                    <div class="ec-fs-pro-image">
                                        <a href="product-left-sidebar.html" class="image"><img class="main-image"
                                                src="web/images/product-image/1_1.jpg" alt="Product" /></a>
                                        <a href="#" class="quickview" data-link-action="quickview"
                                            title="Quick view" data-bs-toggle="modal"
                                            data-bs-target="#ec_quickview_modal"><i class="fi-rr-eye"></i></a>
                                    </div>
                                </div>
                                <div class="ec-fs-pro-content col-lg-6 col-md-6 col-sm-6">
                                    <h5 class="ec-fs-pro-title"><a href="product-left-sidebar.html">Baby Toy
                                            Teddybear</a>
                                    </h5>
                                    <div class="ec-fs-pro-rating">
                                        <span class="ec-fs-rating-icon">
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star"></i>
                                        </span>
                                        <span class="ec-fs-rating-text">4 Review</span>
                                    </div>
                                    <div class="ec-fs-price">
                                        <span class="old-price">$549.00</span>
                                        <span class="new-price">$480.00</span>
                                    </div>

                                    <div class="countdowntimer"><span id="ec-fs-count-1"></span></div>
                                    <div class="ec-fs-pro-desc">Lorem Ipsum is simply dummy text the printing and
                                        typesetting.
                                    </div>
                                    <div class="ec-fs-pro-book">Total Booking: <span>25</span></div>
                                    <div class="ec-fs-pro-btn">
                                        <a href="#" class="btn btn-lg btn-secondary">Remind Me</a>
                                        <a href="#" class="btn btn-lg btn-primary">Book Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ec-fs-product">
                            <div class="ec-fs-pro-inner">
                                <div class="ec-fs-pro-image-outer col-lg-6 col-md-6 col-sm-6">
                                    <div class="ec-fs-pro-image">
                                        <a href="product-left-sidebar.html" class="image"><img class="main-image"
                                                src="web/images/product-image/3_1.jpg" alt="Product" /></a>
                                        <a href="#" class="quickview" data-link-action="quickview"
                                            title="Quick view" data-bs-toggle="modal"
                                            data-bs-target="#ec_quickview_modal"><i class="fi-rr-eye"></i></a>
                                    </div>
                                </div>
                                <div class="ec-fs-pro-content col-lg-6 col-md-6 col-sm-6">
                                    <h5 class="ec-fs-pro-title"><a href="product-left-sidebar.html">Leather Purse
                                            For
                                            Women</a>
                                    </h5>
                                    <div class="ec-fs-pro-rating">
                                        <span class="ec-fs-rating-icon">
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star fill"></i>
                                        </span>
                                        <span class="ec-fs-rating-text">4 Review</span>
                                    </div>
                                    <div class="ec-fs-price">
                                        <span class="old-price">$300.00</span>
                                        <span class="new-price">$250.00</span>
                                    </div>

                                    <div class="countdowntimer"><span id="ec-fs-count-2"></span></div>
                                    <div class="ec-fs-pro-desc">Lorem Ipsum is simply dummy text the printing and
                                        typesetting.
                                    </div>
                                    <div class="ec-fs-pro-book">Total Booking: <span>25</span></div>
                                    <div class="ec-fs-pro-btn">
                                        <a href="#" class="btn btn-lg btn-secondary">Remind Me</a>
                                        <a href="#" class="btn btn-lg btn-primary">Book Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--  Feature Section End -->
                <!--  Special Section Start -->
                <div class="ec-spe-section col-lg-6 col-md-6 col-sm-6" data-animation="slideInLeft">
                    <div class="col-md-12 text-left">
                        <div class="section-title">
                            <h2 class="ec-bg-title">Limited Time Offer</h2>
                            <h2 class="ec-title">Limited Time Offer</h2>
                        </div>
                    </div>

                    <div class="ec-spe-products">
                        <div class="ec-fs-product">
                            <div class="ec-fs-pro-inner">
                                <div class="ec-fs-pro-image-outer col-lg-6 col-md-6 col-sm-6">
                                    <div class="ec-fs-pro-image">
                                        <a href="product-left-sidebar.html" class="image"><img class="main-image"
                                                src="web/images/product-image/8_1.jpg" alt="Product" /></a>
                                        <a href="#" class="quickview" data-link-action="quickview"
                                            title="Quick view" data-bs-toggle="modal"
                                            data-bs-target="#ec_quickview_modal"><i class="fi-rr-eye"></i></a>
                                    </div>
                                </div>
                                <div class="ec-fs-pro-content col-lg-6 col-md-6 col-sm-6">
                                    <h5 class="ec-fs-pro-title"><a href="product-left-sidebar.html">Smart watch
                                            Firebolt</a>
                                    </h5>
                                    <div class="ec-fs-pro-rating">
                                        <span class="ec-fs-rating-icon">
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star"></i>
                                        </span>
                                        <span class="ec-fs-rating-text">4 Review</span>
                                    </div>
                                    <div class="ec-fs-price">
                                        <span class="old-price">$200.00</span>
                                        <span class="new-price">$180.00</span>
                                    </div>
                                    <div class="countdowntimer"><span id="ec-fs-count-3"></span></div>
                                    <div class="ec-fs-pro-desc">Lorem Ipsum is simply dummy text the printing and
                                        typesetting.
                                    </div>
                                    <div class="ec-fs-pro-book">Total Booking: <span>25</span></div>
                                    <div class="ec-fs-pro-btn">
                                        <a href="#" class="btn btn-lg btn-secondary">Remind Me</a>
                                        <a href="#" class="btn btn-lg btn-primary">Book Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ec-fs-product">
                            <div class="ec-fs-pro-inner">
                                <div class="ec-fs-pro-image-outer col-lg-6 col-md-6 col-sm-6">
                                    <div class="ec-fs-pro-image">
                                        <a href="product-left-sidebar.html" class="image"><img class="main-image"
                                                src="web/images/product-image/10_1.jpg" alt="Product" /></a>
                                        <a href="#" class="quickview" data-link-action="quickview"
                                            title="Quick view" data-bs-toggle="modal"
                                            data-bs-target="#ec_quickview_modal"><i class="fi-rr-eye"></i></a>
                                    </div>
                                </div>
                                <div class="ec-fs-pro-content col-lg-6 col-md-6 col-sm-6">
                                    <h5 class="ec-fs-pro-title"><a href="product-left-sidebar.html">Casual Shoes
                                            Men</a>
                                    </h5>
                                    <div class="ec-fs-pro-rating">
                                        <span class="ec-fs-rating-icon">
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star fill"></i>
                                        </span>
                                        <span class="ec-fs-rating-text">4 Review</span>
                                    </div>
                                    <div class="ec-fs-price">
                                        <span class="old-price">$120.00</span>
                                        <span class="new-price">$95.00</span>
                                    </div>

                                    <div class="countdowntimer"><span id="ec-fs-count-4"></span></div>
                                    <div class="ec-fs-pro-desc">Lorem Ipsum is simply dummy text the printing and
                                        typesetting.
                                    </div>
                                    <div class="ec-fs-pro-book">Total Booking: <span>25</span></div>
                                    <div class="ec-fs-pro-btn">
                                        <a href="#" class="btn btn-lg btn-secondary">Remind Me</a>
                                        <a href="#" class="btn btn-lg btn-primary">Book Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--  Special Section End -->
            </div>
        </div>
    </section>
    <!-- Feature & Special Section End -->
    <!--  services Section Start -->
    <section class="section ec-services-section section-space-p" id="services">
        <h2 class="d-none">Services</h2>
        <div class="container">
            <div class="row">
                <div class="ec_ser_content ec_ser_content_1 col-sm-12 col-md-6 col-lg-3" data-animation="zoomIn">
                    <div class="ec_ser_inner">
                        <div class="ec-service-image">
                            <i class="fi fi-ts-truck-moving"></i>
                        </div>
                        <div class="ec-service-desc">
                            <h2>Free Shipping</h2>
                            <p>Free shipping on all US order or order above $200</p>
                        </div>
                    </div>
                </div>
                <div class="ec_ser_content ec_ser_content_2 col-sm-12 col-md-6 col-lg-3" data-animation="zoomIn">
                    <div class="ec_ser_inner">
                        <div class="ec-service-image">
                            <i class="fi fi-ts-hand-holding-seeding"></i>
                        </div>
                        <div class="ec-service-desc">
                            <h2>24X7 Support</h2>
                            <p>Contact us 24 hours a day, 7 days a week</p>
                        </div>
                    </div>
                </div>
                <div class="ec_ser_content ec_ser_content_3 col-sm-12 col-md-6 col-lg-3" data-animation="zoomIn">
                    <div class="ec_ser_inner">
                        <div class="ec-service-image">
                            <i class="fi fi-ts-badge-percent"></i>
                        </div>
                        <div class="ec-service-desc">
                            <h2>30 Days Return</h2>
                            <p>Simply return it within 30 days for an exchange</p>
                        </div>
                    </div>
                </div>
                <div class="ec_ser_content ec_ser_content_4 col-sm-12 col-md-6 col-lg-3" data-animation="zoomIn">
                    <div class="ec_ser_inner">
                        <div class="ec-service-image">
                            <i class="fi fi-ts-donate"></i>
                        </div>
                        <div class="ec-service-desc">
                            <h2>Payment Secure</h2>
                            <p>Contact us 24 hours a day, 7 days a week</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--services Section End -->

    <!--  offer Section Start -->
    <section class="section ec-offer-section section-space-p section-space-m">
        <h2 class="d-none">Offer</h2>
        <div class="container">
            <div class="row justify-content-end">
                <div class="col-xl-6 col-lg-7 col-md-7 col-sm-7 align-self-center ec-offer-content">
                    <h2 class="ec-offer-title">Sunglasses</h2>
                    <h3 class="ec-offer-stitle" data-animation="slideInDown">Super Offer</h3>
                    <span class="ec-offer-img" data-animation="zoomIn"><img src="web/images/offer-image/1.png"
                            alt="offer image" /></span>
                    <span class="ec-offer-desc">Acetate Frame Sunglasses</span>
                    <span class="ec-offer-price">$40.00 Only</span>
                    <a class="btn btn-primary" href="shop-left-sidebar-col-3.html" data-animation="zoomIn">Shop
                        Now</a>
                </div>
            </div>
        </div>
    </section>
    <!-- offer Section End -->



    <!-- Ec Brand Section Start -->
    <section class="section ec-brand-area section-space-p">
        <h2 class="d-none">Brand</h2>
        <div class="container">
            <div class="row">
                <div class="ec-brand-outer">
                    <ul id="ec-brand-slider">
                        <li class="ec-brand-item" data-animation="zoomIn">
                            <div class="ec-brand-img"><a href="#"><img alt="brand" title="brand"
                                        src="web/images/brand-image/1.png" /></a></div>
                        </li>
                        <li class="ec-brand-item" data-animation="zoomIn">
                            <div class="ec-brand-img"><a href="#"><img alt="brand" title="brand"
                                        src="web/images/brand-image/2.png" /></a></div>
                        </li>
                        <li class="ec-brand-item" data-animation="zoomIn">
                            <div class="ec-brand-img"><a href="#"><img alt="brand" title="brand"
                                        src="web/images/brand-image/3.png" /></a></div>
                        </li>
                        <li class="ec-brand-item" data-animation="zoomIn">
                            <div class="ec-brand-img"><a href="#"><img alt="brand" title="brand"
                                        src="web/images/brand-image/4.png" /></a></div>
                        </li>
                        <li class="ec-brand-item" data-animation="zoomIn">
                            <div class="ec-brand-img"><a href="#"><img alt="brand" title="brand"
                                        src="web/images/brand-image/5.png" /></a></div>
                        </li>
                        <li class="ec-brand-item" data-animation="zoomIn">
                            <div class="ec-brand-img"><a href="#"><img alt="brand" title="brand"
                                        src="web/images/brand-image/6.png" /></a></div>
                        </li>
                        <li class="ec-brand-item" data-animation="zoomIn">
                            <div class="ec-brand-img"><a href="#"><img alt="brand" title="brand"
                                        src="web/images/brand-image/7.png" /></a></div>
                        </li>
                        <li class="ec-brand-item" data-animation="zoomIn">
                            <div class="ec-brand-img"><a href="#"><img alt="brand" title="brand"
                                        src="web/images/brand-image/8.png" /></a></div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- Ec Brand Section End -->


</div>
