<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {
    /*
      public function view($page="home")
      {

      if ( ! file_exists(APPPATH.'/views/admin/'.$page.'.php'))
      {
      show_404();
      }

      $data['siteTitle'] = "The NewsletterPro";
      $data['title'] = "Admin - " . ucfirst($page); // Capitalize the first letter
      $data['assets'] = asset_url();

      $this->load->model('Admin_model');

      $this->load->view('templates/header', $data);
      $this->load->view('admin/'.$page, $data);
      $this->load->view('templates/footer', $data);
      }
     */

    public function view($id = null) {
        $data['siteTitle'] = "The NewsletterPro";
        $data['title'] = "Admin - Reports";
        $data['assets'] = asset_url();

        if (is_null($id)) {
            $this->load->view('templates/header', $data);
            $this->load->view('Reports/reports', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $this->load->model('Report_model');
            $data['total'] = false;
            $data['reportid'] = $id;
            switch ($id) {
                case '1':
                    $data['report'] = $this->Report_model->getActiveClients();
                    $data['title'] = $data['title'] . " - Active Clients";
                    break;

                case '2':
                    $data['report'] = $this->Report_model->getCancelledClients();
                    $data['title'] = $data['title'] . " - Cancelled Clients";
                    break;

                case '3':
                    $data['report'] = $this->Report_model->getOnHoldClients();
                    $data['title'] = $data['title'] . " - On Hold Clients";
                    break;

                case '4':
                    $data['report'] = $this->Report_model->getCampaignsBilled();
                    $data['title'] = $data['title'] . " - Campaigns Billed";
                    $data['total'] = true;
                    break;

                case '5':
                    $data['report'] = $this->Report_model->getPiecesMailed();
                    $data['title'] = $data['title'] . " - Pieces Mailed";
                    $data['total'] = true;
                    break;

                case '6':
                    $data['report'] = $this->Report_model->getVersions();
                    $data['title'] = $data['title'] . " - Versions";
                    $data['total'] = true;
                    break;

                case '7':
                    $data['report'] = $this->Report_model->getClientAuditList();
                    $data['title'] = $data['title'] . " - Client Audit List";
                    break;

                default:
                    $data['report'] = null;
                    break;
            }
            $data['loadExports'] = true;
            $this->load->view('templates/header', $data);
            $this->load->view('Reports/reports-output', $data);
            $this->load->view('templates/footer', $data);
        }
    }

}
