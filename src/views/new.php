<h3>読書ログの登録</h3>

<form action="create.php" method="POST">
    <?php if (count($errors)) : ?>
        <ul class="text-danger">
            <?php foreach ($errors as $error) : ?>
                <li>
                    <?php echo ($error); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <div class="form-group">
        <label for="title">書籍名</label>
        <input type="text" class="form-control" id="title" name="title" value="<?php echo ($review['title']); ?>">
    </div>
    <div class="form-group">
        <label for="author">著書名</label>
        <input type="text" class="form-control" id="author" name="author" value="<?php echo ($review['author']); ?>">
    </div>
    <div class="form-group">
        <label>読書状況</label>
        <div class="form-inline">
            <div class="form-group mr-2">
                <label for="status1">未読</label>
                <input type="radio" name="status" id="status1" value="未読" <?php echo ($review['status'] === '未読') ? 'checked' : '' ?>>
            </div>
            <div class="form-group m-2">
                <label for="status2">読んでいる</label>
                <input type="radio" name="status" id="status2" value="読んでいる" <?php echo ($review['status'] === '読んでいる') ? 'checked' : '' ?>>
            </div>
            <div class="form-group m-2">
                <label for="status3">読了</label>
                <input class="form-check-input" type="radio" name="status" id="status3" value="読了" <?php echo ($review['status'] === '読了') ? 'checked' : '' ?>>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="evaluation">評価(5点満点の整数)</label>
        <input type="number" class="form-control" id="evaluation" name="evaluation" min="1" max="5" value="<?php echo ($review['evaluation']) ?>">
    </div>
    <div class="form-group">
        <label for="summary">感想</label>
        <textarea type="text" class="form-control" name="summary" id="summary" rows="10"><?php echo ($review['summary']); ?></textarea>
    </div>
    <button type="submit" class="btn btn-primary">登録する</button>
</form>
