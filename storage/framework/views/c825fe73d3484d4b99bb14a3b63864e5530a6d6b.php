

<?php $__env->startSection('content'); ?>
    <div class="user__title">
        <h1>Login</h1>
    </div>
    <div class="welcome__text">
        <p>Login and get back to the movies and shows you love</p>
    </div>
    <div class="login-container">
        <form method="POST" action="<?php echo e(route('authenticate')); ?>">
            <?php echo csrf_field(); ?>

            <div class="entry">
                <input id="email" type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email" value="<?php echo e(old('email')); ?>" required autocomplete="email" autofocus placeholder=" email">
            </div>

            <div class="entry">
                <input id="password" type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password" value="<?php echo e(old('password')); ?>" required autocomplete="password" autofocus placeholder=" password">
            </div>

            <div class="options">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>>
                    <span class="checkmark"></span>
                    <label class="form-check-label" for="remember">
                        <?php echo e(__('Remember Me')); ?>

                    </label>
                </div>

                <div class="forget-password">
                    <a href="/password/reset">Forgot Password</a>
                </div>
            </div>

            <div class="submit">
                <button type="submit" class="login-submit-button">
                    <?php echo e(__('Login')); ?>

                </button>
            </div>
            <?php $__errorArgs = ['email'];
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
            <?php $__errorArgs = ['password'];
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
    <div class="other-login-options">
        <p>Other Login Options</p>
        <a href="/auth/google/redirect"><img src="<?php echo e(asset('images/google.png')); ?>"></a>
        <a href="/auth/twitter/redirect"><img src="<?php echo e(asset('images/twitter.png')); ?>"></a>
        <a href="/auth/github/redirect"><img src="<?php echo e(asset('images/github.png')); ?>"></a>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\assignment02\resources\views/auth/login.blade.php ENDPATH**/ ?>