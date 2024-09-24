<?= $this->extend('Admin/others/layout/master') ?>

<?= $this->section('content') ?>
<div class="comingsoon auth-bg-video">
    <video class="bgvideo-comingsoon" id="bgvid" poster="<?=base_url()?>/assets/images/other-images/coming-soon-bg.jpg" playsinline="" autoplay="" muted="" loop="">
        <source src="<?=base_url()?>/assets/video/auth-bg.mp4" type="video/mp4">
    </video>
    <div class="comingsoon-inner text-center"><img src="<?=base_url()?>/assets/images/other-images/logo-login.png" alt="">
        <h5>WE ARE COMING SOON</h5>
        <div class="countdown" id="clockdiv">
            <ul>
                <li><span class="time" id="days"></span><span class="title">days</span></li>
                <li><span class="time" id="hours"></span><span class="title">Hours</span></li>
                <li><span class="time" id="minutes"></span><span class="title">Minutes</span></li>
                <li><span class="time" id="seconds"></span><span class="title">Seconds</span></li>
            </ul>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script-other') ?>
<script src="<?=base_url()?>/assets/js/countdown.js"></script>
<?= $this->endSection() ?>