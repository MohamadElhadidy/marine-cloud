<?php

namespace App\Http\Livewire;

use App\Models\Obj;
use Livewire\Component;

class FileBrowser extends Component
{
    public $object;
    public $ancestors;

    public $creatingNewFolder = false;
    public $newFolderState = [
        'name' => ''
    ];

    public $renamingObject;
    public $renamingObjectState = [
        'name' => ''
    ];

    public function renameObject()
    {
        $this->validate([
            'renamingObjectState.name' => 'required|max:255'
        ]);

        Obj::forCurrentTeam()->find($this->renamingObject)->objectable->update($this->renamingObjectState);

        $this->object = $this->object->fresh();

        $this->renamingObject = null;
    }

    public function updatingRenamingObject($id)
    {
        if ($id === null) {
            $this->reset($this->renamingObjectState);
        }

        if ($object = Obj::forCurrentTeam()->find($id)) {
            $this->renamingObjectState = [
                'name' => $object->objectable->name
            ];
        }
    }

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
