

<?php $__env->startSection('content'); ?>
    <div class="user__title"><h1><?php echo e(__('Verify Your Email Address')); ?></h1></div>
    <div class="welcome__text">
        <p><?php echo e(__('Before proceeding, please check your email for a verification link.')); ?>

            <?php echo e(__('If you did not receive the email')); ?></p>
    </div>
    <div class="login-container">
        <form class="d-inline" method="POST" action="<?php echo e(route('verification.resend')); ?>">
            <?php echo csrf_field(); ?>
            <button type="submit" class="reset-button"><?php echo e(__('click here to request another')); ?></button>
            <?php if(session('resent')): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo e(__('A fresh verification link has been sent to your email address.')); ?>

                </div>
            <?php endif; ?>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\assignment02\resources\views/auth/verify.blade.php ENDPATH**/ ?>