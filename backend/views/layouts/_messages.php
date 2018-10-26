<?php
/**
 * Created by PhpStorm.
 * User: mariusngaboyamahina
 * Date: 10/26/18
 * Time: 5:53 PM
 */

?>


<?php if (Yii::$app->session->getFlash("warning")): Yii::warning(Yii::$app->session->getFlash("warning")); ?>
    <div class="alert alert-warning">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>Warning!</strong>
        <?php echo Yii::$app->session->getFlash("warning"); ?>
    </div>
<?php endif; ?>