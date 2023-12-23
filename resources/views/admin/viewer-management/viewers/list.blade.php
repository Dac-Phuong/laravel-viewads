@extends('components.layouts.app')
@section('main')
    <div>
        {{-- list viewer --}}
        <livewire:viewer.list-viewer></livewire:viewer.list-viewer>
        {{-- model add viewer --}}
        <livewire:viewer.add-viewer></livewire:viewer.add-viewer>
        {{-- model update viewer --}}
        <livewire:viewer.update-viewer></livewire:viewer.update-viewer>
    </div>
@endsection

