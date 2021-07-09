<?php

namespace App\Http\Controllers;

use App\Models\Ukm;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class FixingDataController extends Controller
{
    public function mappingKelurahan(){
        $match_ukm = [];

        try{
            DB::beginTransaction();

            $ukm = DB::select("
                SELECT id, nik, nama_usaha, nama_pemilik
                FROM ukm_disdag.ukm
            ");
            $ukm_elocal = DB::select("
                SELECT ukm_nik, ukm_klh_id, ukm_nama, ukm_pemilik
                FROM elocal.ukm
            ");

            for ($i=0; $i < count($ukm); $i++) {
                for ($j=0; $j < count($ukm_elocal); $j++) {
                    if ($ukm[$i]->nik == $ukm_elocal[$j]->ukm_nik && $ukm_elocal[$j]->ukm_klh_id != null) {
                        $res['ukm_disdag'] = $ukm[$i];
                        $res['elocal'] = $ukm_elocal[$j];
                        array_push($match_ukm, $res);

                        Ukm::where('id', $ukm[$i]->id)->update(array('kelurahan_id' => $ukm_elocal[$j]->ukm_klh_id));
                    }
                }
            }

            DB::commit();
            echo json_encode($match_ukm);
        } catch(Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function compareUKM(){
        $path = storage_path() . "/compare_nik/ukm.xlsx";
        $spreadsheet_elocal = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);
        $spreadsheet_elocal->setActiveSheetIndex(1);
        $elocal = $spreadsheet_elocal->getActiveSheet()->rangeToArray('B2:AR962',NULL,TRUE,TRUE,TRUE);

        $spreadsheet_pameran_1 = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);
        $spreadsheet_pameran_1->setActiveSheetIndex(2);
        $pameran_1 = $spreadsheet_pameran_1->getActiveSheet()->rangeToArray('A1:H154',NULL,TRUE,TRUE,TRUE);

        $spreadsheet_pameran_2 = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);
        $spreadsheet_pameran_2->setActiveSheetIndex(3);
        $pameran_2 = $spreadsheet_pameran_2->getActiveSheet()->rangeToArray('B7:N160',NULL,TRUE,TRUE,TRUE);

        $data_elocal = [];
        foreach($elocal as $elocal_value){
            array_push($data_elocal, $elocal_value);
        }

        $data_pameran_1 = [];
        foreach($pameran_1 as $pameran_1_value){
            array_push($data_pameran_1, $pameran_1_value);
        }

        $data_pameran_2 = [];
        foreach($pameran_2 as $pameran_2_value){
            array_push($data_pameran_2, $pameran_2_value);
        }

        $same_data = [];
        $final = [];
        for ($i=0; $i < count($data_elocal); $i++) {
            $status = true;
            for ($j=0; $j < count($data_pameran_1); $j++) {
                if ($data_elocal[$i]['D'] == $data_pameran_1[$j]['F']) {
                    $status = false;
                    array_push($same_data, $data_elocal[$i]);
                }
            }

            for ($k=0; $k < count($data_pameran_2); $k++) {
                if ($data_elocal[$i]['D'] == $data_pameran_2[$k]['D']) {
                    $status = false;
                    array_push($same_data, $data_elocal[$i]);
                }
            }

            if($status == true){
                array_push($final, $data_elocal[$i]);
            }
        }

        $this->exportExcel($final);
    }

    function exportExcel($data){
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', "No");
        $sheet->setCellValue('B1', "Nama UKM");
        $sheet->setCellValue('C1', "Nama Pemilik");
        $sheet->setCellValue('D1', "NIK");
        $sheet->setCellValue('E1', "Alamat");
        $sheet->setCellValue('F1', "Kecamatan");
        $sheet->setCellValue('G1', "Kelurahan");
        $sheet->setCellValue('H1', "Telepon");
        $sheet->setCellValue('I1', "SIUP");
        $sheet->setCellValue('J1', "NPWP");

        $i = 2;
        $no = 1;
        foreach ($data as $ukm) {
            $sheet->setCellValue('A'.$i, $no);
            $sheet->setCellValue('B'.$i, $ukm['C']);
            $sheet->setCellValue('C'.$i, $ukm['E']);
            $sheet->setCellValue('D'.$i, "'" . $ukm['D']);
            $sheet->setCellValue('E'.$i, $ukm['J']);
            $sheet->setCellValue('F'.$i, $ukm['AR']);
            $sheet->setCellValue('G'.$i, $ukm['AQ']);
            $sheet->setCellValue('H'.$i, "'" . $ukm['I']);
            $sheet->setCellValue('I'.$i, $ukm['B']);
            $sheet->setCellValue('J'.$i, "'" . $ukm['AN']);

            $i++;
            $no++;
        }

       $filename = "HASIL.xlsx";
       $writer = new Xlsx($spreadsheet);
       header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
       header('Content-Disposition: attachment; filename="'. urlencode($filename).'"');
       $writer->save('php://output');
    }
}
