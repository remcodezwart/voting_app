<div class="container">
    <h2 class="inline">partyen</h2>
    <form name="submit" action="<?=Config::get('URL'); ?>party/new" class="inline" method="post">
        
        <input type="text" name="party">
        <input type="hidden" name="csrf_token" value="<?= Csrf::makeToken(); ?>">
        <button type="submit">Nieuwe partij toevoegen</button>
    </form>
    <div class="box">
        <?php foreach ($this->parties as $party) { ?>
            <div class="bar center"><a href="<?=Config::get('URL'); ?>party/index?party=<?=$party->name?>"><?=$party->name?></a></div>
        <?php } ?>
    </div>
</div>
<script src="<?=Config::get('URL'); ?>js/confirm.js" type="text/javascript"></script>