<?php
// 1. POSTデータ取得
//$name = filter_input( INPUT_GET, ","name" ); //こういうのもあるよ
//$email = filter_input( INPUT_POST, "email" ); //こういうのもあるよ
$syoseki = $_POST['syoseki'];
$url = $_POST['url'];
$hyouka = $_POST['hyouka'];
$naiyou = $_POST['naiyou'];

// 2. DB接続します
try {
  //Password:MAMP='root',XAMPP=''
  // host=localhostは実際には切り替える！！契約すると割り当て
  // Tryはエラーをcathcするイメージ
  $pdo = new PDO('mysql:dbname=bookmark_db;charset=utf8;host=localhost','root','root');
} catch (PDOException $e) {
  exit('DBConnectError:'.$e->getMessage());
}


// ３．SQL文を用意(データ登録：INSERT)
$stmt = $pdo->prepare(
  "INSERT INTO gs_bm_table(ユニーク値,書籍名,書籍URL,書籍評価,書籍コメント,登録日時)
  VALUES( NULL, :syoseki, :url, :hyouka, :naiyou, sysdate() )"
);

// 4. バインド変数を用意、これの意味はコロンで一回書き換えて戻す＝セキュリティ対策
$stmt->bindValue(':syoseki', $syoseki, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':url', $url, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':hyouka', $hyouka, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':naiyou', $naiyou, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)

// 5. 実行
$status = $stmt->execute();

// 6．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("ErrorMassage:".$error[2]);
}else{
  //５．index.phpへリダイレクト
  header('Location: bm_index.php');
}
?>
