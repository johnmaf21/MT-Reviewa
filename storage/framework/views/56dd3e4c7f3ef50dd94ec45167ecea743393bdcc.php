

<?php $__env->startSection('title', 'All of our visitors'); ?>

<?php $__env->startSection('content'); ?>
    <?php if($message = Session::get('success')): ?>
        <div class="alert alert-success">
            <p><?php echo e($message); ?></p>
        </div>
    <?php endif; ?>

    <?php $__currentLoopData = $visitors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $visitor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <article>
            <h3><a href="<?php echo e(route('visitors.show', $visitor->id)); ?>"><?php echo e($visitor->user->name); ?></a></h3>

            <p><?php echo e($visitor->comments); ?></p>

            <?php if(Auth::user() && Auth::user()->id === $visitor->user_id): ?>
                <form action="<?php echo e(route('visitors.destroy', $visitor->id)); ?>" method="POST">
                    <a class="btn btn-blue" href="<?php echo e(route('visitors.show', $visitor->id)); ?>">Show</a>
                    <a class="btn btn-blue" href="<?php echo e(route('visitors.edit', $visitor->id)); ?>">Edit</a>

                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>

                    <button type="submit" class="btn btn-red">Delete</button>
                </form>
            <?php endif; ?>
        </article>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


    <?php echo e($visitors->links()); ?>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\assignment02\resources\views/specificTvShow/index.blade.php ENDPATH**/ ?>