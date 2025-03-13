
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


    <?= view('components/include/script') ?>
    <?= $this->rendersection('script') ?>

</body>

</html>