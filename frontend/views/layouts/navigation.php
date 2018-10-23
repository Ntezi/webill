<?php
/**
 * Created by PhpStorm.
 * User: mariusngaboyamahina
 * Date: 2/10/18
 * Time: 6:57 PM
 */

use yii\helpers\Url;
?>

<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?php echo Yii::$app->request->baseUrl; ?>/"><?php echo Yii::$app->name ?></a>
    </div>
    <!-- /.navbar-header -->

    <ul class="nav navbar-top-links navbar-right">
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#"> <?php echo Yii::$app->user->identity->username ?>
                <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="#">
                    <a href="<?php echo Url::to(['user/update', 'id' => Yii::$app->user->identity->id]); ?>">
                        <i class="fa fa-user fa-fw"></i> <?php echo Yii::t('app', 'Profile') ?> </a>
                </li>
                <li class="divider"></li>
                <li><a href="<?php echo Yii::$app->request->baseUrl; ?>/site/logout" data-method="post">
                        <i class="fa fa-sign-out fa-fw"></i> <?php echo Yii::t('app', 'Logout') ?> </a>
                </li>
            </ul>
            <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
    </ul>
    <!-- /.navbar-top-links -->

    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">

                <li class="<?php echo preg_match('/site/', $this->context->route, $matched) ? 'active' : '' ?>">
                    <a href="<?php echo Yii::$app->request->baseUrl; ?>/"><i class="fa fa-dashboard fa-fw"></i>
                        <?php echo Yii::t('app', 'Dashboard') ?></a>
                </li>
            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>
