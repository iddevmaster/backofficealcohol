<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateKioskToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kiosk:token {token_name : Token name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Sanctum token for kiosk device';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tokenName = $this->argument('token_name');

        $user = User::find(1);

        if (!$user) {
            $this->error('User not found.');
            return Command::FAILURE;
        }

        // delete old token with same name
        $user->tokens()
            ->where('name', $tokenName)
            ->delete();

        // generate new token
        $plainTextToken = $user
            ->createToken($tokenName)
            ->plainTextToken;

        // create directory if not exists
        $directory = storage_path('app/tokens');

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        // file path
        $filePath = $directory . '/' . $tokenName . '.txt';

        // save token
        File::put($filePath, $plainTextToken);

        $this->info('Token generated successfully.');
        $this->newLine();

        $this->line('Token Name: ' . $tokenName);
        $this->line('Saved File: ' . $filePath);
        $this->newLine();

        $this->warn('IMPORTANT: Keep this token secure.');
        $this->newLine();

        $this->line($plainTextToken);

        return Command::SUCCESS;
    }
}
