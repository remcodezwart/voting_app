<div class="container">
    <div class="box center">
        <h1>Stelling</h1>
        <p id="statement"></p>
        <div id="buttons">
            <button name="1" type="button">voor</button>
            <button name="0" type="button">weet niet</button>
            <button name="-1" type="button">tegen</button>
        </div>
        <p id="result">

        </p>
    </div>
    <div class="box">
    <!-- graph here -->
    </div>
</div>
<script type="text/javascript">
    var statements = [<?php foreach ($this->statements as $statement) { ?>"<?=$statement->description ?>", <?php } ?> undefined];
    var partys = [{party: 'sp', statements: [1, 1, 1], score:0}, {party:'d66', statements: [0, 1, 0], score:0}, {party:'vvd', statements:[-1, 0, 0], score:0}, {party: 'cda', statements:[1, 1, 1], score:0 }];
</script>
<script src="<?=Config::get('URL'); ?>js/voting.js" type="text/javascript"></script>