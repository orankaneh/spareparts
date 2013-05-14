<?php
$urutan = array(
    array('id' => 'satu', 'title' => 'Nilai Pertama', 'selected' => false),
    array('id' => 'dua', 'title' => 'Yang kedua', 'selected' => true),
    array('id' => 'tiga', 'title' => 'Orang ketiga', 'selected' => false),
    array('id' => 'empat', 'title' => 'Empat Sekawan', 'selected' => true),
    array('id' => 'lima', 'title' => 'Lima', 'selected' => false),
);
$lorem = array(
    array('id' => 1, 'title' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'selected' => false),
    array('id' => 2, 'title' => 'Nulla ut est non dui blandit pellentesque eget id felis.', 'selected' => false),
    array('id' => 3, 'title' => 'Aliquam eget magna ut libero luctus fringilla non quis metus.', 'selected' => true),
    array('id' => 4, 'title' => 'In non velit nec nisi pellentesque sagittis.', 'selected' => false),
    array('id' => 5, 'title' => 'Quisque dignissim est eget mauris congue luctus.', 'selected' => true),
    array('id' => 6, 'title' => 'Curabitur sit amet purus tortor, vel ornare lacus.', 'selected' => false),
    array('id' => 7, 'title' => 'Aliquam nec mi porta lorem interdum semper id et sapien.', 'selected' => false),
);

function multiselect_filterflat(array $ids, $data) {
    $result = array();
    foreach ($data as $datum) {
        if (in_array($datum['id'], $ids)) {
            $result[$datum['id']] = $datum['title'];
        }
    }
    return $result;
}

?>
<? if (app_request_get_method() == 'POST'): ?>
    <pre><? print_r($_POST) ?></pre>
    <? if ($_POST['angka']): ?>
        <h3>Urutnya</h3>
        <ul>
            <? foreach (multiselect_filterflat($_POST['angka'], $urutan) as $id => $title): ?>
                <li><strong class="id"><?= $id ?></strong> - <span class="title"><?= $title ?></span></li>
            <? endforeach ?>
        </ul>
    <? endif ?>
    <? if ($_POST['kata']): ?>
        <h3>Lipsum</h3>
        <ul>
            <? foreach (multiselect_filterflat($_POST['kata'], $lorem) as $id => $title): ?>
                <li><strong class="id"><?= $id ?></strong> - <span class="title"><?= $title ?></span></li>
            <? endforeach ?>
        </ul>
    <? endif ?>

    <? return // use "return" to exit script but still decorated by layout ?>

<? endif ?>
<style type="text/css">
.mparts-selector fieldset {
    clear: none;
    border: none;
    float: left;
    padding: 0 .5em;
}
.mparts-selector select {
    clear: none;
    float: left;
}
.mparts-selector input {
    margin: 0;
    padding: 0 .4em;
    display: block;
}

/** parts-selector widget **/
.parts-selector {
    /*clear:both;*/
    float: left;
}
.parts-selector .controls {
    clear: none;
    float: left;
    padding: 0 .5em;
}
.parts-selector select {
    clear: none;
    float: left;
}
.parts-selector input {
    display: block;
    margin: 0;
    padding: 0 .4em;
}
</style>
<form action="<?= app_base_url('/multiselect') ?>" method="post">
    <fieldset>
        <legend>Multi select (parts selector)</legend>
        <label for="multiselect-urutan">Urutnya</label>
        <select id="multiselect-urutan" name="angka[]" multiple="multiple">
            <? foreach ($urutan as $opt): ?>
            <option value="<?= $opt['id'] ?>"<?=($opt['selected'])?' selected="selected"':''?>><?= $opt['title'] ?></option>
            <? endforeach ?>
        </select>
        <label for="multiselect-lipsum">Lipsum</label>
        <select id="multiselect-lipsum" name="kata[]" multiple="multiple">
            <? foreach ($lorem as $opt): ?>
            <option value="<?= $opt['id'] ?>"<?=($opt['selected'])?' selected="selected"':''?>><?= $opt['title'] ?></option>
            <? endforeach ?>
        </select>
        <fieldset id="manual-parts-selector" class="mparts-selector">
            <legend>Manual parts selector</legend>
            <select name="available" class="available-parts" multiple="multiple">
                <? foreach ($lorem as $opt): ?>
                <option value="<?= $opt['id'] ?>"><?= $opt['title'] ?></option>
                <? endforeach ?>
            </select>
            <fieldset>
                <input type="button" class="options-add" value="→" />
                <input type="button" class="options-remove" value="←" />
            </fieldset>
            <select name="selected" class="selected-parts" multiple="multiple" size="<?= count($lorem) ?>"></select>
            <fieldset>
                <input type="button" class="move-up" value="↑" />
                <input type="button" class="move-down" value="↓" />
            </fieldset>
        </fieldset>
        <label for="not-multiple-select">not multiple</label>
        <select id="not-multiple-select" name="not[]">
            <? foreach ($urutan as $opt): ?>
            <option value="<?= $opt['id'] ?>"><?= $opt['title'] ?></option>
            <? endforeach ?>
        </select>
        <fieldset class="input-process">
            <input type="submit" value="Yuk mari..." />
        </fieldset>
    </fieldset>
</form>
<script type="text/javascript">

jQuery(function(){

    $('#multiselect-urutan').partsSelector({
        addLabel:'>',
        removeLabel:'<',
        upLabel:'Up',
        downLabel:'Down'
    });
    $('#multiselect-lipsum, #not-multiple-select').partsSelector();

////////////////////////////////////////////////////////////////////////////////
    (function(){
        var container = $('#manual-parts-selector'),
            availableBox = container.find('.available-parts'),
            selectedBox = container.find('.selected-parts'),
            addButton = container.find('.options-add'),
            removeButton = container.find('.options-remove'),
            upButton = container.find('.move-up'),
            downButton = container.find('.move-down');

        addButton.click(function(){
            availableBox.find('option:selected').detach().appendTo(selectedBox).attr('selected', false);
        });
        removeButton.click(function(){
            selectedBox.find('option:selected').detach().appendTo(availableBox).attr('selected', false);
        });
        upButton.click(function(){
            var parts = selectedBox.find('option:selected');
            var target = parts.first().prev();
            parts.detach().insertBefore(target);
        });
        downButton.click(function(){
            var parts = selectedBox.find('option:selected');
            var target = parts.last().next();
            parts.detach().insertAfter(target);
        });
    })();
});
</script>