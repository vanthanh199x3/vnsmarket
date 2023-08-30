<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bank;

class BankController extends Controller
{
    public function index()
    {
    }

    public function create()
    {
    }
    public function store(Request $request)
    {
    }

    public function show($id)
    {   
    }

    public function edit()
    {
        $bank = Bank::where('user_id', auth()->user()->id)->first();
        return view('backend.bank.edit', compact('bank'));
    }

    public function update(Request $request)
    {
        $this->validate($request,[
            'bank_name' => 'required|max:255',
            'bank_address'=>'required|max:255',
            'account_name'=>'required|max:255',
            'account_number'=>'required|max:255',
            'note' => 'nullable|max:500',
        ]);
        $data = $request->except('_token');
        $data['user_id'] = auth()->user()->id;

        if ($request->id != '') {
            Bank::where(['id' => $request->id, 'user_id' => auth()->user()->id])->update($data);
        } else {
            Bank::create($data);
        }
        
        return redirect()->route('bank.index')->with('success', 'Cập nhật tài khoản ngân hàng thành công!');
    }

    public function destroy($id)
    {
    }
}
