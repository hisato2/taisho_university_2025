session_start(); // セッションを開始

if (isset($_POST['inputText'])) {
    $_SESSION['INPUT_TEXT'] = $_POST['inputText']; // テキストボックスの値をセッションに保存
    echo 'セッションに保存されました: ' . $_SESSION['INPUT_TEXT'];
} else {
    echo 'エラー: テキストが送信されていません。';
}