<?php

namespace console\controllers;

use yii\console\Controller;
use \backend\models\AauthPerm;
use \backend\models\User;

class SeedController extends Controller {

    /**
     * Create temporary records
     */
    public function actionSeeder() {
        // /var/www/html/schoolingly/yii seed/seeder
        $time_start = microtime(true);
        echo User::seeder();
        $time_end = microtime(true);
        echo 'Processing for ' . ($time_end - $time_start) . ' seconds ';
    }

    /**
     * Seed permissions
     */
    public function actionPermissionSeeder() {
        // /var/www/html/esapp/yii seed/permission-seeder
        $time_start = microtime(true);
        echo AauthPerm::seedPermissions();
        $time_end = microtime(true);
        echo 'Processing for ' . ($time_end - $time_start) . ' seconds ';
    }

}
