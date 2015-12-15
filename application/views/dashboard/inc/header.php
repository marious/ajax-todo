<!DOCTYPE html>
<html lang="en">
<head>
    <title>Title</title>
    <meta charset="UTF-8">
    <meta name=description content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= base_url(); ?>public/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>public/css//bootstrap-theme.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>public/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>public/css/custom.css">

    <script src="<?= base_url(); ?>public/js/jquery-1.11.2.min.js"></script>
    <script src="<?= base_url(); ?>public/js/tododash/dashboard/result.js"></script>
    <script src="<?= base_url(); ?>public/js/tododash/dashboard/event.js"></script>
    <script src="<?= base_url(); ?>public/js/tododash/dashboard/template.js"></script>
    <script src="<?= base_url(); ?>public/js/tododash/dashboard.js"></script>
    <script>
        $(document).ready(function() {
            // Init dashboard app
            var dashboard = new Dashboard();
        });
    </script>
</head>
<body>

<nav class="navbar navbar-default" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">MYTodo</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav">
            <li class="active"><?= anchor('dashboard', 'Dashboard'); ?></li>
            <li><?= anchor('dashboard/', 'User'); ?></li>
        </ul>

        <ul class="nav navbar-nav navbar-right">
            <li><?= anchor('dashboard/logout', 'Logout'); ?></li>
        </ul>
    </div><!-- /.navbar-collapse -->
</nav>

