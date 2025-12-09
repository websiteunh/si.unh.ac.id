<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .login-container {
            background-image: url("<?= base_url('assets/bgs.jpg'); ?>");
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .login-image {
            height: 50vh;
            display: flex;
            background-color: white;
            justify-content: center;
            align-items: center;
            padding-top: 20px; /* Tambahkan padding atas */
            padding-bottom: 20px; /* Tambahkan padding bawah */

        }
        .login-image img {
            max-width: 100%;
            max-height: 100%;
            object-fit: cover; /* Pastikan gambar tetap proporsional */
        }
    </style>

</head>
<body>
<?php $setting = $this->m_admin->getByID("md_setting","id_setting",1)->row(); ?>
<div class="container-fluid login-container">
    <div class="row shadow-lg " style="width: 80%; max-width: 900px;">
        <!-- Left Side Image -->
        <div class="col-lg-6 login-image d-none d-lg-block">          
            <img src="assets/unh.jpg">
        </div>

        <!-- Right Side Login Form -->
        <div class="col-lg-6 bg-white p-5">
            <h2 class="text-center mb-4"><?=$setting->perusahaan?></h2>
            <form action="a4dm11n/login" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Username</label>
                    <input type="text" autocomplete="off" class="form-control" id="email" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" autocomplete="off" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-danger w-100">Login</button>                
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
