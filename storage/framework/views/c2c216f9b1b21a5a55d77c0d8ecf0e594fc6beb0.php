<?php $__env->startSection('content'); ?>
    <div class="next">
        <h1 class="specific__title"><?php echo e($movie['title']); ?></h1>
        <p><?php echo e($movie['release_date']."  .  ".date('h:i ', mktime(0,$movie['runtime']))."  .  ".(string)($movie['vote_average']*10).'%'); ?></p>
        <p style="font-weight: lighter;"><?php echo e($movie['overview']); ?></p>
        <div class="genres">
            <?php $__currentLoopData = $movie['genres']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $genre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('seeAll.getNewPage', ['genre', 'movie', 1, $genre['name'], $genre['id'], 1])); ?>"><?php echo e($genre['name']); ?></a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <div class="socials">
            <?php if($movie['homepage'] !== null): ?>
                <a href="<?php echo e($movie['homepage']); ?>"><img src="<?php echo e(asset("images/web.png")); ?>" alt="<?php echo e($movie['title']." webpage"); ?>"></a>
            <?php endif; ?>
            <?php if($movie['external_ids']['twitter_id'] !== null): ?>
                <a href="<?php echo e("https://twitter.com/".$movie['external_ids']['twitter_id']); ?>"><img src="<?php echo e(asset("images/twitter.png")); ?>" alt="<?php echo e($movie['title']." twitter account"); ?>"></a>
            <?php endif; ?>
            <?php if($movie['external_ids']['instagram_id'] !== null): ?>
                <a href="<?php echo e("https://www.instagram.com/".$movie['external_ids']['instagram_id']); ?>"><img src="<?php echo e(asset("images/instagram.png")); ?>" alt="<?php echo e($movie['title']." instagram account"); ?>"></a>
            <?php endif; ?>
            <?php if($movie['external_ids']['facebook_id'] !== null): ?>
                <a href="<?php echo e("https://en-gb.facebook.com/".$movie['external_ids']['facebook_id']); ?>"><img src="<?php echo e(asset("images/facebook.png")); ?>" alt="<?php echo e($movie['title']." facebook account"); ?>"></a>
            <?php endif; ?>
        </div>
        <?php if(!Auth::guest()): ?>
            <?php if($inWatchlist): ?>
                <?php if(!$mediaUser->is_completed): ?>
                    <p style="font-weight: lighter;">Watched?: <a href="<?php echo e(route('movie.hasWatched', [$movie['id'], $mediaUser, 1])); ?>"><img src="<?php echo e(asset('images/greyCheck.png')); ?>" width="30px"></a></p>
                    <a class="in-watchlist" href="<?php echo e(route('movie.removeFromWatchlist', $movie['id'])); ?>">Remove</a>
                <?php else: ?>
                    <a href="<?php echo e(route('movie.hasWatched', [$movie['id'], $mediaUser, 0])); ?>"><img src="<?php echo e(asset('images/greenCheck.png')); ?>" width="30px"></a>
                <?php endif; ?>
            <?php else: ?>
                <a class="out-watchlist" href="<?php echo e(route('movie.addToWatchlist', $movie['id'])); ?>">Add</a>
            <?php endif; ?>
        <?php else: ?>
            <p style="font-weight: lighter;"><a href="/register">Create an account</a> or <a href="/login">sign in</a> to add movies to your watchlist</p>
        <?php endif; ?>
    </div>


    <div class="backdrop">
        <img src="<?php echo e("https://image.tmdb.org/t/p/original".$movie['backdrop_path']); ?>" alt="<?php echo e($movie['title']." backdrop"); ?>">
    </div>

    <div class="comments">
        <?php if(!Auth::guest()): ?>
            <?php if(empty($comments)): ?>
                <p>Share your thoughts. Be the first to comment</p>
            <?php endif; ?>
            <div class="curr-user-comment">
                <form method="POST" action="<?php echo e(route('movie.postComment', [$movie['id'],$reviewDetails])); ?>">
                <?php echo csrf_field(); ?>
                    <img src="<?php echo e(Auth::user()->profile_pic); ?>">
                    <div class="comment-entry">
                        <textarea id="comment" name="comment" placeholder=" Share your thoughts"> </textarea>
                    </div>

                    <button type="submit" class="post-button">
                        Post
                    </button>
                </form>
            </div>
        <?php else: ?>
            <p style="font-weight: lighter;"><a href="/register">Create an account</a> or <a href="/login">sign in</a> to share your own thoughts on <?php echo e($movie['title']); ?></p>
        <?php endif; ?>
        <?php $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="user-comment">
                    <div class="user-head">
                        <img src="<?php echo e($comment->user->profile_pic); ?>">
                        <p><?php echo e($comment->user->username); ?></p>
                        <p><?php echo e($comment->date_posted); ?></p>
                    </div>
                    <p class="actual-comment"><?php echo e($comment->comment); ?></p>

                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <div class="availabilty">

    </div>

    <div class="cast">
        <h2>Cast</h2>
        <div class="cast-group">
        <?php for($x=0; $x<20; $x++): ?>
            <?php if(array_key_exists($x,$movie['credits']['cast'])): ?>
                <div class="cast-member">
                    <?php if($movie['credits']['cast'][$x]['profile_path'] === null): ?>
                        <img src="<?php echo e(asset('images/profile_placeholder.png')); ?>">
                    <?php else: ?>
                        <img src="<?php echo e("https://image.tmdb.org/t/p/w185".$movie['credits']['cast'][$x]['profile_path']); ?>">
                    <?php endif; ?>
                    <p class="cast-name"><?php echo e($movie['credits']['cast'][$x]['name']); ?></p>
                    <p class="cast-character"><?php echo e($movie['credits']['cast'][$x]['character']); ?></p>
                </div>
            <?php endif; ?>
        <?php endfor; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app3', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\assignment02\resources\views/specificMovie/index.blade.php ENDPATH**/ ?>