<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>You're Offline</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            background: #f5f7fa;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .offline-container {
            text-align: center;
            background: white;
            padding: 40px 30px;
            border-radius: 18px;
            box-shadow: 0 10px 35px rgba(0,0,0,0.08);
            max-width: 400px;
        }

        .offline-container img {
            width: 150px;
            margin-bottom: 25px;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
            100% { transform: translateY(0px); }
        }

        h2 {
            font-size: 26px;
            margin-bottom: 12px;
            color: #222;
            font-weight: 700;
        }

        p {
            margin-bottom: 20px;
            font-size: 15px;
            color: #555;
            line-height: 1.6;
        }

        .btn-retry {
            display: inline-block;
            padding: 12px 22px;
            background: #4f46e5;
            color: white;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            transition: 0.25s ease-in-out;
        }

        .btn-retry:hover {
            background: #4338ca;
        }

        .tips {
            margin-top: 25px;
            font-size: 13px;
            color: #888;
        }
    </style>
</head>

<body>
    <div class="offline-container">
        {{-- <img src="/images/offline-shopping.png" alt="Offline"> --}}

        <h2>You’re Offline</h2>

        <p>
            It looks like your internet connection is lost.  
            No worries — you can keep browsing the pages you already visited.
        </p>

        <a class="btn-retry" href="/">Try Again</a>

        <div class="tips">
            Tips: Switch to mobile data or reconnect to Wi-Fi.
        </div>
    </div>
</body>
</html>
