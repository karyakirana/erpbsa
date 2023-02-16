<?php namespace App\ERP\Stock;

use App\ERP\Keuangan\CoaTrait;
use App\ERP\Keuangan\NeracaSaldoRepo;
use App\ERP\Keuangan\NeracaSaldoAwalRepo;
use App\Models\Akuntansi\CoaConfig;
use App\Models\Keuangan\JurnalTransaksi;
use App\Models\Stock\Persediaan;
use App\Models\Stock\PersediaanAwal;

class PersediaanAwalRepository
{
    use CoaTrait;

    private $coa_persediaan_awal_id, $coa_default_field_pers_awal;
    private $coa_modal_id, $coa_default_field_modal;

    // load configurasi jurnal
    public function __construct()
    {
        $coa_persediaan_awal = $this->getCoaConfig('persediaan_awal');
        $this->coa_persediaan_awal_id = $coa_persediaan_awal->akun_id;
        $this->coa_default_field_pers_awal = $coa_persediaan_awal->default_field;
        $coa_modal = $this->getCoaConfig('modal');
        $this->coa_modal_id = $coa_modal->akun_id;
        $this->coa_default_field_modal = $coa_modal->default_field;
    }

    // generate kode
    public function kode($kondisi="baik")
    {
        $query = PersediaanAwal::query()
            ->where('active_cash', get_closed_cash())
            ->where('kondisi', $kondisi)
            ->latest('kode');

        $kodeKondisi = ($kondisi == 'baik') ? 'PA' : 'PAR';

        // check last num
        if ($query->doesntExist()){
            return "0001/{$kodeKondisi}/".date('Y');
        }

        $num = (int) $query->first()->last_num_trans + 1;
        return sprintf("%04s", $num)."/{$kodeKondisi}/".date('Y');
    }
    // get persediaan awal
    public function handleGet()
    {
        return PersediaanAwal::with([
            'lokasi',
            'users',
            'persediaanAwalDetail',
            'persediaanAwalDetail.persediaan',
            'persediaanAwalDetail.persediaan.produk'
        ])
            ->where('active_cash', get_closed_cash())
            ->get();
    }
    // edit persediaan awal
    public function handleEdit($persediaan_awal_id)
    {
        return PersediaanAwal::with([
            'lokasi',
            'users',
            'persediaanAwalDetail',
            'persediaanAwalDetail.persediaan',
            'persediaanAwalDetail.persediaan.produk'
        ])->find($persediaan_awal_id);
    }
    // store persediaan awal
    public function handleStore(array $data)
    {
        // store transaction
        $data['active_cash'] = get_closed_cash();
        $data['kode'] = $this->kode($data['kondisi']);
        $persediaanAwal = PersediaanAwal::create($data);
        // store transaction detail
        return $this->storeTransactionDetail($data['persediaan_awal_detail'], $persediaanAwal);
    }

    // update persediaan awal
    public function handleUpdate(array $data)
    {
        $persediaanAwal = PersediaanAwal::find($data['persediaan_awal_id']);

        // rollback persediaan
        foreach ($persediaanAwal->persediaanAwalDetail as $item){
            PersediaanRepository::rollbackStockMasuk($item->id, $item->jumlah, 'stock_awal');
        }
        $persediaanAwal->persediaanAwalDetail()->delete();
        $persediaanAwal->jurnal()->delete();

        // store neraca saldo awal
        (new NeracaSaldoAwalRepo($this->coa_persediaan_awal_id, $this->coa_default_field_pers_awal, $persediaanAwal->total_nominal))->mainRollback();
        (new NeracaSaldoAwalRepo($this->coa_modal_id, $this->coa_default_field_modal, $persediaanAwal->total_nominal))->mainRollback();
        // store neraca saldo update persediaan awal
        (new NeracaSaldoRepo($this->coa_persediaan_awal_id, $this->coa_default_field_pers_awal, $persediaanAwal->total_nominal))->mainRollback();
        (new NeracaSaldoRepo($this->coa_modal_id, $this->coa_default_field_modal, $persediaanAwal->total_nominal))->mainRollback();

        // update
        $persediaanAwal->update($data);
        $persediaanAwal = $persediaanAwal->refresh();
        // store transaction detail
        return $this->storeTransactionDetail($data['persediaan_awal_detail'], $persediaanAwal);
    }

    /**
     * @param $persediaan_awal_detail
     * @param PersediaanAwal $persediaanAwal
     * @return PersediaanAwal
     */
    protected function storeTransactionDetail($persediaan_awal_detail, PersediaanAwal $persediaanAwal): PersediaanAwal
    {
        foreach ($persediaan_awal_detail as $row) {
            // store persediaan
            $persediaanRepo = new PersediaanRepository(
                $row['produk_id'],
                $persediaanAwal->lokasi_id,
                $persediaanAwal->kondisi,
                $row['jumlah'],
                $row['batch'],
                $row['expired'],
                $row['serial_number'],
                $row['harga'],
                'stock_awal'
            );
            $persediaan = $persediaanRepo->addStockMasuk();
            // store persediaan awal detail
            $persediaanAwal->persediaanAwalDetail()->create([
                'persediaan_id' => $persediaan->id,
                'harga_beli' => $row['harga'],
                'jumlah' => $row['jumlah'],
                'sub_total' => $row['sub_total']
            ]);
        }
        // store jurnal debet
        $persediaanAwal->jurnal()->create([
            'active_cash' => get_closed_cash(),
            'akun_id' => $this->coa_persediaan_awal_id,
            'debet' => $persediaanAwal->total_nominal
        ]);
        $persediaanAwal->jurnal()->create([
            'active_cash' => get_closed_cash(),
            'akun_id' => $this->coa_modal_id,
            'debet' => $persediaanAwal->total_nominal
        ]);
        // store neraca saldo awal
        (new NeracaSaldoAwalRepo($this->coa_persediaan_awal_id, $this->coa_default_field_pers_awal, $persediaanAwal->total_nominal))->mainUpdate();
        (new NeracaSaldoAwalRepo($this->coa_modal_id, $this->coa_default_field_modal, $persediaanAwal->total_nominal))->mainUpdate();
        // store neraca saldo update persediaan awal
        (new NeracaSaldoRepo($this->coa_persediaan_awal_id, $this->coa_default_field_pers_awal, $persediaanAwal->total_nominal))->mainUpdate();
        (new NeracaSaldoRepo($this->coa_modal_id, $this->coa_default_field_modal, $persediaanAwal->total_nominal))->mainUpdate();
        return $persediaanAwal->refresh();
    }
}
