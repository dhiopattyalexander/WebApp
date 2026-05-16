<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ar_staff = Staff::orderBy('id', 'desc')->get();

        return view('staff.index', compact('ar_staff'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ar_gender = ['L', 'P'];

        return view('staff.form', compact('ar_gender'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|unique:staff|max:3',
            'nama' => 'required|max:50',
            'gender' => 'required',
            'alamat' => 'required',
            'email' => 'required|unique:staff|max:50',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:9000',
        ]);

        // default foto
        $foto = 'profile.jpg';

        // upload foto jika ada
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('staff', 'public');
        }

        Staff::create([
            'nip' => $request->nip,
            'nama' => $request->nama,
            'gender' => $request->gender,
            'alamat' => $request->alamat,
            'email' => $request->email,
            'foto' => $foto,
        ]);

        return redirect()->route('staff.index')
            ->with('success', 'Staff created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $row = Staff::find($id);

        return view('staff.show', compact('row'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $ar_gender = ['L', 'P'];

        $row = Staff::find($id);

        return view('staff.form_edit', compact('row', 'ar_gender'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Staff $staff)
    {
        $request->validate([
            'nip' => 'required|max:3|unique:staff,nip,' . $staff->id,
            'nama' => 'required|max:50',
            'gender' => 'required',
            'alamat' => 'required',
            'email' => 'required|max:50|unique:staff,email,' . $staff->id,
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:9000',
        ]);

        $foto = $staff->foto;

        // upload foto baru
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('staff', 'public');
        }

        $staff->update([
            'nip' => $request->nip,
            'nama' => $request->nama,
            'gender' => $request->gender,
            'alamat' => $request->alamat,
            'email' => $request->email,
            'foto' => $foto,
        ]);

        return redirect()->route('staff.index')
            ->with('success', 'Staff updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Staff $staff)
    {
        $staff->delete();

        return redirect()->route('staff.index')
            ->with('success', 'Staff deleted successfully.');
    }
}