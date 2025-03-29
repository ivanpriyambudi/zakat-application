<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Models\YearPeriod;
use Illuminate\Http\Request;

class YearPeriodController extends Controller
{
    public function switchYear(Request $request)
    {
        $yearActive = YearPeriod::active()->first();
        $yearToActive = YearPeriod::find($request['yearId']);

        if ($yearActive) {
            $yearActive->update([
                'is_active' => false
            ]);
        }

        if ($yearToActive) {
            $yearToActive->update([
                'is_active' => true
            ]);
        }

        session()->flash('success', 'Berhasil mengubah tahun');

        return redirect()->back();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'year' => 'required|string',
        ]);

        YearPeriod::create($validated);

        session()->flash('success', 'Berhasil menambahkan tahun');

        return redirect()->back();
    }
}
