<?php
function getRandomLetter() {
	$abc = "abcdefghijklmnopqrstuvwxyz";
	$n = $abc[rand(0,25)];
	if ($n == 'q') {
		$n = 'qu';
	}
	return $n;
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Boggle Solver</title>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta name="author" content="">
  <meta name="description" content="">
  <meta name="keywords" content="">

  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css">
  <style type="text/css">
    .container {
      width: 320px;
      padding: 0;

    }
    .btn {
      margin-right: 10px;
    }
    .grid {
      display: table;
      margin: 10px auto;
    }
    .entry {
      width: 75px;
      display: none;
    }
    #output {
      font-family: monospace;
      margin-left: 20px;
    }
  </style>

  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
    <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7/html5shiv.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.js"></script>
  <![endif]-->
</head>
<body>
<div class="container">

  <div class="grid">
<?php for ($row = 1; $row <= 4; $row++): ?>
  <?php for ($col = 1; $col <= 4; $col++): ?>
    <?php $cube[$row][$col] = getRandomLetter(); ?>
    <select id="select_<?=$row?><?=$col?>" class="entry">
      <option value="a"<?=($cube[$row][$col] == 'a'?' selected':'')?>>A</option>
      <option value="b"<?=($cube[$row][$col] == 'b'?' selected':'')?>>B</option>
      <option value="c"<?=($cube[$row][$col] == 'c'?' selected':'')?>>C</option>
      <option value="d"<?=($cube[$row][$col] == 'd'?' selected':'')?>>D</option>
      <option value="e"<?=($cube[$row][$col] == 'e'?' selected':'')?>>E</option>
      <option value="f"<?=($cube[$row][$col] == 'f'?' selected':'')?>>F</option>
      <option value="g"<?=($cube[$row][$col] == 'g'?' selected':'')?>>G</option>
      <option value="h"<?=($cube[$row][$col] == 'h'?' selected':'')?>>H</option>
      <option value="i"<?=($cube[$row][$col] == 'i'?' selected':'')?>>I</option>
      <option value="j"<?=($cube[$row][$col] == 'j'?' selected':'')?>>J</option>
      <option value="k"<?=($cube[$row][$col] == 'k'?' selected':'')?>>K</option>
      <option value="l"<?=($cube[$row][$col] == 'l'?' selected':'')?>>L</option>
      <option value="m"<?=($cube[$row][$col] == 'm'?' selected':'')?>>M</option>
      <option value="n"<?=($cube[$row][$col] == 'n'?' selected':'')?>>N</option>
      <option value="o"<?=($cube[$row][$col] == 'o'?' selected':'')?>>O</option>
      <option value="p"<?=($cube[$row][$col] == 'p'?' selected':'')?>>P</option>
      <option value="qu"<?=($cube[$row][$col] == 'qu'?' selected':'')?>>Qu</option>
      <option value="r"<?=($cube[$row][$col] == 'r'?' selected':'')?>>R</option>
      <option value="s"<?=($cube[$row][$col] == 's'?' selected':'')?>>S</option>
      <option value="t"<?=($cube[$row][$col] == 't'?' selected':'')?>>T</option>
      <option value="u"<?=($cube[$row][$col] == 'u'?' selected':'')?>>U</option>
      <option value="v"<?=($cube[$row][$col] == 'v'?' selected':'')?>>V</option>
      <option value="w"<?=($cube[$row][$col] == 'w'?' selected':'')?>>W</option>
      <option value="x"<?=($cube[$row][$col] == 'x'?' selected':'')?>>X</option>
      <option value="y"<?=($cube[$row][$col] == 'y'?' selected':'')?>>Y</option>
      <option value="z"<?=($cube[$row][$col] == 'z'?' selected':'')?>>Z</option>
    </select>
    <img id="cube_<?=$row?><?=$col?>" src="cubes/<?=$cube[$row][$col]?>.jpg">
  <?php endfor; ?>
    <br>
<?php endfor; ?>
  </div>

  <div class="grid">
    <button type="button" class="btn btn-sm btn-warning" id="reset">Reset</button>
    <button type="button" class="btn btn-sm btn-success" id="solve">Solve</button>
  </div>

  <div><hr></div>

  <div><em>Currently configured to find word combinations up to 6 cubes. Some browsers are crashing at higher settings.</em></div>

  <div><hr></div>

  <div id="output"></div>

</div>

<script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script type="text/javascript">

  var wordlist = [];
  var cubes = [];

  $('#reset').click(resetOutput);

  $('#solve').click(solveGrid);

  $('img').click(function() {
    var id_name = $(this).attr('id');
    var id_number = id_name.substring(id_name.length - 2);
    var cube = '#cube_' + id_number;
    var select = '#select_' + id_number;
    $(cube).css({'display':'none'});
    $(select).css({'display':'inline-block'});
  });

  $('select').click(function() {
    var id_name = $(this).attr('id');
    var id_number = id_name.substring(id_name.length - 2);
    var cube = '#cube_' + id_number;
    var select = '#select_' + id_number;
    $(cube).attr('src', 'cubes/' + $(this).val() + '.jpg');
    $(cube).css({'display':'inline'});
    $(select).css({'display':'none'});
  });

  $('select').change(function() {
    var id_name = $(this).attr('id');
    var id_number = id_name.substring(id_name.length - 2);
    var cube = '#cube_' + id_number;
    var select = '#select_' + id_number;
    $(cube).attr('src', 'cubes/' + $(this).val() + '.jpg');
    $(cube).css({'display':'inline'});
    $(select).css({'display':'none'});
    resetOutput();
  });

  function resetOutput() {
    $('#output').text('');
  }

  function solveGrid()
  {
    // assign DOM values to array
    cubes[11] = $('#select_11').val();
    cubes[12] = $('#select_12').val();
    cubes[13] = $('#select_13').val();
    cubes[14] = $('#select_14').val();
    cubes[21] = $('#select_21').val();
    cubes[22] = $('#select_22').val();
    cubes[23] = $('#select_23').val();
    cubes[24] = $('#select_24').val();
    cubes[31] = $('#select_31').val();
    cubes[32] = $('#select_32').val();
    cubes[33] = $('#select_33').val();
    cubes[34] = $('#select_34').val();
    cubes[41] = $('#select_41').val();
    cubes[42] = $('#select_42').val();
    cubes[43] = $('#select_43').val();
    cubes[44] = $('#select_44').val();

    // start output
    $('#output').append('[' + cubes[11] + '][' + cubes[12] + '][' + cubes[13] + '][' + cubes[14] + ']<br>');
    $('#output').append('[' + cubes[21] + '][' + cubes[22] + '][' + cubes[23] + '][' + cubes[24] + ']<br>');
    $('#output').append('[' + cubes[31] + '][' + cubes[32] + '][' + cubes[33] + '][' + cubes[34] + ']<br>');
    $('#output').append('[' + cubes[41] + '][' + cubes[42] + '][' + cubes[43] + '][' + cubes[44] + ']<br>');
    $('#output').append('-=-=-=-=-=-=-=-=-=-=-=-<br>');

    // loop thru each beginning cube
    for (var row = 1; row <= 4; row++) {
      for (var col = 1; col <= 4; col++) {
        var id = (row * 10 + col).toString();
        var letter = $('#select_' + id).val();
        addCube(id);
      }
    }

    // final output
    $('#output').append(wordlist.length.toString() + '<br>');
    for (var x in wordlist) {
      $('#output').append((parseInt(x) + 1).toString() + ') ' + wordlist[x] + '<br>');
    }

  }

  function addWord(newCubeList)
  {
    var thisWord = '';
    var thisCube = newCubeList.split(',');
    for (var x in thisCube) {
      thisWord = thisWord + cubes[thisCube[x]];
    }
    wordlist.push(thisWord);
  }

  function addCube(cubeList)
  {
    //  2 letters, cubeList.length =  5, words     84
    //  3 letters, cubeList.length =  8, words    492
    //  4 letters, cubeList.length = 11, words   2256
    //  5 letters, cubeList.length = 14, words   8968
    //  6 letters, cubeList.length = 17, words  31640
    //  7 letters, cubeList.length = 20, words  99912    ->  safari spins a beach ball for 5 minutes before completing, both firefox and chrome complete
    //  8 letters, cubeList.length = 23, words 283384    ->  safari spins and spins, firefox reports script as unresponsive but completes, no error with chrome
    //  9 letters, cubeList.length = 26, words 720368    ->  firefox & chrome reports script as unresponsive but both complete
    // 10 letters, cubeList.length = 29, words 1626144   ->  chrome dies after reporting unresponsive script several times
    //                                                       firefox reports unresponsive script, only shows the list to 894759 words

    // TODO: remove all duplicate words
    //       remove all invalid words
    //       optimize by having the script quit exploring a branch where no words start with that sequence of letters



    // return up to 6 letter words
    if (cubeList.length >= 17) {
      return;
    }

    var lastCube = parseInt(cubeList.substring(cubeList.length - 2));

    // check NW
    var northwest = lastCube - 11;
    if (northwest > 10 && (northwest % 10) > 0) {
      if (cubeList.search(northwest.toString()) === -1) {
        addWord(cubeList + ',' + northwest.toString());
        addCube(cubeList + ',' + northwest.toString());
      }
    }

    // check N
    var north = lastCube - 10;
    if (north > 10) {
      if (cubeList.search(north.toString()) === -1) {
        addWord(cubeList + ',' + north.toString());
        addCube(cubeList + ',' + north.toString());
      }
    }

    // check NE
    var northeast = lastCube - 9;
    if (northeast > 10 && (northeast % 10) < 5) {
      if (cubeList.search(northeast.toString()) === -1) {
        addWord(cubeList + ',' + northeast.toString());
        addCube(cubeList + ',' + northeast.toString());
      }
    }

    // check E
    var east = lastCube + 1;
    if ((east % 10) < 5) {
      if (cubeList.search(east.toString()) === -1) {
        addWord(cubeList + ',' + east.toString());
        addCube(cubeList + ',' + east.toString());
      }
    }

    // check SE
    var southeast = lastCube + 11;
    if (southeast < 45 && (southeast % 10) < 5) {
      if (cubeList.search(southeast.toString()) === -1) {
        addWord(cubeList + ',' + southeast.toString());
        addCube(cubeList + ',' + southeast.toString());
      }
    }

    // check S
    var south = lastCube + 10;
    if (south < 45) {
      if (cubeList.search(south.toString()) === -1) {
        addWord(cubeList + ',' + south.toString());
        addCube(cubeList + ',' + south.toString());
      }
    }

    // check SW
    var southwest = lastCube + 9;
    if (southwest < 45 && (southwest % 10) > 0) {
      if (cubeList.search(southwest.toString()) === -1) {
        addWord(cubeList + ',' + southwest.toString());
        addCube(cubeList + ',' + southwest.toString());
      }
    }

    // check W
    var west = lastCube - 1;
    if ((west % 10) > 0) {
      if (cubeList.search(west.toString()) === -1) {
        addWord(cubeList + ',' + west.toString());
        addCube(cubeList + ',' + west.toString());
      }
    }
  }

</script>

</body>
</html>
