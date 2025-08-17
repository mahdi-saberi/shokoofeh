<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ورود - فروشگاه اسباب بازی شکوفه</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Instrument Sans', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            background: white;
            padding: 3rem;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-header h1 {
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }

        .login-header p {
            color: #7f8c8d;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #2c3e50;
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 1rem;
            border: 2px solid #ecf0f1;
            border-radius: 10px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        .form-control:focus {
            outline: none;
            border-color: #3498db;
        }

        .btn {
            width: 100%;
            padding: 1rem;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }

        .btn:hover {
            background: #2980b9;
        }

        .login-footer {
            text-align: center;
            margin-top: 2rem;
        }

        .login-footer a {
            color: #3498db;
            text-decoration: none;
        }

        .back-home {
            text-align: center;
            margin-top: 1rem;
        }

        .back-home a {
            color: #7f8c8d;
            text-decoration: none;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 0 1rem;
            }

            .login-container {
                min-height: 100vh;
                padding: 2rem 0;
            }

            .login-card {
                padding: 2rem 1.5rem;
                margin: 1rem;
                box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            }

            .login-header h1 {
                font-size: 1.5rem;
            }

            .login-header p {
                font-size: 0.9rem;
                margin-bottom: 1.5rem;
            }

            .form-group label {
                font-size: 0.9rem;
                margin-bottom: 0.5rem;
            }

            .form-control {
                padding: 1rem;
                font-size: 16px; /* Prevents zoom on iOS */
                min-height: 48px;
            }

            .form-control:focus {
                box-shadow: 0 0 0 3px rgba(0,123,255,.25);
            }

            .btn {
                padding: 1rem 2rem;
                font-size: 1rem;
                min-height: 48px;
                width: 100%;
            }

            .login-footer {
                margin-top: 1.5rem;
                font-size: 0.9rem;
            }

            .login-footer a {
                display: block;
                margin-top: 0.5rem;
            }

            .alert {
                padding: 1rem;
                font-size: 0.9rem;
                margin-bottom: 1rem;
            }
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 1rem 0;
            }

            .login-card {
                padding: 1.5rem 1rem;
                margin: 0.5rem;
                border-radius: 8px;
            }

            .login-header h1 {
                font-size: 1.3rem;
            }

            .login-header p {
                font-size: 0.8rem;
            }

            .form-control {
                padding: 0.75rem;
                font-size: 16px;
            }

            .btn {
                padding: 0.75rem 1.5rem;
                font-size: 0.9rem;
            }

            .login-footer {
                font-size: 0.8rem;
            }
        }

        /* Touch device optimizations */
        @media (hover: none) and (pointer: coarse) {
            .form-control {
                min-height: 48px;
                font-size: 16px;
            }

            .btn {
                min-height: 48px;
            }

            .btn:hover {
                background: #0056b3;
                transform: none;
            }

            .btn:active {
                transform: scale(0.98);
                transition: transform 0.1s ease;
            }
        }

        /* High contrast mode */
        @media (prefers-contrast: high) {
            .login-card {
                border: 2px solid #000;
            }

            .form-control {
                border-width: 2px;
            }

            .btn {
                border: 2px solid #007bff;
            }
        }

        /* Focus indicators for keyboard navigation */
        .form-control:focus,
        .btn:focus {
            outline: 2px solid #007bff;
            outline-offset: 2px;
        }

        /* Reduced motion support */
        @media (prefers-reduced-motion: reduce) {
            .btn {
                transition: none;
            }

            .btn:hover {
                transform: none;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="container">
            <div class="login-card">
                <div class="login-header">
                    <h1>🧸 ورود به پنل مدیریت</h1>
                    <p>به فروشگاه شکوفه خوش آمدید</p>
                </div>

                <?php if($errors->any()): ?>
                    <div class="alert alert-danger">
                        <ul style="margin: 0; padding-right: 1rem;">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if(session('error')): ?>
                    <div class="alert alert-danger">
                        <?php echo e(session('error')); ?>

                    </div>
                <?php endif; ?>

                <form method="POST" action="<?php echo e(route('login')); ?>">
                    <?php echo csrf_field(); ?>

                    <div class="form-group">
                        <label for="email">ایمیل:</label>
                        <input type="email"
                               id="email"
                               name="email"
                               class="form-control"
                               value="<?php echo e(old('email')); ?>"
                               required
                               autocomplete="email"
                               placeholder="ایمیل خود را وارد کنید">
                    </div>

                    <div class="form-group">
                        <label for="password">کلمه عبور:</label>
                        <input type="password"
                               id="password"
                               name="password"
                               class="form-control"
                               required
                               autocomplete="current-password"
                               placeholder="کلمه عبور خود را وارد کنید">
                    </div>

                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <label class="checkbox-label">
                            <input type="checkbox" name="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>>
                            <span class="checkmark"></span>
                            مرا به خاطر بسپار
                        </label>
                    </div>

                    <button type="submit" class="btn">ورود</button>
                </form>

                <div class="login-footer">
                    <a href="<?php echo e(route('password.request')); ?>">فراموشی کلمه عبور؟</a>
                    <a href="<?php echo e(route('welcome')); ?>">بازگشت به صفحه اصلی</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php /**PATH /var/www/resources/views/auth/login.blade.php ENDPATH**/ ?>