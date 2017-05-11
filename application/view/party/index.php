<div class="container">
    <?php $this->renderFeedbackMessages(); ?>
    <h2>partij naam <?=$this->party->name ?></h2>
    <div class="box">
    	<h3>statements</h3>
    	<form method="post" action="<?=Config::get('URL'); ?>party/edit">
        <?php foreach ($this->statements as $statement) { ?>
        	<label><?=$statement->description ?></label>
        	<select name="statements[]">
        		<option <?php if ( View::compare($statement, 1)) {
                             echo 'selected="true"';
                        } ?> value="1">voor</option>
        		<option <?php if ( View::compare($statement, 0)) {
                             echo 'selected="true"';
                        } ?> value="0">weet niet</option>
        		<option <?php if ( View::compare($statement, -1)) {
                             echo 'selected="true"';
                        } ?> value="-1">tegen</option>
        	</select><br>
        <?php } ?>
        	<input type="hidden" name="id" value="<?=$this->party->id?>">
        	<input type="hidden" name="name" value="<?=$this->party->name?>">
        	<input type="hidden" name="csrf_token" value="<?= Csrf::makeToken(); ?>">
        	<button class="block" type="submit">Opslaan</button>
        </form>
    </div>
</div>
<script src="<?=Config::get('URL'); ?>js/confirm.js" type="text/javascript"></script>