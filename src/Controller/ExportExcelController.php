<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Writer\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class ExportExcelController extends AbstractController
{

    /**
     * permet de recupérer les éléments de l'api
     */
    private function getData(HttpClientInterface $httpClient): array
    {
        $mesures_tempvar = $httpClient->request('GET', 'http://10.0.5.154/api/temperatures');
        $mesureTvar = [];
        foreach ($mesures_tempvar->toArray()["hydra:member"] as $mesure) {

            if (is_array($mesure) && isset($mesure["data"]) && isset($mesure["date"])) {

                if (is_array($mesure) && isset($mesure["data"]) && isset($mesure["date"])) {
                    $mesureTvar[] = [
                        'data' => $mesure["data"],
                        'date' => date("m-d H:i", strtotime($mesure["date"])),
                    ];
                }
            }
        }
        return $mesureTvar;
    }

    /**
     * Permet à l'admin de pouvoir exporter son panier au format excel
     * @Route("/excel",  name="excel")
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function export(HttpClientInterface $httpClient, Request $request): BinaryFileResponse
    {
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setTitle('Données');
        $spreadsheet->getActiveSheet()->getStyle('B2')
            ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('B2:D2')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('90EE90');
        $spreadsheet->getActiveSheet()->getStyle('B2')->getFont()->setSize(18);
        $spreadsheet->getActiveSheet()->getStyle('C2')->getFont()->setSize(15);
        $spreadsheet->getActiveSheet()->getStyle('D2')->getFont()->setSize(15);
        $spreadsheet->getActiveSheet()->getRowDimension('2')->setRowHeight(30);
        $spreadsheet->getActiveSheet()->getRowDimension('15')->setRowHeight(7);
        $spreadsheet->getActiveSheet()->getRowDimension('18')->setRowHeight(4);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth('20');
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth('10');
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth('15');
        $sheet->getCell('B2')->setValue('Température');
        $sheet->getCell('C2')->setValue('Valeur');
        $sheet->getCell('D2')->setValue('Date');

        // incrémente le curseur après avoir écrit l'en-tête
        $sheet->fromArray($this->getData($httpClient), null, 'C3', true);

        $writer = new Xlsx($spreadsheet);

        $fileName = 'Excel.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);
        $writer->save($temp_file);
        $writer->save($temp_file);

        return $this->file($temp_file, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);
    }
}