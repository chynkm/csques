<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php echo $template['title']; ?></title>
        <meta name="description" content="<?php echo isset($meta_description) ? $meta_description: null; ?>">
        <meta name="author" content="<?php echo get_domain_name(); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="<?php echo asset_url('css/normalize.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo asset_url('css/skeleton.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo asset_url('css/foundation-icons/foundation-icons.css'); ?>">
        <link rel="stylesheet" href="<?php echo asset_url('css/style.css'); ?>">
        <link rel="icon" type="image/png" href="images/favicon.png">
        <link rel="canonical" href="<?php echo current_url(); ?>">
        <script src="<?php echo asset_url('js/zepto.min.js'); ?>"></script>
    </head>
    <body>
        <nav class="navbar">
            <div class="container">
                <ul class="navbar-list">
                    <li class="navbar-item"><a class="navbar-link" href="<?php echo site_url('/'); ?>">MCQP</a></li>
                    <li class="navbar-item"><a class="navbar-link" href="<?php echo site_url('about'); ?>">ABOUT</a></li>
                    <li class="navbar-item"><a class="navbar-link" href="<?php echo site_url('contact-us'); ?>">CONTACT US</a></li>
                </ul>
            </div>
        </nav>
        <div class="container main_content">
            <?php echo get_status_message($this->session->flashdata('status'), $this->session->flashdata('msg')); ?>
            <?php echo $template['body']; ?>
            <div class="footer_push"></div>
        </div>
        <div class="footer">
            <div class="row">
                <div class="twelve column">
                    <p class="text-center">&copy; <?php echo date('Y').' '.get_domain_name(); ?></p>
                </div>
            </div>
            <script src="<?php echo asset_url('js/common.js'); ?>"></script>
        </div>
    </body>
</html>
