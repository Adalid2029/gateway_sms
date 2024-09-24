<?= $this->extend('Admin/others/email-templates/layout-email/master') ?>

<?= $this->section('style') ?>

<style type="text/css">
    body {
        width: 650px;
        font-family: work-Sans, sans-serif;
        background-color: #f6f7fb;
        display: block;
    }

    a {
        text-decoration: none;
    }

    span {
        font-size: 14px;
    }

    p {
        font-size: 13px;
        line-height: 1.7;
        letter-spacing: 0.7px;
        margin-top: 0;
    }

    .text-center {
        text-align: center
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('email-content') ?>

<table style="width: 100%">
    <tbody>
        <tr>
            <td>
                <table style="background-color: #f6f7fb; width: 100%">
                    <tbody>
                        <tr>
                            <td>
                                <table style="width: 650px; margin: 0 auto; margin-bottom: 30px">
                                    <tbody>
                                        <tr>
                                            <td><img src="<?=base_url()?>/assets/images/cuba-logo1.png" alt=""></td>
                                            <td style="text-align: right; color:#999"><span>Some Description</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table style="width: 650px; margin: 0 auto; background-color: #fff; border-radius: 8px">
                                    <tbody>
                                        <tr>
                                            <td style="padding: 30px">
                                                <p>Hi There,</p>
                                                <p>Sometimes you just want to send a simple HTML email with a simple design and clear call to action.</p>
                                                <div class="text-center"><a href="#" style="padding: 10px; background-color: #7366ff; color: #fff; display: inline-block; border-radius: 4px; margin-bottom: 18px">Call To Action </a></div>
                                                <p>This is a really simple email template. It's sole purpose is to get the recipient to click the button with no distractions.</p>
                                                <p style="margin-bottom: 0">Good luck! Hope it works.</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table style="width: 650px; margin: 0 auto; margin-top: 30px">
                                    <tbody>
                                        <tr style="text-align: center">
                                            <td>
                                                <p style="color: #999; margin-bottom: 0">333 Woodland Rd. Baldwinsville, NY 13027</p>
                                                <p style="color: #999; margin-bottom: 0">Don't Like These Emails?<a href="#" style="color: #7366ff">Unsubscribe</a></p>
                                                <p style="color: #999; margin-bottom: 0">Powered By Cuba Admin</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
<?= $this->endSection() ?>