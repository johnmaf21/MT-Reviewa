

<?php $__env->startSection('content'); ?>
    <div class="title">
        <h1>Tv Shows</h1>
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
                <?php $__currentLoopData = $watchlist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tvShow): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="media">
                        <?php if(!Auth::guest()): ?>
                            <?php if(!empty($watchlist)): ?>
                                <?php if(array_key_exists($tvShow['id'],$watchlist)): ?>
                                    <a class="in-watchlist" href="<?php echo e(route('tvShow.removeFromWatchlist', $tvShow['id'])); ?>">Remove</a>
                                <?php else: ?>
                                    <a class="out-watchlist" href="<?php echo e(route('tvShow.addToWatchlist', $tvShow['id'])); ?>">Add</a>
                                <?php endif; ?>
                            <?php elseif(!array_key_exists($tvShow['id'],$completed)): ?>
                                <a class="out-watchlist" href="<?php echo e(route('tvShow.addToWatchlist', $tvShow['id'])); ?>">Add</a>
                            <?php else: ?>
                                <a class="out-watchlist" href="">Completed</a>
                            <?php endif; ?>
                        <?php endif; ?>
                            <a class="media-links" href="<?php echo e("/tvShows/".$tvShow['id']); ?>"><img src="<?php echo e("https://image.tmdb.org/t/p/w154".$tvShow['poster_path']); ?>" alt="poster"></a>
                            <a class="media-links" href="<?php echo e("/tvShows/".$tvShow['id']); ?>"><?php echo e($tvShow['name']); ?></a>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    <?php endif; ?>

    <?php $__currentLoopData = $tvShows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tvShowType => $tvShowTypeOptions): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if(!empty($tvShowTypeOptions)): ?>
            <div class="media-options">
                <div class="media-type">
                    <h2><?php echo e($tvShowType); ?></h2>
                    <a href="<?php echo e(route('tvShow.displaySeeAll', [$tvShowType, 'null', 0])); ?>">See more</a>
                </div>
                <div class="media-container">
                    <?php $__currentLoopData = $tvShowTypeOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tvShow): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="media">
                            <?php if(!Auth::guest()): ?>
                                <?php if(!empty($watchlist)): ?>
                                    <?php if(array_key_exists($tvShow['id'],$watchlist)): ?>
                                        <a class="in-watchlist" href="<?php echo e(route('tvShow.removeFromWatchlist', $tvShow['id'])); ?>">Remove</a>
                                    <?php else: ?>
                                        <a class="out-watchlist" href="<?php echo e(route('tvShow.addToWatchlist', $tvShow['id'])); ?>">Add</a>
                                    <?php endif; ?>
                                <?php elseif(!array_key_exists($tvShow['id'],$completed)): ?>
                                    <a class="out-watchlist" href="<?php echo e(route('tvShow.addToWatchlist', $tvShow['id'])); ?>">Add</a>
                                <?php else: ?>
                                    <a class="out-watchlist" href="">Completed</a>
                                <?php endif; ?>
                            <?php endif; ?>
                            <a class="media-links" href="<?php echo e("/tvShows/".$tvShow['id']); ?>"><img src="<?php echo e("https://image.tmdb.org/t/p/w154".$tvShow['poster_path']); ?>" alt="poster"></a>
                            <a class="media-links" href="<?php echo e("/tvShows/".$tvShow['id']); ?>"><?php echo e($tvShow['name']); ?></a>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <?php $__currentLoopData = $genres; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $genre => $tvShows): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if(!empty($tvShows['$tvShows'])): ?>
            <div class="media-options">
                <div class="media-type">
                    <h2><?php echo e($genre); ?></h2>
                    <a href="<?php echo e(route('tvShow.displaySeeAll', ['genre', $genre, $tvShows['genre_id']])); ?>">See more</a>
                </div>
                <div class="media-container">
                    <?php $__currentLoopData = $tvShows['tvShows']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tvShow): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="media">
                            <?php if(!Auth::guest()): ?>
                                <?php if(!empty($watchlist)): ?>
                                    <?php if(array_key_exists($tvShow['id'],$watchlist)): ?>
                                        <a class="in-watchlist" href="<?php echo e(route('tvShow.removeFromWatchlist', $tvShow['id'])); ?>">Remove</a>
                                    <?php else: ?>
                                        <a class="out-watchlist" href="<?php echo e(route('tvShow.addToWatchlist', $tvShow['id'])); ?>">Add</a>
                                    <?php endif; ?>
                                <?php elseif(!array_key_exists($tvShow['id'],$completed)): ?>
                                    <a class="out-watchlist" href="<?php echo e(route('tvShow.addToWatchlist', $tvShow['id'])); ?>">Add</a>
                                <?php else: ?>
                                    <a class="out-watchlist" href="">Completed</a>
                                <?php endif; ?>
                            <?php endif; ?>
                            <a class="media-links" href="<?php echo e("/tvShows/".$tvShow['id']); ?>"><img src="<?php echo e("https://image.tmdb.org/t/p/w154".$tvShow['poster_path']); ?>" alt="poster"></a>
                            <a class="media-links" href="<?php echo e("/tvShows/".$tvShow['id']); ?>"><?php echo e($tvShow['name']); ?></a>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\assignment02\resources\views/tvShows/index.blade.php ENDPATH**/ ?>