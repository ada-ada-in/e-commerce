
<!DOCTYPE html>

<html lang="en">

<?= view('components/include/head') ?>

<body>

<?= view('components/include/preloader') ?>

    <div id="main-wrapper">

    <?= view('components/include/nav-header') ?>

    <?= view('components/include/header') ?>

    <?= view('components/include/sidebar') ?>

        <div class="content-body">
            <div class="container-fluid">
            <?= $this->rendersection('content') ?>
            </div>
        </div>

    </div>



    <script src="/assets/focus2/vendor/global/global.min.js"></script>
    <script src="/assets/focus2/js/quixnav-init.js"></script>
    <script src="/assets/focus2/js/custom.min.js"></script>
    <script src="/assets/focus2/vendor/chartist/js/chartist.min.js"></script>
    <script src="/assets/focus2/vendor/moment/moment.min.js"></script>
    <script src="/assets/focus2/vendor/pg-calendar/js/pignose.calendar.min.js"></script>
    <script src="/assets/focus2/js/dashboard/dashboard-2.js"></script>

</body>

</html>