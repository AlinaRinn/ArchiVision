<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/layouts/header.php');
?>
    <h1>Archi Vision - сайт, который поможет вам определить стиль архитектурного сооружения по фото!</h1>
    <form action="/post.php" method="post">
        <label>Введите URL Изображения: <input type="text" name="URL" value=""/></label>
        <button type="submit" name="send">Сканировать</button>
    </form>
<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/layouts/footer.php');