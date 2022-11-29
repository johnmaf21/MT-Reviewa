

<?php $__env->startSection('content'); ?>
    <div class="title">
        <h1><?php echo e($typeQuery); ?></h1>
    </div>

    <?php for($y=0; $y<4; $y++): ?>
        <div class="see-all-media">
                <?php for($x=0; $x<5; $x++): ?>
                    <?php if(array_key_exists(($y+($x*$y)+4), $results)): ?>
                        <div class="see-all-container">
                            <?php if(array_key_exists('name',$results[$y+(($x*$y)+4)])): ?>
                                <div class="media">
                                    <a class="media-links" href="<?php echo e("/tvshows/".$results[$y+(($x*$y))]['id']); ?>"><img src="<?php echo e("https://image.tmdb.org/t/p/w154".$results[$y+(($x*$y))]['poster_path']); ?>" alt="poster"></a>
                                    <a class="media-links" href="<?php echo e("/tvshows/".$results[$y+(($x*$y))]['id']); ?>"><?php echo e($results[$y+(($x*$y))]['name']); ?></a>
                                </div>
                            <?php else: ?>
                                <div class="media">
                                    <a class="media-links" href="<?php echo e("/movies/".$results[$y+(($x*$y))]['id']); ?>"><img src="<?php echo e("https://image.tmdb.org/t/p/w154".$results[$y+(($x*$y))]['poster_path']); ?>" alt="poster"></a>
                                    <a class="media-links" href="<?php echo e("/movies/".$results[$y+(($x*$y))]['id']); ?>"><?php echo e($results[$y+(($x*$y))]['title']); ?></a>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php endfor; ?>
        </div>
    <?php endfor; ?>

    <>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\assignment02\resources\views/seeAll/index.blade.php ENDPATH**/ ?>