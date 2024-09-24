<?= $this->extend(config('Auth')->views['layout']) ?>
<?= $this->section('main') ?>
<div class="container-fluid p-0">
    <div class="row m-0">
        <div class="col-12 p-0">
            <div class="login-card">
                <div>
                    <div><a class="logo" href="<?= base_url("/") ?>">
                            <img class="img-fluid for-light" src="<?= base_url() ?>/assets/images/logo/logo.png" alt="loginpage">
                            <img class="img-fluid for-dark" src="<?= base_url() ?>/assets/images/logo/logo_dark.png" alt="loginpage">
                        </a></div>
                    <div class="login-main">
                        <?php if (session('error') !== null) : ?>
                            <div class="alert alert-danger" role="alert"><?= session('error') ?></div>
                        <?php elseif (session('errors') !== null) : ?>
                            <div class="alert alert-danger" role="alert">
                                <?php if (is_array(session('errors'))) : ?>
                                    <?php foreach (session('errors') as $error) : ?>
                                        <?= $error ?>
                                        <br>
                                    <?php endforeach ?>
                                <?php else : ?>
                                    <?= session('errors') ?>
                                <?php endif ?>
                            </div>
                        <?php endif ?>

                        <?php if (session('message') !== null) : ?>
                            <div class="alert alert-success" role="alert"><?= session('message') ?></div>
                        <?php endif ?>

                        <form action="<?= url_to('login') ?>" method="post" class="theme-form">
                            <?= csrf_field() ?>
                            <h4><?= lang('Auth.login') ?></h4>
                            <p>Enter your email & password to login</p>
                            <div class="form-group">
                                <label class="col-form-label"><?= lang('Auth.email') ?></label>
                                <input class="form-control" type="email" name="email" inputmode="email" autocomplete="email" value="<?= old('email') ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label"><?= lang('Auth.password') ?></label>
                                <div class="form-input position-relative">
                                    <input class="form-control" type="password" name="password" inputmode="text" autocomplete="current-password" required>
                                    <div class="show-hide"><span class="show"> </span></div>
                                </div>
                            </div>
                            <div class="form-group mb-0">
                                <?php if (setting('Auth.sessionConfig')['allowRemembering']): ?>
                                    <div class="checkbox p-0">
                                        <input id="checkbox1" type="checkbox" name="remember" <?php if (old('remember')): ?> checked<?php endif ?>>
                                        <label class="text-muted" for="checkbox1"><?= lang('Auth.rememberMe') ?></label>
                                    </div>
                                <?php endif; ?>
                                <?php if (setting('Auth.allowMagicLinkLogins')) : ?>
                                    <a class="link" href="<?= url_to('magic-link') ?>"><?= lang('Auth.forgotPassword') ?></a>
                                <?php endif ?>
                                <div class="text-end mt-3">
                                    <button class="btn btn-primary btn-block w-100" type="submit"><?= lang('Auth.login') ?></button>
                                </div>
                            </div>
                            <h6 class="text-muted mt-4 or">Or Sign in with</h6>
                            <!-- <div class="social mt-4">
                                <div class="btn-showcase">
                                    <a class="btn btn-light" href="https://accounts.google.com/signin/v2/identifier?hl=en&flowName=GlifWebSignIn&flowEntry=ServiceLogin" target="_blank"><i class="txt-google" data-feather="mail"></i>Google</a>
                                </div>
                            </div> -->
                            <?= $this->include('shield/partials/social_login') ?>
                            <?php if (setting('Auth.allowRegistration')) : ?>
                                <p class="mt-4 mb-0 text-center"><?= lang('Auth.needAccount') ?> <a class="ms-2" href="<?= url_to('register') ?>"><?= lang('Auth.register') ?></a></p>
                            <?php endif ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>