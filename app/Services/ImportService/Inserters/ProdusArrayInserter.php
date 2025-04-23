<?php

namespace App\Services\ImportService\Inserters;

use App\Models\Produs;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


class ProdusArrayInserter
{
    public $arrayToInsert =[];

    public function __construct($row)
    {
        $array = $row->getCells();

        $this->arrayToInsert['nume'] = $array[0]->getValue();
        $this->arrayToInsert['url_imagine'] = $array[1]->getValue();
        $this->arrayToInsert['categorie'] = $array[2]->getValue();
        $this->arrayToInsert['ean'] = $array[3]->getValue();
        $this->arrayToInsert['sku'] = $array[4]->getValue();
        $this->arrayToInsert['pret_fara_tva'] = (float) str_replace(",", ".", $array[5]->getValue());
        $this->arrayToInsert['stoc'] = $array[6]->getValue();
        $this->arrayToInsert['brand'] = $array[7]->getValue();
        $this->arrayToInsert['descriere'] = $array[8]->getValue();
        $this->arrayToInsert['atribute_produs'] = $array[9]->getValue();
        $this->arrayToInsert['pret_pj_1'] = $array[10]->getValue();

        $this->arrayToInsert['new'] = false;
        $this->arrayToInsert['stock_update'] = false;
        $this->arrayToInsert['price_update'] = false;

    }
    public function valid()
    {
        $validator = Validator::make($this->arrayToInsert, [
            'nume' => 'required',
            'url_imagine' => 'required',
            'categorie' => '',
            'ean' => '',
            'sku'=> 'required',
            'pret_fara_tva' => 'required',
            'stoc' => '',
            'brand' => '',
            'descriere' => '',
            'atribute_produs' => '',
            'pret_pj_1' => ''
        ]);


        foreach ($validator->errors()->all() as $error) {
            Log::channel('import_feed')->error($error);
        }

        if ($validator->fails()) {
            return false;
        }
        return true;
    }

    public function insertInDb()
    {
        try{
            $product = Produs::where('sku', $this->arrayToInsert['sku'])->first();
            if (empty($product)) {
                $this->makeNewProdus();
            } else {
                $this->updateProdus($product);
            }

        }catch (\Exception $exception){
            print_r($exception->getMessage());
        }
    }

    private function makeNewProdus()
    {
        $this->arrayToInsert['new'] = true;
        $produs = Produs::create($this->arrayToInsert);
        $produs->save();
        Log::channel('import_feed')->info("Inserted new product with sku: {$this->arrayToInsert['sku']}");
    }

    private function updateProdus($produs)
    {
        if ($produs->stoc != $this->arrayToInsert['stoc']){
            $this->arrayToInsert['stock_update'] = true;
        }

        if ($produs->pret_fara_tva != $this->arrayToInsert['pret_fara_tva']){
            $this->arrayToInsert['price_update'] = true;
        }

        $this->arrayToInsert['new'] = false;
        $produs->update($this->arrayToInsert);
        $produs->save();
        Log::channel('import_feed')->info("Updated new product with sku: {$this->arrayToInsert['sku']}");
    }


}
