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
    var statements = [];
    var partys = [];

    <?php foreach ($this->statements as $statement) { ?>
        statements.push("<?=$statement->description ?>");
    <?php } ?> 

    <?php foreach ($this->parties as $party) { 
        if (!empty($party->statements)) { ?> 
        partys.push({party: '<?=$party->name ?>', statements: [<?=$party->statements?> -2], score:0}); 
        <?php } 
    } ?>
</script>
<script src="<?=Config::get('URL'); ?>js/voting.js" type="text/javascript"></script>