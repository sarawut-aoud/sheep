<div class="content-header d-none d-lg-inline">
    <div class="container-fluid">
        <div class="row ">
            <ol class="breadcrumb m-0">
                <?php foreach ($breadcrumb as $key => $val) : ?>
                    <li class="breadcrumb-item <?= $val['class'] ?>"><a href="<?= $val['ref'] ?>"><?= $val['name'] ?></a></li>
                <?php endforeach; ?>
            </ol>
        </div>
    </div>
</div>