<h2>読書ログ一覧</h2>
<a href="new.php" class="btn btn-primary mb-4">読書ログを登録</a>
<main>
    <div>
        <?php if (count($reviews)) : ?>
            <?php foreach ($reviews as $review) : ?>
                <div class="card mb-4">
                    <div class="card-body">
                        <h4>書籍名：<?php echo (escape($review['title'])); ?></h4>
                        <div class="mb-2">
                            <span><?php echo (escape($review['author'])) ?> / </span>
                            <span><?php echo (escape($review['status'])) ?> / </span>
                            <span><?php echo (escape($review['evaluation'])) ?> / </span>
                        </div>
                        <div><?php echo nl2br((escape($review['summary']))) ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p>まだ、読書ログが登録されていません</p>
        <?php endif; ?>
    </div>
</main>
