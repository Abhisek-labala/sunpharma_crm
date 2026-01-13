<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server Error</title>
    <style>
        body {
            margin: 0; padding: 0;
            font-family: 'Comic Sans MS', 'Comic Sans', cursive;
            background-color: #fcebeb; /* Light pink background */
            color: #d9534f; /* Muted red text */
            display: flex; justify-content: center; align-items: center;
            height: 100vh; flex-direction: column; text-align: center;
        }
        .error-container { animation: bounceIn 1s ease-out; }
        h1 {
            font-size: 6rem; margin: 0; font-weight: bold;
            color: #d9534f;
        }
        p { font-size: 1.5rem; margin: 15px 0 40px; }
        a {
            padding: 12px 25px; background: #d9534f; color: #fff; text-decoration: none;
            border: 2px solid #d9534f; border-radius: 10px;
            font-weight: 600; transition: all 0.3s ease;
        }
        a:hover { background: transparent; color: #d9534f; transform: scale(1.05); }
        @keyframes bounceIn {
            0%{opacity:0;transform:scale(0.3);} 50%{opacity:1;transform:scale(1.1);} 70%{transform:scale(0.9);} 100%{transform:scale(1);}
        }
        .illustration {
            font-size: 120px; /* Large size to match the 404 page's icon */
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="illustration">⚙️</div>
        <h1>500</h1>
        <p>Uh oh! Looks like the server is a little wonky.</p>
        <a href="{{ url('/') }}">Let's find the way back</a>
    </div>
</body>
</html>
