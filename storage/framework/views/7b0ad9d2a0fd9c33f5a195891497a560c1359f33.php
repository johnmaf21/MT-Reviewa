

<?php $__env->startSection('content'); ?>
    <div class="user__title"><h1>Two Factor Authentication</h1></div>
    <div class="welcome__text"><p>Please enter the code sent to your email to login. If you haven't recieved the code press <a href="<?php echo e(route('login.resend')); ?>">here</a> for a new one</p></div>

    <div class="login-container">
        <form method="POST" action="<?php echo e(route('login.twoFactor')); ?>">
            <?php echo csrf_field(); ?>

                <div class="entry">
                    <input id="two_factor_code" type="text" class="form-control <?php $__errorArgs = ['two_factor_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="two_factor_code" required autocomplete="two_factor_code" placeholder="  Enter code here">
                </div>

                <div class="submit">
                    <button type="submit" class="login-submit-button">
                        Verify
                    </button>
                </div>
                <?php $__errorArgs = ['two_factor_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="invalid-feedback" role="alert">
                    <strong><?php echo e($message); ?></strong>
                </span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\assignment02\resources\views/auth/two-factor-challenge.blade.php ENDPATH**/ ?>