<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Message;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Setting;
use Livewire\Component;

class Dashboard extends Component
{
    public $updateOutput = '';
    public $isUpdating = false;
    public $currentCommit = '';

    public function mount()
    {
        $this->loadCurrentCommit();
    }

    public function loadCurrentCommit()
    {
        try {
            $commitHash = shell_exec('git rev-parse --short HEAD');
            $commitMessage = shell_exec('git log -1 --pretty=%B');
            $branch = shell_exec('git rev-parse --abbrev-ref HEAD');
            
            if ($commitHash) {
                $this->currentCommit = trim($branch) . ' @ ' . trim($commitHash) . ' (' . trim(strtok($commitMessage, "\n")) . ')';
            } else {
                $this->currentCommit = 'Unknown (Git not initialized or not accessible)';
            }
        } catch (\Exception $e) {
            $this->currentCommit = 'Error loading commit info: ' . $e->getMessage();
        }
    }

    public function updateSite()
    {
        $this->isUpdating = true;
        $this->updateOutput = "Starting update process...\n\n";

        // Commands to run
        $commands = [
            'git pull 2>&1',
            'php artisan migrate --force 2>&1',
            'php artisan optimize:clear 2>&1',
        ];

        $output = [];
        foreach ($commands as $command) {
            $output[] = "$ " . $command;
            $cmdOutput = [];
            $status = null;
            exec("cd " . base_path() . " && " . $command, $cmdOutput, $status);
            $output[] = implode("\n", $cmdOutput);
            $output[] = "Exit Code: " . $status . "\n";
        }

        $this->updateOutput = implode("\n", $output);
        $this->loadCurrentCommit();
        $this->isUpdating = false;
        
        session()->flash('update_message', 'Update process completed.');
    }

    public function render()
    {
        $stats = [
            'posts_total' => Post::count(),
            'posts_published' => Post::where('status', 'published')->count(),
            'posts_draft' => Post::where('status', 'draft')->count(),
            'categories' => Category::count(),
            'tags' => Tag::count(),
            'comments_pending' => Comment::where('is_approved', false)->count(),
            'messages_unread' => Message::count(), // Message count
        ];

        return view('livewire.admin.dashboard', compact('stats'))
            ->layout('components.layouts.admin')
            ->title('Dashboard - Admin');
    }
}
