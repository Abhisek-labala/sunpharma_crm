<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Hridayam</title>
  <link rel="icon" href="https://doctor.tasainnovation.com/uploads/logo.png" type="image/png">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Poppins', sans-serif;
    }
    body {
      background: #e6f3fb url('https://doctor.tasainnovation.com/13732.jpg') center center no-repeat;
      background-size: cover;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
    }

    .container {
      display: flex;
      width: 100%;
      max-width: 900px;
      background-color: #fff;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
      flex-direction: row;
    }

    .left,
    .right {
      flex: 1;
      padding: 60px 40px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .left {
      background: linear-gradient(135deg, #1d3557, #6c0636);
      color: white;
      text-align: center;
    }

    .left img {
      width: 140px;
      margin-bottom: 30px;
      text-align: center;
      margin: 105px auto 30px;
    }

    .left h1 {
      font-size: 32px;
    }

    .right h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #1d3557;
      font-size: 22px;
    }

    .role-buttons {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
      justify-items: center;
      margin-top: 40px;
    }

    .role-btn {
      background: linear-gradient(135deg, #c42942, #1d3557);
      color: #fff;
      text-align: center;
      text-decoration: none;
      border: none;
      padding: 12px 24px;
      border-radius: 12px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      width: 200px;
      transition: transform 0.2s ease, opacity 0.3s ease;
      display: inline-block;
    }

    .role-btn:hover {
      transform: scale(1.05);
      opacity: 0.95;
    }

    @media (max-width: 768px) {
      .container {
        flex-direction: column;
        border-radius: 15px;
      }

      .left, .right {
        padding: 40px 20px;
        text-align: center;
      }

      .left img {
        margin: 0 auto 20px;
      }

      .role-buttons {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="left">
      <img src="https://doctor.tasainnovation.com/uploads/logo.png" alt="Hridayam Logo">
      <h1>Hello <br><strong>Welcome!</strong></h1>
    </div>
    <div class="right">
      <h2>Select Your Role</h2>
      <div class="role-buttons">
        <a href="{{ url('/login') }}" class="role-btn">Educator</a>
        <a href="{{ url('/rmlogin') }}" class="role-btn">RM</a>
        <a href="{{ url('/login') }}" class="role-btn">DigitalEducator</a>
        <a href="{{ url('/login') }}" class="role-btn">Yoga Dietician</a>
        <a href="{{ url('/login') }}" class="role-btn">MIS</a>
        <a href="{{ url('/login') }}" class="role-btn">PM</a>
      </div>
    </div>
  </div>
</body>
</html>
