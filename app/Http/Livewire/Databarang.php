<?php

namespace App\Http\Livewire;

use App\Models\Barang;
use Livewire\Component;

class Databarang extends Component
{
    public $barangs, $nama_barang, $jumlah, $harga, $barang_id;
    public $isModalOpen = 0;

    public function render()
    {
        $this->barangs = Barang::all();
        return view('livewire.databarang');
    }

    public function create()
    {
        $this->resetCreateForm();
        $this->openModalPopover();
    }

    public function openModalPopover()
    {
        $this->isModalOpen = true;
    }

    public function closeModalPopover()
    {
        $this->isModalOpen = false;
    }

    public function resetCreateForm(){
        $this->nama_barang = '';
        $this->jumlah = '';
        $this->harga = '';
    }
    
    public function store()
    {
        $this->validate([
            'nama_barang' => 'required',
            'jumlah' => 'required',
            'harga' => 'required',
        ]);
    
        Barang::updateOrCreate(['id' => $this->barang_id], [
            'nama_barang' => $this->nama_barang,
            'jumlah' => $this->jumlah,
            'harga' => $this->harga,
        ]);

        session()->flash('message', $this->barang_id ? 'Barang updated.' : 'Barang created.');

        $this->closeModalPopover();
        $this->resetCreateForm();
    }

    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        $this->id = $id;
        $this->nama_barang = $barang->nama_barang;
        $this->jumlah = $barang->jumlah;
        $this->harga = $barang->harga;
    
        $this->openModalPopover();
    }

    public function delete($id)
    {
        Barang::find($id)->delete();
        session()->flash('message', 'Barang deleted.');
    }
}


