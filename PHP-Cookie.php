<script>

    const LoginCheck = true;

    // JavaScript から PHP にデータを渡すために、 Cookie に渡したいDataをSetする
    document.cookie = `IsLogin=${LoginCheck}`;
</script>

<h1>JavaScriptからPHPにデータを渡す方法 Ver. Cookie</h1>

<?php
    // PHP で Flagを取得する
    $login_check = $_COOKIE["IsLogin"];

    $is_login = false;
    if ( $login_check == 'true') $is_login = true;
?>


<?php if ($is_login) { 
    echo "<h2>Loin済みUserです</h2>";
 } else { 
    echo "<h2>No-Loin-Userです</h2>";
}
?>
