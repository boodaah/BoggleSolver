<?php
if ($_POST) {
  $filecontents = file_get_contents('wordlist.txt');
  $wordlist = [];
  $letters[11] = $_POST['cube_11'];
  $letters[12] = $_POST['cube_12'];
  $letters[13] = $_POST['cube_13'];
  $letters[14] = $_POST['cube_14'];
  $letters[21] = $_POST['cube_21'];
  $letters[22] = $_POST['cube_22'];
  $letters[23] = $_POST['cube_23'];
  $letters[24] = $_POST['cube_24'];
  $letters[31] = $_POST['cube_31'];
  $letters[32] = $_POST['cube_32'];
  $letters[33] = $_POST['cube_33'];
  $letters[34] = $_POST['cube_34'];
  $letters[41] = $_POST['cube_41'];
  $letters[42] = $_POST['cube_42'];
  $letters[43] = $_POST['cube_43'];
  $letters[44] = $_POST['cube_44'];
}
function getRandomLetter() {
	$abc = "abcdefghijklmnopqrstuvwxyz";
	$n = $abc[rand(0,25)];
	if ($n == 'q') {
		$n = 'qu';
	}
	return $n;
}
function solveBoard() {
  global $wordlist;
  for ($row = 1; $row <= 4; $row++) {
    for ($col = 1; $col <= 4; $col++) {
      addCube($row*10+$col);
    }
  }
  echo 'Count: ' . count($wordlist) . '<br>';
  sort($wordlist);
  echo '<pre>' . print_r($wordlist, true) . '</pre>';
}
function addWord($cubeSequence) {
  global $filecontents;
  global $wordlist;
  global $letters;
  $word = '';
  $cubes = explode(',', $cubeSequence);
  foreach ($cubes as $cube) {
    $word = $word . $letters[$cube];
  }
  // words have to be 3+ letters
  if (strlen($word) < 3) return true;
  // if partial word doesn't exist, quit checking that branch
  $searchpartial = '{' . $word;
  if (strpos($filecontents, $searchpartial) === false) {
    return false;
  }
  // search for word in wordlist
  $searchfor = '{' . $word . '}';
  if (strpos($filecontents, $searchfor) === false) {
    return true;
  }
  // check for duplicates
  if (in_array($word, $wordlist)) return true;
  $wordlist[] = $word;
  return true;
}
function addCube($cubeSequence) {
  //  smallest number of cubes that can create a valid word is 2 cubes, [qu]+[a]
  //  2 cubes, strlen =  5, up to 84 words
  //  3 cubes, strlen =  8, up to 492 words
  //  4 cubes, strlen = 11, up to 2256 words
  //  5 cubes, strlen = 14, up to 8968 words
  //  6 cubes, strlen = 17, up to 31640 words
  //  7 cubes, strlen = 20, up to 99912 words
  //  8 cubes, strlen = 23, up to 283384 words
  //  9 cubes, strlen = 26, up to 720368 words
  // 10 cubes, strlen = 29, up to 1626144 words
  // 11 cubes, strlen = 32, up to 3220792 words
  // 12 cubes, strlen = 35, up to 5531056 words
  // 13 cubes, strlen = 38, up to 8175576 words
  // 14 cubes, strlen = 41, up to 10425768 words
  // 15 cubes, strlen = 44, up to 11686440 words
  // 16 cubes, strlen = 47, up to 12029624 words

  // TODO: remove all duplicate words
  //       remove all invalid words
  //       optimize by having the script quit exploring a branch where no words start with that sequence of letters

  // limit number of cubes
/*
  if ( strlen($cubeSequence) >= 29 ) {
    return;
  }
*/

  $lastCube = intval(substr($cubeSequence, -2));

  // check NW
  $northwest = $lastCube - 11;
  if ($northwest > 10 && ($northwest % 10) > 0) {
    if (strpos($cubeSequence, strval($northwest)) === false) {
      $newSequence = $cubeSequence . ',' . strval($northwest);
      if (addWord($newSequence)) {
        addCube($newSequence);
      }
    }
  }

  // check N
  $north = $lastCube - 10;
  if ($north > 10) {
    if (strpos($cubeSequence, strval($north)) === false) {
      $newSequence = $cubeSequence . ',' . strval($north);
      if (addWord($newSequence)) {
        addCube($newSequence);
      }
    }
  }

  // check NE
  $northeast = $lastCube - 9;
  if ($northeast > 10 && ($northeast % 10) < 5) {
    if (strpos($cubeSequence, strval($northeast)) === false) {
      $newSequence = $cubeSequence . ',' . strval($northeast);
      if (addWord($newSequence)) {
        addCube($newSequence);
      }
    }
  }

  // check E
  $east = $lastCube + 1;
  if (($east % 10) < 5) {
    if (strpos($cubeSequence, strval($east)) === false) {
      $newSequence = $cubeSequence . ',' . strval($east);
      if (addWord($newSequence)) {
        addCube($newSequence);
      }
    }
  }

  // check SE
  $southeast = $lastCube + 11;
  if ($southeast < 45 && ($southeast % 10) < 5) {
    if (strpos($cubeSequence, strval($southeast)) === false) {
      $newSequence = $cubeSequence . ',' . strval($southeast);
      if (addWord($newSequence)) {
        addCube($newSequence);
      }
    }
  }

  // check S
  $south = $lastCube + 10;
  if ($south < 45) {
    if (strpos($cubeSequence, strval($south)) === false) {
      $newSequence = $cubeSequence . ',' . strval($south);
      if (addWord($newSequence)) {
        addCube($newSequence);
      }
    }
  }

  // check SW
  $southwest = $lastCube + 9;
  if ($southwest < 45 && ($southwest % 10) > 0) {
    if (strpos($cubeSequence, strval($southwest)) === false) {
      $newSequence = $cubeSequence . ',' . strval($southwest);
      if (addWord($newSequence)) {
        addCube($newSequence);
      }
    }
  }

  // check W
  $west = $lastCube - 1;
  if (($west % 10) > 0) {
    if (strpos($cubeSequence, strval($west)) === false) {
      $newSequence = $cubeSequence . ',' . strval($west);
      if (addWord($newSequence)) {
        addCube($newSequence);
      }
    }
  }
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

  <form method="post">

  <div class="grid">
<?php for ($row = 1; $row <= 4; $row++): ?>
<?php for ($col = 1; $col <= 4; $col++): ?>
<?php if ($_POST): ?>
<?php $cube[$row][$col] = $_POST['cube_' . $row . $col]; ?>
<?php else: ?>
<?php $cube[$row][$col] = getRandomLetter(); ?>
    <select id="select_<?=$row?><?=$col?>" class="entry" name="cube_<?=$row?><?=$col?>">
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
<?php endif; ?>
    <img id="cube_<?=$row?><?=$col?>" src="cubes/<?=$cube[$row][$col]?>.jpg">
<?php endfor; ?>
<?php if ($row <> 4): ?>
    <br>
<?php endif; ?>
<?php endfor; ?>
  </div>

<?php if (! $_POST): ?>
  <div class="grid">
    <button type="submit" class="btn btn-lg btn-success" id="solve">Solve</button>
  </div>
<?php else: ?>
  <div class="grid">
    <a href="/boggle"><button type="button" class="btn btn-lg btn-warning" id="reset">Reset</button></a>
  </div>
<?php endif; ?>

  </form>

  <div><hr></div>

  <div id="output">
<?php
if ($_POST):
  solveBoard();
endif;
?>
  </div>

</div>

<script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<?php if (!$_POST): ?>
<script type="text/javascript">
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
</script>
<?php endif; ?>

</body>
</html>
