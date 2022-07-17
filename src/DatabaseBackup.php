<?php
/**
 * Laravel Database Backup.
 *
 * @author      The Departed / Mr Robot
 * @license     https://opensource.org/licenses/GPL-3.0
 *
 * @link        https://github.com/theDepart3d/laravel-database-backup
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use File;
use App\Models\User;

class DatabaseBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a backup copy of your existing mysql database.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if (env('DB_CONNECTION') == 'mysql') {
            $this->withProgressBar(User::all(), function () {
                $filename = "backup-mysql-" . Carbon::now()->format('Y-m-d') . ".sql.gz";
                // Create backup folder and set permission if not exist.
                $storageAt = storage_path() . "/app/backup/sql/";
                if(!File::exists($storageAt)) {
                    File::makeDirectory($storageAt, 0755, true, true);
                }
                $command = "mysqldump --user=" . env('DB_USERNAME') ." --password='" . env('DB_PASSWORD') . "' --host=" . env('DB_HOST') . " " . env('DB_DATABASE') . "  | gzip > " . $storageAt . $filename;
                $returnVar = NULL;
                $output = NULL;
                sleep(2);
                if (exec($command, $output, $returnVar)) {
                    $this->advance();
                }
            });
        } elseif (env('DB_CONNECTION') == 'sqlite') {
            $this->withProgressBar(User::all(), function () {
                $filename = "backup-sqlite-" . Carbon::now()->format('Y-m-d') . ".sql.gz";
                // Create backup folder and set permission if not exist.
                $storageAt = storage_path() . "/app/backup/sql/";
                if(!File::exists($storageAt)) {
                    File::makeDirectory($storageAt, 0755, true, true);
                }
                $command = "sqlite3 " . env('DB_DATABASE') . " .dump | gzip > " . $storageAt . $filename;
                $returnVar = NULL;
                $output = NULL;
                sleep(2);
                if (exec($command, $output, $returnVar)) {
                    $this->advance();
                }
            });
        }
        print "\r\n";
    }
}
