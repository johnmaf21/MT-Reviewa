<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>MT Reviews</title>

        <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">
    </head>
    <body style="background:#1456fe">
        <section class="header">
            <div class="container mx-auto">
                <?php if(Auth::guest()): ?>
                    <nav>
                        <ul class="nav__links">
                            <li><a class="logo" href="/"><img alt="logo" src=<?php echo e(asset("images/logo/logo.png")); ?> width="50px" height="50px"></a></li>
                            <li><a href="/login">Login</a></li>
                            <li><a href="/register">Register</a></li>
                        </ul>
                    </nav>
                <?php else: ?>
                    <nav>
                        <ul class="nav__links">
                            <li><a class="logo" href="/"><img alt="logo" src=<?php echo e(asset("images/logo/logo.png")); ?> width="50px" height="50px"></a></li>
                            <li><a href="/movies">Movies</a></li>
                            <li><a href="/tvshows">Tv Shows</a></li>
                            <li><a href="/profile">Profile</a></li>
                            <li><a href="/logout"><img src=<?php echo e(asset("images/others/logout.png")); ?> alt="logo" width="50px" height="50px"></a></li>
                        </ul>
                    </nav>
                <?php endif; ?>
            </div>
        </section>

        <section class="content">
            <div class="container mx-auto">
                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </section>

    </body>
</html>
<?php /**PATH C:\xampp\htdocs\mtreviews\resources\views/layouts/app.blade.php ENDPATH**/ ?>