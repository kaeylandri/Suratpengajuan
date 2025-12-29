<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test_wa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Nonaktifkan jika bukan di development
        if (ENVIRONMENT === 'production') {
            show_404();
        }
    }
    
    public function index()
    {
        echo "<h2>🔧 Test WhatsApp Notification System</h2>";
        
        $this->load->library('whatsapp');
        $this->load->model('Whatsapp_model', 'wa_model');
        
        echo "<h3>1. Test Connection:</h3>";
        $test_result = $this->whatsapp->test_connection('6282119509135'); // Ganti dengan nomor test
        echo "<pre>";
        print_r($test_result);
        echo "</pre>";
        
        echo "<h3>2. Get Admin Numbers from Database:</h3>";
        $admin_numbers = $this->wa_model->get_admin_numbers();
        echo "<pre>";
        print_r($admin_numbers);
        echo "</pre>";
        
        echo "<h3>3. Test Message Format:</h3>";
        $test_message = $this->whatsapp->format_simple_message(
            999, 
            'Pelatihan Programming', 
            'Kelompok', 
            date('d/m/Y H:i:s')
        );
        echo "<textarea style='width:100%;height:150px;font-family:monospace;'>" . 
             htmlspecialchars($test_message) . "</textarea>";
        
        echo "<h3>4. Test Send to Admin (optional):</h3>";
        echo "<p><a href='" . site_url('test_wa/send_test') . "' class='btn btn-primary'>Test Send Broadcast</a></p>";
        
        echo "<h3>5. Check Logs:</h3>";
        $this->db->select('*');
        $this->db->from('whatsapp_logs');
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit(10);
        $logs = $this->db->get()->result_array();
        
        echo "<pre>";
        print_r($logs);
        echo "</pre>";
    }
    
    public function send_test()
    {
        $this->load->library('whatsapp');
        $this->load->model('Whatsapp_model', 'wa_model');
        
        $admin_numbers = $this->wa_model->get_admin_numbers();
        
        if (empty($admin_numbers)) {
            $this->config->load('whatsapp', true);
            $admin_numbers = $this->config->item('admin_numbers', 'whatsapp') ?? [];
        }
        
        if (empty($admin_numbers)) {
            echo "No admin numbers found!";
            return;
        }
        
        $message = "📢 *TEST NOTIFIKASI SISTEM SURAT*\n\n";
        $message .= "Ini adalah pesan test dari sistem.\n";
        $message .= "Waktu: " . date('d/m/Y H:i:s') . "\n";
        $message .= "Status: ✅ Sistem WhatsApp berfungsi\n\n";
        $message .= "_Ignore this test message_";
        
        echo "<h3>Broadcast Test to " . count($admin_numbers) . " numbers:</h3>";
        echo "<pre>Numbers: ";
        print_r($admin_numbers);
        echo "</pre>";
        
        echo "<h4>Message:</h4>";
        echo "<textarea style='width:100%;height:100px;'>" . $message . "</textarea>";
        
        $result = $this->whatsapp->broadcast($admin_numbers, $message);
        
        echo "<h4>Result:</h4>";
        echo "<pre>";
        print_r($result);
        echo "</pre>";
        
        // Save log
        $this->wa_model->save_log([
            'surat_id' => 0,
            'message_type' => 'test',
            'recipient_count' => $result['total'],
            'message' => $message,
            'status' => ($result['success'] > 0) ? 'sent' : 'failed',
            'response' => $result
        ]);
        
        echo "<br><a href='" . site_url('test_wa') . "'>← Back to Test Page</a>";
    }
}