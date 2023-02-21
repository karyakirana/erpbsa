<?php namespace App\ERP\Keuangan;

use App\Models\Keuangan\NeracaSaldoAwal;

class NeracaSaldoAwalRepo
{
    public $akun_id;
    public $default_field;
    public $saldo;
    public function __construct($akun_id, $default_field, $saldo)
    {
        $this->akun_id = $akun_id;
        $this->default_field = $default_field;
        $this->saldo = $saldo;
    }

    private function create()
    {
        return NeracaSaldoAwal::create([
            'active_cash' => get_closed_cash(),
            'akun_id' => $this->akun_id,
            $this->default_field => $this->saldo
        ]);
    }

    public function mainUpdateDebet()
    {
        $ns = NeracaSaldoAwal::where('active_cash', get_closed_cash())
            ->where('akun_id', $this->akun_id);
        if (is_null($ns)){
            return $this->create();
        }
        if ($this->default_field != 'debet'){
            return $ns->decrement($this->default_field, $this->saldo);
        }
        return $ns->increment($this->default_field, $this->saldo);
    }

    public function mainUpdateKredit()
    {
        $ns = NeracaSaldoAwal::where('active_cash', get_closed_cash())
            ->where('akun_id', $this->akun_id);
        if (is_null($ns)){
            return $this->create();
        }
        if ($this->default_field != 'kredit'){
            return $ns->decrement($this->default_field, $this->saldo);
        }
        return $ns->increment($this->default_field, $this->saldo);
    }

    public function mainUpdate()
    {
        $ns = NeracaSaldoAwal::where('active_cash', get_closed_cash())
            ->where('akun_id', $this->akun_id);
        if (!is_null($ns)){
            return $ns->increment($this->default_field, $this->saldo);
        }
        return NeracaSaldoAwal::create([
            'active_cash' => get_closed_cash(),
            'akun_id' => $this->akun_id,
            $this->default_field => $this->saldo
        ]);
    }

    public function mainRollback()
    {
        return NeracaSaldoAwal::where('active_cash', get_closed_cash())
            ->where('akun_id', $this->akun_id)
            ->decrement($this->default_field, $this->saldo);
    }

    public function rollbackDebet()
    {
        $ns = NeracaSaldoAwal::where('active_cash', get_closed_cash())
            ->where('akun_id', $this->akun_id);
        if ($this->default_field != 'debet'){
            return $ns->increment($this->default_field, $this->saldo);
        }
        return $ns->decrement($this->default_field, $this->saldo);
    }

    public function rollbackKredit()
    {
        $ns = NeracaSaldoAwal::where('active_cash', get_closed_cash())
            ->where('akun_id', $this->akun_id);
        if ($this->default_field != 'kredit'){
            return $ns->increment($this->default_field, $this->saldo);
        }
        return $ns->decrement($this->default_field, $this->saldo);
    }
}
