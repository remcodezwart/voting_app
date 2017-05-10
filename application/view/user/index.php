<div class="container">
    <h2 class="inline">partyen</h2>
    <form action="<?=Config::get('URL'); ?>party/add" class="inline" method="post">
        
        <input type="text" name="party">
        <input type="hidden" name="csrf_token" value="<?= Csrf::makeToken(); ?>">
        <button type="submit">Nieuwe partij toevoegen</button>
    </form>
    <div class="box">
        <?php foreach ($this->parties as $party) { ?>
            <div class="bar center">
                <a href="<?=Config::get('URL'); ?>party/index?party=<?=$party->name?>"><?=$party->name?></a>

                <form action="<?=Config::get('URL'); ?>party/delete" class="inline" method="post">
                    <input type="hidden" name="id" value="<?=$party->id ?>">
                    <input type="hidden" name="csrf_token" value="<?= Csrf::makeToken(); ?>">
                    <button type="submit">partij verwijderen</button>
                </form>

            </div>
        <?php } ?>
    </div>
</div>
<script src="<?=Config::get('URL'); ?>js/confirm.js" type="text/javascript"></script>