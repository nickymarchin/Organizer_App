<div class="content">
    <div class="container">
        <h2 class="text-center"><b><?= $title ?></b></h2>

<!--        <div class="row">-->
<!--            <div class="col-md-10 col-md-offset-1">-->

                <?php foreach ($emailsList as $key => $element) : ?>

                    <h3><?php echo $element['subject']; ?></h3>
                    <small class="email_date">Sent on: <?php echo $element['date']; ?> </small>
                    <h4><?php echo $element['content']; ?></h4>
                    <small class="recipient_email">Sent to: <?php echo $element['email']; ?> </small>
                    <hr>
                <?php endforeach; ?>

                <div class="pagination-links">
                    <?php echo $this->pagination->create_links(); ?>
                </div>
<!--            </div>-->
<!--        </div>-->
    </div>
</div>
