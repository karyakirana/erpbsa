<?php namespace App\ERP\Keuangan;

class JurnalTransaksiService
{
    public static function jurnalWithNeracaAwalDebet($modelTransaksi, $coaDebet, $nominalDebet, $default_field)
    {
        $modelTransaksi->create([
            'active_cash' => get_closed_cash(),
            'akun_id' => $coaDebet,
            'debet' => $nominalDebet
        ]);
        /** neraca saldo awal */
        (new NeracaSaldoAwalRepo($coaDebet, $default_field, $nominalDebet))->mainUpdateDebet();
        /** neraca saldo */
        (new NeracaSaldoRepo($coaDebet, $default_field, $nominalDebet))->mainUpdateDebet();
    }

    public static function jurnalWithNeracaAwalKredit($modelTransaksi, $coaKredit, $nominalKredit, $default_field)
    {
        $modelTransaksi->create([
            'active_cash' => get_closed_cash(),
            'akun_id' => $coaKredit,
            'kredit' => $nominalKredit
        ]);
        /** neraca saldo awal */
        (new NeracaSaldoAwalRepo($coaKredit, $default_field, $nominalKredit))->mainUpdateKredit();
        /** neraca saldo */
        (new NeracaSaldoRepo($coaKredit, $default_field, $nominalKredit))->mainUpdateKredit();
    }

    public static function jurnalDebet($modelTransaksi, $coaDebet, $nominalDebet, $default_field)
    {
        $modelTransaksi->create([
            'active_cash' => get_closed_cash(),
            'akun_id' => $coaDebet,
            'debet' => $nominalDebet
        ]);
        /** neraca saldo */
        (new NeracaSaldoRepo($coaDebet, $default_field, $nominalDebet))->mainUpdateDebet();
    }

    public static function jurnalKredit($modelTransaksi, $coaKredit, $nominalKredit, $default_field)
    {
        $modelTransaksi->create([
            'active_cash' => get_closed_cash(),
            'akun_id' => $coaKredit,
            'kredit' => $nominalKredit
        ]);
        /** neraca saldo */
        (new NeracaSaldoRepo($coaKredit, $default_field, $nominalKredit))->mainUpdateKredit();
    }

    public static function jurnalWithNeracaAwalRollback($modelTransaksi, $default_field_debet, $default_field_kredit)
    {
        foreach($modelTransaksi->jurnal as $row){
            if ($row->debet > 0){
                /** neraca saldo awal */
                (new NeracaSaldoAwalRepo($row->akun_id, $default_field_debet, $row->debet))->rollbackDebet();
                /** neraca saldo */
                (new NeracaSaldoRepo($row->akun_id, $default_field_debet, $row->debet))->rollbackDebet();
            }

            if ($row->kredit > 0){
                /** neraca saldo awal */
                (new NeracaSaldoAwalRepo($row->akun_id, $default_field_kredit, $row->debet))->rollbackKredit();
                /** neraca saldo */
                (new NeracaSaldoRepo($row->akun_id, $default_field_kredit, $row->debet))->rollbackKredit();
            }
        }
        return $modelTransaksi->jurnal()->delete();
    }

    public static function jurnalRollback($modelTransaksi, $default_field_debet, $default_field_kredit)
    {
        foreach($modelTransaksi->jurnal as $row){
            if ($row->debet > 0){
                /** neraca saldo */
                (new NeracaSaldoRepo($row->akun_id, $default_field_debet, $row->debet))->rollbackDebet();
            }

            if ($row->kredit > 0){
                /** neraca saldo */
                (new NeracaSaldoRepo($row->akun_id, $default_field_kredit, $row->debet))->rollbackKredit();
            }
        }
        return $modelTransaksi->jurnal()->delete();
    }

}
