<div class="container">
	<h2 class="inline">statements</h2>
	<form action="<?=Config::get('URL'); ?>statement/add" class="inline" method="post">
        
        <input type="text" name="statement">
        <input type="hidden" name="csrf_token" value="<?= Csrf::makeToken(); ?>">
        <button type="submit">Nieuwe stelling toevoegen</button>
    </form>
    <div class="box">
        <?php foreach ($this->statments as $statement) { ?>
        	<form class="margin" action="<?=Config::get('URL'); ?>statement/edit" method="post">
        		<input type="text" value="<?=$statement->description?>" name="statement">
        		<label>verwijderen</label><input name="delete" type="checkbox">
        		<input type="hidden" name="csrf_token" value="<?= Csrf::makeToken(); ?>">
        		<input type="hidden" name="id" value="<?=$statement->id?>">
        		<button value="remove" type="submit">stelling editen</button>
  		  	</form>        
    	<?php } ?>
    </div>
</div>
<script src="<?=Config::get('URL'); ?>js/confirm.js" type="text/javascript"></script>