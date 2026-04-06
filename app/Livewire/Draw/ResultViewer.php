<?php

namespace App\Livewire\Draw;

use Livewire\Component;
use App\Services\DrawService;
use App\Models\Draw;

class ResultViewer extends Component
{
    public $draw;
    public $groups = [];
    public $constraintReport = [];

    public function mount()
    {
        $title = session('draw_title');
        $participants = session('draw_participants', []);
        $mode = session('draw_mode');
        $parameters = session('draw_parameters', []);
        $constraints = session('draw_constraints', []);
        
        if (empty($participants) || empty($mode)) {
            return;
        }
        
        $drawService = app(DrawService::class);
        
        $this->draw = $drawService->executeDraw(
            auth()->id(),
            $title,
            $mode,
            $participants,
            $parameters,
            $constraints
        );
        
        if ($this->draw) {
            $this->loadGroups();
        }
        
        session()->forget(['draw_title', 'draw_participants', 'draw_mode', 'draw_parameters', 'draw_constraints']);
    }

    public function loadGroups()
    {
        if ($this->draw->type === 'A') {
            $this->groups = $this->draw->participants()
                ->orderBy('group_id')
                ->get()
                ->groupBy('group_id');
        } else {
            $this->groups = $this->draw->participants()
                ->orderBy('theme_name')
                ->get()
                ->groupBy('theme_name');
        }
    }

    public function newDraw()
    {
        return redirect()->route('draw.create');
    }

    public function render()
    {
        return view('livewire.draw.result-viewer');
    }
}
