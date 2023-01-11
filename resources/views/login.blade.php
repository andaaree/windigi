<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Favicons -->
  <link href="/assets/login/gear.png" rel="icon">
  <link href="/assets/login/gear.png" rel="apple-touch-icon">

  <title>Login Admin Gear</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

  <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">

  <style media="screen">
    *,
    *:before,
    *:after{
      padding: 0;
      margin: 0;
      box-sizing: border-box;
    }
    body{
      background: url("background.png") top left;
      background-size: cover;
      /* position: relative; */
      width: 100%;
    }
    .background{
      width: 430px;
      height: 520px;
      position: absolute;
      transform: translate(-50%,-50%);
      left: 50%;
      top: 50%;
    }
    .background .shape{
      height: 200px;
      width: 200px;
      position: absolute;
      border-radius: 50%;
    }
    .shape:first-child{
      background: linear-gradient(
          #0082ac,
          #04B4CC
      );
      left: -80px;
      top: -80px;
    }
    .shape:last-child{
      background: linear-gradient(
          to right,
          #0082ac,
          #04B4CC
      );
      right: -30px;
      bottom: -80px;
    }
    form{
      height: 520px;
      width: 400px;
      background-color: rgba(168, 173, 177,0.5);
      position: absolute;
      transform: translate(-50%,-50%);
      top: 50%;
      left: 50%;
      border-radius: 10px;
      /* backdrop-filter: blur(10px); */
      border: 2px solid rgba(255,255,255,0.1);
      box-shadow: 0 0 40px rgba(8,7,16,0.6);
      padding: 50px 35px;
    }
    @media (max-width: 768px) {
      form {
        height: 460px;
        width: 340px;
      }
    }
    form *{
      font-family: 'Poppins',sans-serif;
      /* color: #ffffff; */
      letter-spacing: 0.5px;
      outline: none;
      border: none;
    }
    form h3 {
      font-size: 32px;
      font-weight: 500;
      line-height: 42px;
      text-align: center;
      color: #1f1f1f;
      margin: 40px 0;
    }
    .logo {
      text-align: center;
    }
    .btn-login {
      color: #fff;
      background-color: #04B4CC;
      border-color: #04B4CC;
    }
  </style>

</head>
<body>

  <div class="background">
    <div class="shape"></div>
    <div class="shape"></div>
  </div>

  <form action="/login" method="post">
    <div class="logo">
      <img src="gear.png" alt="" height="80px" width="auto">
    </div>
    
    <h3>Login</h3>

    <div class="input-group mb-3">
      <input name="username" type="text" class="form-control" placeholder="Username" autocomplete="username">
      <div class="input-group-append">
        <div class="input-group-text">
          <span class="fas fa-user"></span>
        </div>
      </div>
    </div>
    <div class="input-group mb-3">
      <input type="password" name="password" class="form-control" placeholder="Password">
      <div class="input-group-append">
        <div class="input-group-text">
          <span class="fas fa-lock"></span>
        </div>
      </div>
    </div>
    <button type="submit" class="btn btn-login btn-block">Login</button>
  </form>

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script src="/assets/adminlte/plugins/sweetalert2/sweetalert2.all.min.js"></script>
</body>
</html>
