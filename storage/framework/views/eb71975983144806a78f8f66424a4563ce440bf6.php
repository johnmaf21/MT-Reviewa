<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>MT Reviews</title>

    <!-- Fonts -->
    <link href="http://fonts.cdnfonts.com/css/gotham" rel="stylesheet">

    <!-- Styles -->
    <link type="text/css" href="/app.css" rel="stylesheet">
</head>
<body class="mainBody">
<div id="app">
    <div class="header2">
        <a class="logo" href="/">
            <img src="<?php echo e(asset('images/transparentLogo3.png')); ?>" alt="home">
        </a>
        <nav>
            <!-- Links -->
            <?php if(Auth::guest()): ?>
                <ul class="nav__links__main">
                    <li><a href="/register">Sign Up</a></li>
                    <li><a href="/login">Login</a></li>
                    <li><a href="/movies">Movies</a></li>
                    <li><a href="/tvshows">Tv Shows</a></li>
                </ul>
            <?php else: ?>
                <ul class="nav__links__main">
                    <li><a href="/movies">Movies</a></li>
                    <li><a href="/tvshows">Tv Shows</a></li>
                    <li><a href="/profile">Profile</a></li>
                    <li><a style="color: #FF2400;" href="/logout">logout</a></li>
                    <?php if(Auth::user()->email_verified_at === null): ?>
                        <li><a style="color: #FF2400;" href="/email/verify">Verify Email</a></li>
                    <?php endif; ?>
                </ul>
            <?php endif; ?>
        </nav>
    </div>
    <main class="py-4">
        <?php echo $__env->yieldContent('content'); ?>
    </main>
</div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\assignment02\resources\views/layouts/app2.blade.php ENDPATH**/ ?>