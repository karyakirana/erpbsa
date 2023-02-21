<?php namespace App\ERP\Master;

use App\Models\Master\Customer;

class CustomerService implements MasterInterface
{
    public function kode()
    {
        $customer = new Customer();
        return master_kode_helper($customer, 'C');
    }

    public function getDataById($id)
    {
        \DB::beginTransaction();
        try {
            $data = Customer::with([
                'kota', 'sales'
            ])->find($id);
            return commit_helper($data);
        } catch (\Exception $e){
            return exception_rollback_helper($e);
        }
    }

    public function getData()
    {
        \DB::beginTransaction();
        try {
            $data = Customer::with([
                'kota', 'sales'
            ])->get();
            return commit_helper($data);
        } catch (\Exception $e){
            return exception_rollback_helper($e);
        }
    }

    public function getDataIncludeDestroy($active_cash = true)
    {
        // TODO: Implement getDataIncludeDestroy() method.
    }

    public function store(array $data)
    {
        \DB::beginTransaction();
        try {
            $data['kode'] = $this->kode();
            $customer = Customer::create($data);
            return commit_helper($customer);
        } catch (\Exception $e){
            return exception_rollback_helper($e);
        }
    }

    public function update(array $data)
    {
        \DB::beginTransaction();
        try {
            $customer = Customer::find($data['customer_id']);
            $customer->update($data);
            return commit_helper($customer->refresh());
        } catch (\Exception $e){
            return exception_rollback_helper($e);
        }
    }

    public function softDestroy($id)
    {
        \DB::beginTransaction();
        try {
            $data = Customer::destroy($id);
            return commit_helper($data);
        } catch (\Exception $e){
            return exception_rollback_helper($e);
        }
    }

    public function restoreDestroy($id)
    {
        // TODO: Implement restoreDestroy() method.
    }

    public function destroy($id)
    {
        // TODO: Implement destroy() method.
    }
}
