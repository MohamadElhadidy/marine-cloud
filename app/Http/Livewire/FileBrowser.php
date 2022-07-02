<?php

namespace App\Http\Livewire;

use Livewire\Component;

class FileBrowser extends Component
{
    public $object;
    public $ancestors;
    public $creatingNewFolder = false;
    public $newFolderState = [
        'name' => ''
    ];

    public function createFolder()
    {
        $this->validate([
            'newFolderState.name' => 'required|max:255'
        ]);

        $object = $this->currentTeam->objects()->make([
            'parent_id' => $this->object->id
        ]);

        $folder = $this->currentTeam->folders()->create($this->newFolderState);
        $object->objectable()->associate($folder);
        $object->save();

        $this->reset([
            'creatingNewFolder',
            'newFolderState'
        ]);

        //reload entire component
        $this->object = $this->object->fresh();
    }

    public function getCurrentTeamProperty()
    {
        return auth()->user()->currentTeam;
    }

    public function render()
    {
        return view('livewire.file-browser');
    }
}
