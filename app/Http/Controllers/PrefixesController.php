<?php

namespace App\Http\Controllers;

use App\Models\Prefixes;
use Illuminate\Http\Request;
use App\Http\Requests\PrefixRequest;



class PrefixesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q = (string) $request->get('q', '');
        $prefixes = Prefixes::query()
            ->when($q, fn($qr) => $qr->where('name','like',"%{$q}%"))
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('prefixes.index', compact('prefixes','q'));
    }

    public function create()
    {
        return view('prefixes.create');
    }

    public function store(PrefixRequest $request)
    {
        Prefixes::create($request->validated());
        return redirect()->route('prefixes.index')->with('success','บันทึกคำนำหน้าสำเร็จ');
    }

    public function show(Prefixes $prefix)
    {
        return view('prefixes.show', compact('prefix'));
    }

    public function edit(Prefixes $prefix)
    {
        return view('prefixes.edit', compact('prefix'));
    }

    public function update(PrefixRequest $request, Prefixes $prefix)
    {
        $prefix->update($request->validated());
        return redirect()->route('prefixes.index')->with('success','อัปเดตคำนำหน้าสำเร็จ');
    }

    public function destroy(Prefixes $prefix)
    {
        $prefix->delete();
        return redirect()->route('prefixes.index')->with('success','ลบคำนำหน้าสำเร็จ');
    }
}
