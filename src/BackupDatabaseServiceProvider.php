<?php
/**
 * Laravel Database Backup.
 *
 * @author      The Departed / Mr Robot
 * @license     https://opensource.org/licenses/GPL-3.0
 *
 * @link        https://github.com/theDepart3d/laravel-database-backup
 */

namespace thedeparted\LaravelBackupDatabase;

use Illuminate\Support\ServiceProvider;

class BackupDatabaseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Register hard-to-delete artisan command
        // $this->commands([
        //     DatabaseBackup::class,
        // ]);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Publish file
        $backup_file = __DIR__.'/../src/DatabaseBackup.php';
        $publishPath = base_path('app/Console/Commands/DatabaseBackup.php');
        $this->publishes([$backup_file => $publishPath], ['BackupCommand']);
    }
}
