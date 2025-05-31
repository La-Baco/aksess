<?php

namespace App\Http\Controllers\kepsek;

use App\Models\Izin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IzinController extends Controller
{
    public function approve($id)
    {
        $izin = Izin::findOrFail($id);
        $izin->status = 'disetujui';
        $izin->save();

        return redirect()->back()->with('success', 'Izin disetujui.');
    }

    public function reject($id)
    {
        $izin = Izin::findOrFail($id);
        $izin->status = 'ditolak';
        $izin->save();

        return redirect()->back()->with('success', 'Izin ditolak.');
    }
}
