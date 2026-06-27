<?php

namespace App\Livewire\Admin;

use App\Models\Comment;
use Livewire\Component;
use Livewire\WithPagination;

class Comments extends Component
{
    use WithPagination;

    public function approveComment($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->update(['is_approved' => true]);
        session()->flash('message', 'Comment approved successfully.');
    }

    public function rejectComment($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->update(['is_approved' => false]);
        session()->flash('message', 'Comment rejected/hidden successfully.');
    }

    public function deleteComment($id)
    {
        Comment::findOrFail($id)->delete();
        session()->flash('message', 'Comment deleted successfully.');
    }

    public function render()
    {
        $comments = Comment::with('post')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('livewire.admin.comments', compact('comments'))
            ->layout('components.layouts.admin')
            ->title('Moderate Comments - Kernel Admin');
    }
}
