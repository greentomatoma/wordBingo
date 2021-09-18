<?php

  // ビンゴのマス目のサイズ
  $S = (int)fgets(STDIN);

  // ビンゴカードに入力されている文字を取得
  $cardWords = [];
  for($i = 0; $i < $S; $i++) {
    $cardWords[$i] = explode(" ", trim(fgets(STDIN)));
  }

  // 入力される単語の個数を取得
  $N = (int)fgets(STDIN);

  // 入力される単語を取得
  $inputWords = [];
  for($i = 0; $i < $S; $i++) {
    $inputWords[] = explode(" ", trim(fgets(STDIN)));
  }


  // 入力された単語がカードにあるか判定
  foreach($inputWords as $word) {
    for($i = 0; $i < $S; $i++) {
      for($j = 0; $j < $S; $j++) {
        if($word === $cardWords[$i][$j]) {
          //　あればhitに置き換え
          $cardWords[$i][$j] = "hit";
        }
      }
    }
  }

  // カードにhitがあるかどうかカウント
  $countHit = [];
  for($i = 0; $i < $S; $i++) {
    if(in_array("hit", $cardWords[$i])) {
        array_push($countHit, "yes");
    }
  }


  if(empty($countHit)) {
     
    // カードにhitが1つもなければ終了
    echo "no";
  
  } else {
    // hitが1つでもあればそれぞれのパターンで調べる
  $output = [];

  // ビンゴの判定 横
  for($i = 0; $i < $S; $i++) {
    $wordCount[] = array_count_values($cardWords[$i]);
    if($wordCount[$i]["hit"] === $S) {
        array_push($output, "yes");
    }
  }
  unset($wordCount);

  
  // ビンゴの判定 縦
  $column = [];
  for($i = 0; $i < $S; $i++) {
    foreach ($cardWords as $word) {
        // 配列の行と列を入れ替える
        $column[$i][] = $word[$i];
    }
    $wordCount[] = array_count_values($column[$i]);
  };
  
  foreach($wordCount as $count) {
    // 値が$S個のkeyがあるか
      if(array_keys($count, $S)) {
        array_push($output, "yes");
      }
    
  }
  unset($wordCount);



  // ビンゴの判定 左上斜め
  for($i = 0, $j = 0; $i < $S; $i++, $j++) {
    // 左上から斜めの列を配列に格納
    $aboveLeft[$i] = $cardWords[$i][$j];
  };

  // hitの数をカウント
  $wordCount = array_count_values($aboveLeft);
  if($wordCount["hit"] === $S) {
    array_push($output, "yes");
  }
  unset($wordCount);



  // ビンゴの判定 右上斜め
  $aboveRight = [];
  for($i = 0, $j = $S - 1; $i < $S; $i++, $j--) {
    // 右上から斜めの列を配列に格納
    $aboveRight[$i] = $cardWords[$i][$j];
  };

  // hitの数をカウント
  $wordCount = array_count_values($aboveRight);
  if($wordCount["hit"] === $S) {
    array_push($output, "yes");
  }
  unset($wordCount);


  // $outputに1つでもyesがあればビンゴ
  echo empty($output) ? "no" : "yes";

}

?>