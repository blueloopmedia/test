<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/ui-lightness/jquery-ui.css" type="text/css" media="all" />
<style>

.pane
{
	width: 1000px;
	height: 1000px;
	border: 1px solid black;
	background-color: #CCCCCC;
}
.box 
{
    float:left;
}
.sl
{
    border: 1px solid grey;
    border-radius: 5px;
    font-size:20px;
    width:100%;
}

.c
{
	background-color: rgb(255,255,255);
	width: 719px;
	height: 60px;
	-moz-box-shadow: inset 0px 1px 2px rgba(0,0,0,0.4);
	-webkit-box-shadow: inset 0px 1px 2px rgba(153,102,102,0.4);
	box-shadow: inset 0px 1px 2px rgba(153,102,102,0.4);
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	margin-left: 0px;
	padding-top: 13px;
	padding-right: 34px;
	padding-bottom: 34px;
	padding-left: 34px;
	border-color: #FF0000;
	border-width: thin;
	border-radius: 4px;
}
</style>

</head>

<body>
<form>
<select class="sl">
    <option value="1">All Classes</option>
    <option value="2">Class 2</option>
    <option value="3">Class 3</option>
</select>
<input type="color">
    
<input type="week">

<input type="email">

<input type="submit">
</form>
<select id="combobox">
</select>
<input id="inputbox" type="text">
<div class="pane"></div>

<hr>
<div class="c" style="width:700px; height:300px">
Nam mollis nisl eu augue placerat ut porta neque convallis. Nullam malesuada odio non elit iaculis commodo. Cras adipiscing velit ut sem fermentum nec gravida lorem elementum. Donec sed augue at nunc tristique ultricies. Morbi quam lacus, rutrum non elementum eget, elementum vitae eros. 
</div>



<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script>
function rn () {
    return Math.floor(Math.random()*1000000);
}

for(i = 0; i < 20; i++) {
    var rnn = rn();
   // $('.pane').append('<div id="id' + rnn  +  '" class="box" style="width:20px;height:20px;background-color:#' + rnn + '"></div>');
   // $('#id' + rnn).fadeIn('5000');
    //console.log(rn());
}

</script>
<script>
$.widget("custom.combobox", {
    _create: function() {
        this.wrapper = $("<span>").addClass("custom-combobox").insertAfter(this.element);

        this.element.hide();
        this._createAutocomplete();
        this._createShowAllButton();
    },
    _createShowAllButton: function() {
        
    },
    _createAutocomplete: function() {
        var selected = this.element.children(":selected"),
            value = selected.val() ? selected.text() : "";

        this.input = $("<input>").appendTo(this.wrapper).val(value).attr("title", "Double Click To See All Advisers").addClass("custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left").autocomplete({
                delay: 0,
                minLength: 0,
                //source: $.proxy(this, "_source")
                //source: this.options.source
                source: [ {lable:"hello",value:"2"}, {label:"Yes", value:"3"}]
            }).dblclick(function() {                                    
                 $(this).autocomplete("search", "");
            }).tooltip({gravity: 's'});

        this._on(this.input, {
                autocompleteselect: function(event, ui) {
                    ui.item.option.selected = true;
                    this._trigger("select", event, {
                        item: ui.item.option
                    });
                },

                autocompletechange: "_removeIfInvalid"
            });
    },

    _source: function(request, response) {
        var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
        response(this.element.children("option").map(function() {
            var text = $(this).text();
            if (this.value && (!request.term || matcher.test(text))) return {
                label: text,
                value: text,
                option: this
            };
        }));
    },

    _removeIfInvalid: function(event, ui) {

        // Selected an item, nothing to do
        if (ui.item) {
            return;
        }

        // Search for a match (case-insensitive)
        var value = this.input.val(),
            valueLowerCase = value.toLowerCase(),
            valid = false;
        this.element.children("option").each(function() {
                if ($(this).text().toLowerCase() === valueLowerCase) {
                    this.selected = valid = true;
                    return false;
                }
            });

        // Found a match, nothing to do
        if (valid) {
                return;
            }

        // Remove invalid value
        this.input.val("").attr("title", value + " didn't match any item").tooltip("open");
        this.element.val("");
        this._delay(function() {
                this.input.tooltip("close").attr("title", "");
            }, 2500);
        this.input.data("ui-autocomplete").term = "";
    },

    _destroy: function() {
        this.wrapper.remove();
        this.element.show();
    }
});

$("#inputbox").autocomplete({source:'http://test.local/autocomplete-test.php', minLength: 3});
</script>
</body>
</html>