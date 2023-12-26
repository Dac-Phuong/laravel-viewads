<?php

namespace App\Livewire\Viewer;

use App\Models\Viewers;
use Livewire\Component;
use Livewire\WithPagination;
class ListViewer extends Component
{
    use WithPagination;
    public $list_viewers;
    public $search = '';
    public $perpage = 3;
    protected $listeners = [
        'success' => 'updateViewer',
        'delete_viewer' => 'delete'
    ];

    public function render()
    {
        return view('livewire.viewer.list-viewer', [
            'viewers' => Viewers::search($this->search)->paginate($this->perpage)
        ]);
    }
    public function updateViewer()
    {
        $this->list_viewers = Viewers::all();
    }
    public function delete($id)
    {
        $viewer = Viewers::find($id);
        if (!is_null($viewer)) {
            $viewer->delete();
        }
        $this->dispatch('success', 'Xóa người xem thành công');
    }
}
