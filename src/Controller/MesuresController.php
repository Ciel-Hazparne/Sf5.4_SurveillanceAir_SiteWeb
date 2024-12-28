<?php

namespace App\Controller;

use DateTime;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Date;
use App\Form\DateType;

class MesuresController extends AbstractController
{


    /**
     * @Route("/temperature", name="temperature")
     * @return Response
     */

    public function temperature(ChartBuilderInterface $chartBuilder, HttpClientInterface $httpClient, Request $request): Response
    {

        $MesureDate = new Date();
        $form = $this->createForm(DateType::class, $MesureDate);
        $form->handleRequest($request);

        $mesures_tempvar = $httpClient->request('GET', 'http://10.0.5.154/api/temperatures');

        $data_temp = [];
        $labels_temp = [];


        if (isset($_GET['Submit'])) {
            //Valeurs du Formulaire

            $date_min = new \DateTime($_GET["DateMin"]);
            $date_max = new \DateTime($_GET["DateMax"]);

            foreach ($mesures_tempvar->toArray()["hydra:member"] as $mesure) {

                if (is_array($mesure) && isset($mesure["data"]) && isset($mesure["date"])) {

                    if (new \DateTime($mesure["date"]) > $date_min && new \DateTime($mesure["date"]) < $date_max) {
                        $data_temp[] = $mesure["data"];
                        $labels_temp[] = date("m-d H:i", strtotime($mesure["date"]));
                    }
                }
            }
            //temperature champ
            $chart_temp = $chartBuilder->createChart(Chart::TYPE_LINE);
            $chart_temp->setData([
                'labels' => $labels_temp,//axe des abscisses X(heure des données)
                'datasets' => [
                    [
                        'label' => 'temperature champ', //nom du graphique
                        'backgroundColor' => 'rgb(100, 155, 125)', //couleur du fond du graphique
                        'borderColor' => 'rgb(255, 255, 255)',  //couleur des bords du graphique
                        'data' => $data_temp //axe des ordonnées Y (mesure)
                    ],
                ],
            ]);

            $chart_temp->setOptions([
                'scales' => [
                    'yAxes' => [
                        ['ticks' => ['min' => 0, 'max' => 100]],//taille de l'axe
                    ],
                ],
            ]);

            return $this->render('mesures/temperature.html.twig', [
                'chart1' => $chart_temp,
                'a' => 1]);

        } else {
            //Valeurs par défaut

            $date_min = new \DateTime("2020-03-02");
            $date_max = new \DateTime("2025-03-01");

            return $this->render('mesures/temperature.html.twig', ['a' => 0]);
        }
    }

    /**
     * @Route("/humidite", name="humidite")
     * @return Response
     */

    public function humidite(ChartBuilderInterface $chartBuilder, HttpClientInterface $httpClient, Request $request): Response
    {

        $MesureDate = new Date();
        $form = $this->createForm(DateType::class, $MesureDate);
        $form->handleRequest($request);

       $mesures_humidity = $httpClient->request('GET', 'http://10.0.5.154/api/c_o_vs');


        $data_humidity = [];
        $labels_humidity = [];



        if (isset($_GET['Submit'])) {
            //Valeurs du Formulaire

            $date_min = new \DateTime($_GET["DateMin"]);
            $date_max = new \DateTime($_GET["DateMax"]);

            foreach ($mesures_humidity->toArray()["hydra:member"] as $mesure) {

                if (is_array($mesure) && isset($mesure["data"]) && isset($mesure["date"])) {

                    if (new \DateTime($mesure["date"]) > $date_min && new \DateTime($mesure["date"]) < $date_max) {
                        $data_humidity[] = $mesure["data"];
                        $labels_humidity[] = date("m-d H:i", strtotime($mesure["date"]));
                    }
                }
            }

            //humidite champ
            $chart_humidity = $chartBuilder->createChart(Chart::TYPE_LINE);
            $chart_humidity->setData([
                'labels' => $labels_humidity,//axe des abscisses X(heure des données)
                'datasets' => [
                    [
                        'label' => 'humidite champ', //nom du graphique
                        'backgroundColor' => 'rgb(100, 155, 125)', //couleur du fond du graphique
                        'borderColor' => 'rgb(255, 255, 255)',  //couleur des bords du graphique
                        'data' => $data_humidity //axe des ordonnées Y (mesure)
                    ],
                ],
            ]);

            $chart_humidity->setOptions([
                'scales' => [
                    'yAxes' => [
                        ['ticks' => ['min' => 0, 'max' => 100]],//taille de l'axe
                    ],
                ],
            ]);

            return $this->render('mesures/humidite.html.twig', [
                'chart2' => $chart_humidity,
                'b' => 1]);

        } else {
            //Valeurs par défaut

            $date_min = new \DateTime("2020-03-02");
            $date_max = new \DateTime("2025-03-01");

            return $this->render('mesures/humidite.html.twig', ['b' => 0]);
        }
    }
    /**
     * @Route("/cov", name="cov")
     * @return Response
     */

    public function cov(ChartBuilderInterface $chartBuilder, HttpClientInterface $httpClient, Request $request): Response
    {

        $MesureDate = new Date();
        $form = $this->createForm(DateType::class, $MesureDate);
        $form->handleRequest($request);

        $mesures_CoV = $httpClient->request('GET', 'http://10.0.5.154/api/hygrometries');

        $data_cov = [];
        $labels_cov = [];


        if (isset($_GET['Submit'])) {
            //Valeurs du Formulaire

            $date_min = new \DateTime($_GET["DateMin"]);
            $date_max = new \DateTime($_GET["DateMax"]);

            foreach ($mesures_CoV->toArray()["hydra:member"] as $mesure) {

                if (is_array($mesure) && isset($mesure["data"]) && isset($mesure["date"])) {

                    if (new \DateTime($mesure["date"]) > $date_min && new \DateTime($mesure["date"]) < $date_max) {
                        $data_cov[] = $mesure["data"];
                        $labels_cov[] = date("m-d H:i", strtotime($mesure["date"]));
                    }
                }
            }

            //cov champ
            $chart_cov = $chartBuilder->createChart(Chart::TYPE_LINE);
            $chart_cov->setData([
                'labels' => $labels_cov,//axe des abscisses X(heure des données)
                'datasets' => [
                    [
                        'label' => 'COV champ', //nom du graphique
                        'backgroundColor' => 'rgb(100, 155, 125)', //couleur du fond du graphique
                        'borderColor' => 'rgb(255, 255, 255)',  //couleur des bords du graphique
                        'data' => $data_cov //axe des ordonnées Y (mesure)
                    ],
                ],
            ]);

            $chart_cov->setOptions([
                'scales' => [
                    'yAxes' => [
                        ['ticks' => ['min' => 0, 'max' => 100]],//taille de l'axe
                    ],
                ],
            ]);

            return $this->render('mesures/cov.html.twig', [
                'chart3' => $chart_cov,
                'c' => 1]);

        } else {
            //Valeurs par défaut

            $date_min = new \DateTime("2020-03-02");
            $date_max = new \DateTime("2025-03-01");

            return $this->render('mesures/cov.html.twig', ['c' => 0]);
        }
    }

    /**
     * @Route("/co2", name="co2")
     * @return Response
     */

    public function co2(ChartBuilderInterface $chartBuilder, HttpClientInterface $httpClient, Request $request): Response
    {

        $MesureDate = new Date();
        $form = $this->createForm(DateType::class, $MesureDate);
        $form->handleRequest($request);

        $mesures_co2 = $httpClient->request('GET', 'http://10.0.5.154/api/c_o2s');

        $data_co2 = [];
        $labels_co2 = [];


        if (isset($_GET['Submit'])) {
            //Valeurs du Formulaire

            $date_min = new \DateTime($_GET["DateMin"]);
            $date_max = new \DateTime($_GET["DateMax"]);

            foreach ($mesures_co2->toArray()["hydra:member"] as $mesure) {

                if (is_array($mesure) && isset($mesure["data"]) && isset($mesure["date"])) {

                    if (new \DateTime($mesure["date"]) > $date_min && new \DateTime($mesure["date"]) < $date_max) {
                        $data_co2[] = $mesure["data"];
                        $labels_co2[] = date("m-d H:i", strtotime($mesure["date"]));
                    }
                }
            }

            //cov champ
            $chart_co2 = $chartBuilder->createChart(Chart::TYPE_LINE);
            $chart_co2->setData([
                'labels' => $labels_co2,//axe des abscisses X(heure des données)
                'datasets' => [
                    [
                        'label' => 'CO2 champ', //nom du graphique
                        'backgroundColor' => 'rgb(100, 155, 125)', //couleur du fond du graphique
                        'borderColor' => 'rgb(255, 255, 255)',  //couleur des bords du graphique
                        'data' => $data_co2 //axe des ordonnées Y (mesure)
                    ],
                ],
            ]);

            $chart_co2->setOptions([
                'scales' => [
                    'yAxes' => [
                        ['ticks' => ['min' => 0, 'max' => 2000]],//taille de l'axe
                    ],
                ],
            ]);

            return $this->render('mesures/co2.html.twig', [
                'chart4' => $chart_co2,
                'd' => 1]);

        } else {
            //Valeurs par défaut

            $date_min = new \DateTime("2020-03-02");
            $date_max = new \DateTime("2025-03-01");

            return $this->render('mesures/co2.html.twig', ['d' => 0]);
        }
    }

    /**
     * @Route("/courbe", name="courbe")
     * @return Response
     */

    public
    function courbe(): Response
    {
        return $this->render('courbe/courbe.html.twig', ['current_menu' => 'courbe',]);
    }
}

