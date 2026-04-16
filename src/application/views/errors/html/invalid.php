<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" type="image/jpg" href="<?= base_url(); ?>assets/images/logo-baru.png" />
  <title>Forbidden Access | PT Pulau Sambu (Guntung)</title>
</head>
<style>
  * {
    font-family: Arial, Helvetica, sans-serif;
  }

  body {
    background-color: rgb(10, 145, 255);
  }

  .main {
    text-align: center;
  }

  .mb-30 {
    margin-bottom: 30px;
  }

  .main {
    min-height: 90vh;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .item {
    background-color: white;
    padding: 50px;
    border-radius: 20px;
  }

  .item h1 {
    font-weight: bold;
  }

  .item p {
    font-size: 1.2rem;
    margin: 0.3rem;
  }

  .footer {
    font-size: 14px !important;
    margin-top: 60px !important;
    font-weight: lighter;
  }

  .logo p {
    font-size: 1rem;
    font-weight: 500;

  }

  .logo hr {
    border: 1px solid black;
    border-radius: 10px;
  }

  .logo img {
    margin-bottom: 5px;
    width: 80px;
  }

  /* CSS */
  .button-18 {
    align-items: center;
    background-color: #0A66C2;
    border: 0;
    border-radius: 100px;
    box-sizing: border-box;
    color: #ffffff;
    cursor: pointer;
    display: inline-flex;
    font-family: -apple-system, system-ui, system-ui, "Segoe UI", Roboto, "Helvetica Neue", "Fira Sans", Ubuntu, Oxygen, "Oxygen Sans", Cantarell, "Droid Sans", "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Lucida Grande", Helvetica, Arial, sans-serif;
    font-size: 16px;
    font-weight: 600;
    justify-content: center;
    line-height: 20px;
    max-width: 480px;
    min-height: 40px;
    min-width: 0px;
    overflow: hidden;
    padding: 0px;
    padding-left: 20px;
    padding-right: 20px;
    text-align: center;
    touch-action: manipulation;
    transition: background-color 0.167s cubic-bezier(0.4, 0, 0.2, 1) 0s, box-shadow 0.167s cubic-bezier(0.4, 0, 0.2, 1) 0s, color 0.167s cubic-bezier(0.4, 0, 0.2, 1) 0s;
    user-select: none;
    -webkit-user-select: none;
    vertical-align: middle;
    margin-top: 10px;
    text-decoration: none;
  }

  .button-18:hover,
  .button-18:focus {
    background-color: #16437E;
    color: #ffffff;
  }

  .button-18:active {
    background: #09223b;
    color: rgb(255, 255, 255, .7);
  }

  .button-18:disabled {
    cursor: not-allowed;
    background: rgba(0, 0, 0, .08);
    color: rgba(0, 0, 0, .3);
  }

  .error {
    width: 70%;
  }

  @media only screen and (max-width: 850px) {

    .logo img {
      width: 50px !important;
    }

    .mb-30 {
      margin-bottom: 10px;
    }

    .item {
      padding: 20px;
    }

    .item img {
      width: 220px;
    }

    .item p {
      font-size: 0.8rem;
    }

    .item h1 {
      font-size: 1.2rem;
    }

    .footer {
      margin-top: 20px !important;
      font-size: 11px !important;
    }
  }


  @media only screen and (max-width: 1440px) {

    .logo img {
      width: 50px !important;
    }

    .item {
      padding: 20px;
    }

    .item img {
      width: 220px;
    }

    .item p {
      font-size: 0.8rem;
    }

    .item h1 {
      font-size: 1.2rem;
    }

    .footer {
      margin-top: 20px !important;
      font-size: 11px !important;
    }
  }
</style>

<body>
  <div class="main">
    <div class="item">
      <div class="logo">
        <img src="<?= base_url('assets/images/logo-baru.png') ?>" alt="logo">
        <p>PT PULAU SAMBU GUNTUNG</p>
        <hr>
      </div>

      <img src="<?= base_url('assets/images/403-error.svg') ?>" alt="error">
      <h1 class="mb-30">FORBIDDEN ACCESS</h1>
      <P>Silahkan Akses Aplikasi menggunakan One Login</P>
      <p>Jika belum memiliki akses silahkan hubungi Admin ITD</p>
      <p class="footer">© Copyright <?= date('Y') ?> Information Technology Departement.</p>
    </div>
  </div>
</body>

</html>