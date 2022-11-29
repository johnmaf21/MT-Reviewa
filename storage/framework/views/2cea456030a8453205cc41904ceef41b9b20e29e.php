

<?php $__env->startSection('content'); ?>
    <div class="title">
        <h1>Movies</h1>
    </div>
    <?php if(Auth::guest()): ?>
        <div class="intro__text">
            <p><a href="/register">Create an account</a> or <a href="/login">sign in</a> to add movies to your watchlist</p>
        </div>
    <?php endif; ?>

    <?php if(!empty($watchlist)): ?>
        <div class="media-options">
            <div class="media-type">
                <h2>Your Watchlist</h2>
                <a href="/profile">See in profile</a>
            </div>
            <div class="media-container">
                <?php $__currentLoopData = $watchlist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $movie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="media">
                        <?php if(!Auth::guest()): ?>
                            <?php if(!empty($watchlist)): ?>
                                <?php if(array_key_exists($movie['id'],$watchlist)): ?>
                                    <a class="in-watchlist" href="<?php echo e(route('movie.removeFromWatchlist', $movie['id'])); ?>">Remove</a>
                                <?php else: ?>
                                    <a class="out-watchlist" href="<?php echo e(route('movie.addToWatchlist', $movie['id'])); ?>">Add</a>
                                <?php endif; ?>
                            <?php elseif(!array_key_exists($movie['id'],$completed)): ?>
                                <a class="out-watchlist" href="<?php echo e(route('movie.addToWatchlist', $movie['id'])); ?>">Add</a>
                            <?php else: ?>
                                <a class="out-watchlist" href="">Completed</a>
                            <?php endif; ?>
                        <?php endif; ?>
                        <a class="media-links" href="<?php echo e("/movies/".$movie['id']); ?>"><img src="<?php echo e("https://image.tmdb.org/t/p/w154".$movie['poster_path']); ?>" alt="poster"></a>
                        <a class="media-links" href="<?php echo e("/movies/".$movie['id']); ?>"><?php echo e($movie['title']); ?></a>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    <?php endif; ?>

    <?php $__currentLoopData = $movies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $movieType => $movieTypeOptions): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if(!empty($movieTypeOptions)): ?>
            <div class="media-options">
                <div class="media-type">
                    <h2><?php echo e($movieType); ?></h2>
                    <a href="<?php echo e(route('movie.displaySeeAll', [$movieType, 'null', 0])); ?>">See more</a>
                </div>
                <div class="media-container">
                    <?php $__currentLoopData = $movieTypeOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $movie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="media">
                            <?php if(!Auth::guest()): ?>
                                <?php if(!empty($watchlist)): ?>
                                    <?php if(array_key_exists($movie['id'],$watchlist)): ?>
                                        <a class="in-watchlist" href="<?php echo e(route('movie.removeFromWatchlist', $movie['id'])); ?>">Remove</a>
                                    <?php else: ?>
                                        <a class="out-watchlist" href="<?php echo e(route('movie.addToWatchlist', $movie['id'])); ?>">Add</a>
                                    <?php endif; ?>
                                <?php elseif(!array_key_exists($movie['id'],$completed)): ?>
                                    <a class="out-watchlist" href="<?php echo e(route('movie.addToWatchlist', $movie['id'])); ?>">Add</a>
                                <?php else: ?>
                                    <a class="out-watchlist" href="">Completed</a>
                                <?php endif; ?>
                            <?php endif; ?>
                            <a class="media-links" href="<?php echo e("/movies/".$movie['id']); ?>"><img src="<?php echo e("https://image.tmdb.org/t/p/w154".$movie['poster_path']); ?>" alt="poster"></a>
                            <a class="media-links" href="<?php echo e("/movies/".$movie['id']); ?>"><?php echo e($movie['title']); ?></a>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <?php $__currentLoopData = $genres; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $genre => $movies): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if(!empty($movies['movies'])): ?>
            <div class="media-options">
                <div class="media-type">
                    <h2><?php echo e($genre); ?></h2>
                    <a href="<?php echo e(route('movie.displaySeeAll', ['genre', $genre, $movies['genre_id']])); ?>">See more</a>
                </div>
                <div class="media-container">
                    <?php $__currentLoopData = $movies['movies']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $movie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="media">
                            <?php if(!Auth::guest()): ?>
                                <?php if(!empty($watchlist)): ?>
                                    <?php if(array_key_exists($movie['id'],$watchlist)): ?>
                                        <a class="in-watchlist" href="<?php echo e(route('movie.removeFromWatchlist', $movie['id'])); ?>">Remove</a>
                                    <?php else: ?>
                                        <a class="out-watchlist" href="<?php echo e(route('movie.addToWatchlist', $movie['id'])); ?>">Add</a>
                                    <?php endif; ?>
                                <?php elseif(!array_key_exists($movie['id'],$completed)): ?>
                                    <a class="out-watchlist" href="<?php echo e(route('movie.addToWatchlist', $movie['id'])); ?>">Add</a>
                                <?php else: ?>
                                    <a class="out-watchlist" href="">Completed</a>
                                <?php endif; ?>
                            <?php endif; ?>
                            <a class="media-links" href="<?php echo e("/movies/".$movie['id']); ?>"><img src="<?php echo e("https://image.tmdb.org/t/p/w154".$movie['poster_path']); ?>" alt="poster"></a>
                            <a class="media-links" href="<?php echo e("/movies/".$movie['id']); ?>"><?php echo e($movie['title']); ?></a>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\assignment02\resources\views/movies/index.blade.php ENDPATH**/ ?>