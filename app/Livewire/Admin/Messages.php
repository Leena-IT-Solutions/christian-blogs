<?php

namespace App\Livewire\Admin;

use App\Models\Message;
use Livewire\Component;
use Livewire\WithPagination;

class Messages extends Component
{
    use WithPagination;

    public $activeMessageId = null;

    public function selectMessage($id)
    {
        $this->activeMessageId = $id;
    }

    public function closeMessage()
    {
        $this->activeMessageId = null;
    }

    public function deleteMessage($id)
    {
        Message::findOrFail($id)->delete();
        if ($this->activeMessageId === $id) {
            $this->activeMessageId = null;
        }
        session()->flash('message', 'Message deleted successfully.');
    }

    public function render()
    {
        $messages = Message::orderBy('created_at', 'desc')->paginate(15);
        $activeMessage = $this->activeMessageId ? Message::find($this->activeMessageId) : null;

        return view('livewire.admin.messages', compact('messages', 'activeMessage'))
            ->layout('components.layouts.admin')
            ->title('Messages Inbox - Admin');
    }
}
