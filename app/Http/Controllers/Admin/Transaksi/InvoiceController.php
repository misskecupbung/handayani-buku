<?php

namespace App\Http\Controllers\Admin\Transaksi;

use App\Invoice;
use DateTime;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InvoiceController extends Controller
{
    public function save_invoice($id_pesanan, $id_pengguna)
    {
        if (session()->has('email_admin')) {

            $data = Invoice::insert([
                'id_invoice'    => $this->store_id(),
                'id_pesanan'    => $id_pesanan,
                'id_pengguna'   => $id_pengguna
            ]);

        } else {

            return redirect()->route('login_admin')->with('fail', 'Harap Login Terlebih Dahulu');

        }
    }

    public function delete_invoice($id_invoice)
    {
        if (session()->has('email_admin')) {

            $data = Invoice::where([
                'id_invoice'    => $id_invoice,
            ])->delete();

        } else {

            return redirect()->route('login_admin')->with('fail', 'Harap Login Terlebih Dahulu');

        }
    }

    protected function store_id() {

        $data = Invoice::max('id_invoice');

        if(!empty($data)) {

            $no_urut = substr($data, 3, 3);
            $no_urut++;

            return 'INV'.sprintf("%03s", $no_urut);
        } else {
            return 'INV'.'001';
        }
    }
}
